<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link } from "@inertiajs/vue3";

defineProps({
    projects: {
        type: Array,
        required: true,
    },
});
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="p-6 text-gray-900">
            <div class="space-y-4">
                <div
                    v-for="(project, index) in projects"
                    class="p-4 space-y-6 bg-slate-200 rounded-md">
                    <h1 class="font-bold text-xl text-gray-800">
                        {{ project.name }}
                    </h1>

                    <p v-html="project.description.substr(0, 100) + '...'"></p>

                    <div>
                        <Link
                            :href="route('detail-project', project.id)"
                            class="px-4 py-2 rounded-md font-medium bg-gray-800 text-white">
                            Details
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
