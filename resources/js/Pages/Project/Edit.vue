<script setup>
import { Head, useForm, Link } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import Editor from "primevue/editor";
import { useToast } from "primevue/usetoast";
import { ToastSeverity } from "primevue/api";

const props = defineProps({ project: { required: true, type: Object } });

const form = useForm({
    name: props.project?.name,
    description: props.project?.description,
    start_date: props.project?.start_date,
    end_date: props.project?.end_date,
});

const toast = useToast();

const submit = () => {
    form.patch(route("project.update", props.project.id), {
        onFinish: () => form.reset(),
        onSuccess: () =>
            toast.add({
                severity: ToastSeverity.SUCCESS,
                summary: "Updated",
                detail: "Project successfully updated",
                life: 2000,
            }),
    });
};
</script>

<template>
    <Head title="Edit Project" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Edit Project
            </h2>
        </template>

        <div class="p-6">
            <Link
                href="/project"
                class="px-4 py-2 rounded-md font-medium bg-gray-800 text-white">
                Back
            </Link>

            <form
                @submit.prevent="submit"
                method="patch"
                class="mt-6 space-y-4">
                <div>
                    <InputLabel for="name" value="Name" />
                    <TextInput
                        id="name"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.name"
                        required
                        autofocus
                        autocomplete="name" />
                    <InputError class="mt-2" :message="form.errors.name" />
                </div>

                <div>
                    <InputLabel for="description" value="Description" />
                    <Editor
                        v-model="form.description"
                        editorStyle="height: 320px">
                        <template v-slot:toolbar>
                            <span class="ql-formats">
                                <button class="ql-bold"></button>
                                <button class="ql-italic"></button>
                                <button class="ql-underline"></button>
                                <button class="ql-list" value="bullet"></button>
                                <button
                                    class="ql-list"
                                    value="ordered"></button>
                            </span>
                        </template>
                    </Editor>
                    <InputError
                        class="mt-2"
                        :message="form.errors.description" />
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <InputLabel for="start_date" value="Start Date" />
                        <TextInput
                            id="start_date"
                            type="date"
                            class="mt-1 block w-full"
                            v-model="form.start_date"
                            required />
                        <InputError
                            class="mt-2"
                            :message="form.errors.start_date" />
                    </div>

                    <div>
                        <InputLabel for="end_date" value="End Date" />
                        <TextInput
                            id="end_date"
                            type="date"
                            class="mt-1 block w-full"
                            v-model="form.end_date"
                            required />
                        <InputError
                            class="mt-2"
                            :message="form.errors.end_date" />
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
