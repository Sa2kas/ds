<script setup>
// import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
  <Head title="Access Denied" />
    <div class="flex items-center justify-center min-h-screen">
      <div class="text-center">
        <h1 class="text-6xl font-semibold text-gray-800">403</h1>
        <p class="text-xl mt-4 mb-2 text-gray-600">Access Denied</p>
        <p class="text-md text-gray-500">You do not have permission to view this page.</p>
      </div>
    </div>
</template>
