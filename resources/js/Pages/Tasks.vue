<script>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, usePage } from '@inertiajs/vue3';
import { reactive } from 'vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import Task from '@/Components/Task.vue';
import CreateTaskModal from '@/Components/CreateTaskModal.vue';
import { ref } from 'vue';

export default {
    components: {
        AuthenticatedLayout,
        Head,
        PrimaryButton,
        CreateTaskModal,
        Task,
    },

    data() {
        const { props } = usePage();
        return {
            tasks: props.tasks,
            show: false,
        };
    },
    setup() {
        const show = ref(false);
        const form = reactive({
            description: null,
            due_date: null,
        });
        return { show, form };
    },
};
</script>

<!-- #devmode: This is where the user adds and views tasks -->
<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Tasks</h2>
                <PrimaryButton @click="show = !show">Create Task</PrimaryButton>
            </div>
        </template>
        <CreateTaskModal v-if="show == true" :show="show"/>
        <div class="max-w-2xl mx-auto py-12">
            <ul role="list" class="divide-y divide-gray-100 overflow-hidden bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl">
                <Task v-for="task in tasks" :key="task.id" :task="task" />
            </ul>
        </div>
    </AuthenticatedLayout>
</template>
