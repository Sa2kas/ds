<script setup>
import { Head } from "@inertiajs/vue3";
import SimpleLayout from "@/Layouts/SimpleLayout.vue";

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
});
</script>

<template>
    <Head title="About" />

    <SimpleLayout>
        <div class="about-content">
            <h1>About Us</h1>
            <p>This is the about page content.</p>
        </div>
    </SimpleLayout>
</template>

<style scoped>
.about-content {
    padding: 20px;
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}
</style>
