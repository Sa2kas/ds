<template>
  <div class="right-side">
    <div class="links">
      <div class="links-item" v-if="!authenticated">
        <div class="links-item-data">Login</div>
      </div>
      <div v-else>
        <div class="links-item">
          rolė:
          <div class="links-item-data">{{ user.name }}</div>
        </div>
        <div class="links-item">
          <div class="links-item-data" @click="logout">Logout</div>
        </div>
      </div>
    </div>
    <div class="side-line"></div>
  </div>
</template>

<script setup>
import { computed } from 'vue';
import { usePage } from '@inertiajs/vue3';

const { props } = usePage();
const user = props.auth.user;
const authenticated = computed(() => !!user);

const logout = () => {
  // Implement logout logic if necessary
  // Emit logout event or handle the logout action
};
</script>

<style scoped>
.right-side {
  justify-content: space-between;
  display: flex;
  width: 100%;
  background-color: #fff;
}
.links {
  margin-top: 30px;
  margin-left: 30px;
}
.links-item {
  font-family: "Oswald", sans-serif;
  font-weight: 400;
  font-size: 16px;
  text-transform: uppercase;
  cursor: pointer;
  margin-bottom: 20px;
  color: #6f6f6f;
  display: flex;
  flex-direction: column;
}
.links-item-data {
  text-decoration: none;
  color: #723B1B;
}
.links-item:hover .links-item-data {
  color: #221108;
}
.side-line {
  background: #723B1B;
  width: 56px;
  height: 100%;
}
</style>
