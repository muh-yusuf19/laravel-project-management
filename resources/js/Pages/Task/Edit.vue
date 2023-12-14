<script setup>
import { Head, useForm, Link } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import TextareaInput from "@/Components/TextareaInput.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { useToast } from "primevue/usetoast";
import { ToastSeverity } from "primevue/api";
import Dropdown from "primevue/dropdown";
import { ref } from "vue";

const props = defineProps({
    task: {
        type: Object,
        required: true,
    },
    user: {
        type: Array,
        required: true,
    },
    project: {
        type: Array,
        required: true,
    },
});

const selectedUser = ref(props.task.user);
const selectedProject = ref(props.task.project);

const form = useForm({
    user_id: "",
    project_id: "",
    title: props.task?.title,
    description: props.task?.description,
    status: props.task?.status,
});

const toast = useToast();

const submit = () => {
    form.user_id = selectedUser.value?.id;
    form.project_id = selectedProject.value?.id;

    form.patch(route("task.update", props.task.id), {
        onFinish: () => form.reset(),
        onSuccess: () =>
            toast.add({
                severity: ToastSeverity.SUCCESS,
                summary: "Sucess",
                detail: "Task successfully edited",
                life: 2000,
            }),
    });
};
</script>
<template>
    <Head title="Edit Task" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Edit Task
            </h2>
        </template>

        <div class="p-6">
            <Link
                :href="route('task.index')"
                class="px-4 py-2 rounded-md font-medium bg-gray-800 text-white">
                Back
            </Link>

            <form
                @submit.prevent="submit"
                method="patch"
                class="mt-6 space-y-4">
                <div>
                    <InputLabel for="title" value="Title" />
                    <TextInput
                        id="title"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.title"
                        required
                        autofocus />
                    <InputError class="mt-2" :message="form.errors.title" />
                </div>

                <div>
                    <InputLabel for="description" value="Description" />
                    <TextareaInput
                        id="description"
                        class="mt-1 block w-full"
                        v-model="form.description"
                        required></TextareaInput>
                    <InputError
                        class="mt-2"
                        :message="form.errors.description" />
                </div>

                <div class="grid grid-cols-3 gap-4">
                    <div>
                        <InputLabel for="status" value="Status" />
                        <TextInput
                            id="status"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form.status"
                            required />
                        <InputError
                            class="mt-2"
                            :message="form.errors.status" />
                    </div>

                    <div>
                        <InputLabel for="status" value="Select User" />
                        <Dropdown
                            v-model="selectedUser"
                            :options="props.user"
                            filter
                            optionLabel="name"
                            placeholder="Select User"
                            class="w-full border border-gray-300 md:w-14rem">
                            <template #value="slotProps">
                                <div
                                    v-if="slotProps.value"
                                    class="flex align-items-center">
                                    <div>{{ slotProps.value.name }}</div>
                                </div>
                                <span v-else>
                                    {{ slotProps.placeholder }}
                                </span>
                            </template>
                            <template #option="slotProps">
                                <div class="flex align-items-center">
                                    <div>{{ slotProps.option.name }}</div>
                                </div>
                            </template>
                        </Dropdown>
                        <InputError
                            class="mt-2"
                            :message="form.errors.user_id" />
                    </div>

                    <div>
                        <InputLabel for="status" value="Select Project" />
                        <Dropdown
                            v-model="selectedProject"
                            :options="props.project"
                            filter
                            optionLabel="name"
                            placeholder="Select Project"
                            class="w-full border border-gray-300 md:w-14rem">
                            <template #value="slotProps">
                                <div
                                    v-if="slotProps.value"
                                    class="flex align-items-center">
                                    <div>{{ slotProps.value.name }}</div>
                                </div>
                                <span v-else>
                                    {{ slotProps.placeholder }}
                                </span>
                            </template>
                            <template #option="slotProps">
                                <div class="flex align-items-center">
                                    <div>{{ slotProps.option.name }}</div>
                                </div>
                            </template>
                        </Dropdown>
                        <InputError
                            class="mt-2"
                            :message="form.errors.project_id" />
                    </div>
                </div>

                <PrimaryButton
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing">
                    Submit
                </PrimaryButton>
            </form>
        </div>
    </AuthenticatedLayout>
</template>
