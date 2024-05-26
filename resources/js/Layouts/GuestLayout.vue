<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div id="container" class="min-h-screen items-center justify-center bg-gray-100">
        <div  id="container2" class="flex flex-col sm:flex-row-reverse w-full sm:h-screen">
            <div id="test" class="w-full sm:w-1/2 h-auto sm:h-full flex justify-center sm:justify-center items-start sm:items-center bg-gray-200">
                <Link href="/" class="w-full sm:w-auto flex justify-center">
                    <ApplicationLogo class="w-20 h-20 fill-current text-gray-500" />
                </Link>
            </div>
            <div id="test2" class="w-full sm:w-1/2 h-auto sm:h-full px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg flex justify-center sm:justify-center items-start sm:items-center">
                <slot />
            </div>
        </div>
    </div>
</template>

<style scoped>
@media (min-width: 640px) {
    .h-full {
        height: 100vh;
    }
    .flex-row-reverse {
        flex-direction: row-reverse;
    }
}
@media (max-width: 639px) {
    
    #container {
        display: inherit !important;
    }
}
</style>
