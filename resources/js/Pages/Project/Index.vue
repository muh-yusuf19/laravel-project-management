<script setup>
import { Head, Link, useForm } from "@inertiajs/vue3";
import { reactive } from "vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import TextInput from "@/Components/TextInput.vue";
import DataTable from "primevue/datatable";
import Column from "primevue/column";
import { FilterMatchMode } from "primevue/api";
import Toast from "primevue/toast";
import ConfirmDialog from "primevue/confirmdialog";
import { useConfirm } from "primevue/useconfirm";
import { useToast } from "primevue/usetoast";
import { ToastSeverity } from "primevue/api";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";

defineProps({ project: { required: true, type: Array } });

const filters = reactive({
    global: { value: "", matchMode: FilterMatchMode.CONTAINS },
    name: { value: null, matchMode: FilterMatchMode.STARTS_WITH },
    description: { value: null, matchMode: FilterMatchMode.STARTS_WITH },
});

const confirm = useConfirm();
const form = useForm({
    id: "",
});
const toast = useToast();

function handleConfirm(id) {
    confirm.require({
        message: "Are you sure want to delete this record ?" + id,
        header: "Confirmation",
        accept: () => {
            form.delete(route("project.delete", id), {
                onSuccess: () => {
                    toast.add({
                        severity: ToastSeverity.SUCCESS,
                        summary: "Success",
                        detail: "Project successfuly deleted",
                        life: 2000,
                    });
                },
            });
        },
        reject: () => {
            toast.add({
                severity: ToastSeverity.INFO,
                summary: "Cancelled",
                detail: "Project deletion are cancelled",
                life: 2000,
            });
        },
    });
}
</script>

<template>
    <Head title="Project" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                List Project
            </h2>
        </template>

        <Toast />
        <ConfirmDialog>
            <template #container="{ message, acceptCallback, rejectCallback }">
                <div class="bg-white p-5 rounded-lg text-gray-700">
                    <div class="flex flex-row justify-between items-center">
                        <span class="font-bold text-2xl block">{{
                            message.header
                        }}</span>
                        <button class="p-4" @click="rejectCallback">
                            <span class="pi pi-times"></span>
                        </button>
                    </div>
                    <p class="py-4">{{ message.message }}</p>
                    <div class="flex justify-end gap-2 py-4">
                        <PrimaryButton @click="acceptCallback"
                            >Submit</PrimaryButton
                        >
                        <SecondaryButton @click="rejectCallback"
                            >Cancel</SecondaryButton
                        >
                    </div>
                </div>
            </template>
        </ConfirmDialog>

        <div class="p-6">
            <Link
                :href="route('project.create')"
                class="px-4 py-2 rounded-md font-medium bg-gray-800 text-white">
                Create Project
            </Link>

            <div class="mt-6">
                <DataTable
                    v-model:filters="filters"
                    :value="project"
                    paginator
                    :rows="10"
                    :globalFilterFields="['name', 'description']">
                    <template #header>
                        <div class="flex justify-content-end">
                            <TextInput
                                type="text"
                                class="mt-1 block w-1/4"
                                v-model="filters.global.value"
                                placeholder="Keyword Search" />
                        </div>
                    </template>
                    <template #empty> No Project found. </template>
                    <Column
                        field="name"
                        sortable
                        header="Project Name"></Column>
                    <Column field="description" sortable header="Description">
                        <template #body="{ data }">
                            <div>
                                {{ data.description.substring(0, 150) }} ...
                            </div>
                        </template>
                    </Column>
                    <Column
                        field="start_date"
                        sortable
                        header="Start Date"></Column>
                    <Column
                        field="end_date"
                        sortable
                        header="End Date"></Column>
                    <Column header="Actions">
                        <template #body="{ data }">
                            <div class="flex flex-row gap-4">
                                <Link
                                    :href="'/project/' + data.id + '/edit'"
                                    method="put"
                                    as="button"
                                    type="button"
                                    class="bg-yellow-400 text-white px-4 py-2 rounded-md">
                                    Edit
                                </Link>

                                <div>
                                    <button
                                        @click="handleConfirm(data.id)"
                                        class="bg-red-500 text-white px-4 py-2 rounded-md">
                                        Delete
                                    </button>
                                </div>
                            </div>
                        </template>
                    </Column>
                </DataTable>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
