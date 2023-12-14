<script setup>
import { Head, Link, useForm } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Editor from "primevue/editor";

const props = defineProps({
    project: {
        type: Object,
        required: true,
    },
});
</script>
<template>
    <Head title="Detail Project" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Detail Project
            </h2>
        </template>

        <div class="p-6 text-gray-900">
            <div class="p-4 bg-slate-100 rounded-xl space-y-6">
                <h1 class="font-bold text-xl text-gray-800">
                    {{ props.project.name }}
                </h1>

                <Editor
                    v-model="props.project.description"
                    editorStyle="height: 320px"
                    readonly>
                    <template v-slot:toolbar>
                        <span class="ql-formats">
                            <button class="ql-bold"></button>
                            <button class="ql-italic"></button>
                            <button class="ql-underline"></button>
                            <button class="ql-list" value="bullet"></button>
                            <button class="ql-list" value="ordered"></button>
                        </span>
                    </template>
                </Editor>
            </div>

            <div
                v-for="(field, index) in props.project.tasks"
                :key="index"
                class="bg-slate-100 mt-4 p-4 space-y-6 rounded-xl">
                <h1 class="font-bold text-lg">
                    {{ field.title }}
                </h1>
                <p>{{ field.description }}</p>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
