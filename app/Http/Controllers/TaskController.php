<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = $this->getTasks();
        return Inertia::render('Tasks', ['tasks' => $tasks]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'description' => 'required|string|max:255',
            'due_date' => 'nullable|date'
        ]);

        Task::create([
            'description' => $request->description,
            'due_date' => $request->due_date,
            'user_id' => auth()->id(),
        ]);

        $tasks = $this->getTasks();

        return Inertia::render('Tasks', ['tasks' => $tasks]);
    }

    public function toggleComplete(Task $task)
    {
        if ($task->user_id != auth()->id()) {
            return redirect()->back()->with('error', 'Unauthorized');
        }

        $task->is_complete = !$task->is_complete;
        $task->save();

        return redirect()->back();
    }

    public function getTasks()
    {
        return Task::where('user_id', auth()->id())
            ->orderBy('due_date', 'asc')
            ->orderBy('created_at', 'asc')
            ->get();
    }
}
