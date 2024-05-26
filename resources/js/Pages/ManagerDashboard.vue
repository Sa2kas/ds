<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Manager Dashboard" />

    <!-- Pass 'admin.dashboard' as a string -->
    <AuthenticatedLayout :user-role-route="'manager.dashboard'">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Manager Dashboard</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        Welcome, Manager! Here you can manage system settings, view reports, and more.
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
