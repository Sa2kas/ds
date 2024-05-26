<template>
  <div>
    <Header />
    <div class="layout-content">
      <div class="main-content">
        <slot />
      </div>
    </div>
    <Footer />
  </div>
</template>

<script setup>
import Header from '@/Components/Header.vue';
import Footer from '@/Components/Footer.vue';
</script>

<style scoped>
.layout-content {
  display: flex;
  min-height: calc(100vh - 110px); /* Adjust based on header and footer heights */
  padding: 90px 20px 20px; /* Added top padding to account for fixed header */
  background: var(--background-color, #f5f5f5);
}
.main-content {
  flex: 1;
  padding: 20px;
  background-color: #fff;
  border-radius: 8px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}
</style>
