<script>
import { ref } from "vue";
import { Head, router, usePage } from "@inertiajs/vue3";
import { reactive } from "vue";
import {
    Dialog,
    DialogOverlay,
    TransitionChild,
    TransitionRoot,
} from "@headlessui/vue";

export default {
    components: {
        Dialog,
        DialogOverlay,
        TransitionChild,
        TransitionRoot,
    },
    props: {
        show: Boolean,
    },
    setup(props) {
        let show = ref(props.show);
        let errors = ref("");
        console.log(props.show);
        const form = reactive({
            description: null,
            due_date: null,
        });
        const submit = async () => {
            const response = await router.post(route("tasks.store"), form, {
                onSuccess: (data) => {
                    console.log("data", data);
                    // show.value = false;
                    window.location.reload();
                },
                onError: (error) => {
                    errors.value = error;
                    console.log("error", error);
                },
            });
        };
        return { show, form, submit, errors };
    },
};
</script>

<template>
    <TransitionRoot
        appear
        :show="show"
        :errors="errors"
        as="template"
        @before-leave="show = false"
    >
        <Dialog as="div">
            <div class="fixed inset-0 z-10 overflow-y-auto">
                <div class="min-h-screen px-4 text-center">
                    <TransitionChild
                        as="template"
                        enter="duration-300 ease-out"
                        enter-from="opacity-0"
                        enter-to="opacity-100"
                        leave="duration-200 ease-in"
                        leave-from="opacity-100"
                        leave-to="opacity-0"
                    >
                        <DialogOverlay class="fixed inset-0" />
                    </TransitionChild>
                    <span
                        class="inline-block h-screen align-middle"
                        aria-hidden="true"
                        >&#8203;</span
                    >
                    <TransitionChild
                        as="template"
                        enter="duration-300 ease-out"
                        enter-from="opacity-0 scale-95"
                        enter-to="opacity-100 scale-100"
                        leave="duration-200 ease-in"
                        leave-from="opacity-100 scale-100"
                        leave-to="opacity-0 scale-95"
                    >
                        <div
                            class="inline-block w-full max-w-md p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-white shadow-xl rounded-2xl"
                        >
                            <form @submit.prevent="submit">
                                <div>
                                    <div class="p-6">
                                        <label
                                            for="description"
                                            class="block text-sm font-medium text-gray-700"
                                            >Description</label
                                        >
                                        <input
                                            v-model="form.description"
                                            id="description"
                                            type="text"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                        />
                                        <div class="text-red-600" v-if="errors?.description">
                                            {{ errors?.description }}
                                        </div>
                                    </div>
                                    <div class="p-6">
                                        <label
                                            for="due_date"
                                            class="block text-sm font-medium text-gray-700"
                                            >Due Date</label
                                        >
                                        <input
                                            v-model="form.due_date"
                                            id="due_date"
                                            type="date"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                        />
                                    </div>

                                    <!-- Submit button for creating task -->
                                    <div class="p-6 flex justify-end">
                                        <button
                                            type="submit"
                                            class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600"
                                        >
                                            Create Task
                                        </button>
                                        <button
                                            type="button"
                                            class="bg-blue-500 text-white ml-3 px-4 py-2 rounded-md hover:bg-blue-600"
                                            @click="show = false"
                                        >
                                            Cancel
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>
</template>
