<template>
    <div class="footer">
        <div class="footer-text">
            © {{ currentDate }} | All rights reserved
        </div>
    </div>
</template>

<script setup>
const currentDate = new Date().getFullYear();
</script>

<style scoped>
.footer {
    border-top: 1px solid rgba(114, 59, 27, 0.5);
    background-color: #fff;
    height: 40px;
    color: #723B1B;
    text-align: center;
    width: 100%;
}
.footer-text {
    padding: 1em;
    font-family: 'Open Sans', sans-serif;
    font-weight: 300;
    font-size: 12px;
    letter-spacing: -0.02em;
}
</style>
