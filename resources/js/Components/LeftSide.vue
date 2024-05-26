<template>
  <div class="menu">
    <div class="left-menu-side" />
    <div class="right-menu-side">
      <div class="tab-title">Menu</div>
      <div class="right-side-title" @click="close">
        <div class="right-side-title">Home</div>
      </div>
      <div v-if="!authenticated" class="right-side-title" @click="close">
        Calculate the order price
      </div>
      <div v-if="!authenticated" class="right-side-title" @click="close">
        Check order status
      </div>
      <div v-if="!authenticated" class="right-side-title" @click="close">
        Armored apartment door
      </div>
      <div v-if="!authenticated" class="right-side-title" @click="close">
        Armored front door
      </div>
      <div v-if="!authenticated" class="right-side-title" @click="close">
        Locks
      </div>
      <div class="right-side-title" v-if="userRole === 1" @click="close">
        Admin dashboard
      </div>
      <div class="right-side-title" v-if="userRole === 2" @click="close">
        Manager dashboard
      </div>
      <div class="right-side-title" v-if="userRole === 3" @click="close">
        Product manager dashboard
      </div>
      <div class="right-side-title" v-if="userRole === 1" @click="close">
        Orders
      </div>
      <div class="right-side-title" v-if="userRole === 1" @click="close">
        Users
      </div>
      <div v-if="!authenticated" class="right-side-title" @click="close">
        Contacts
      </div>
      <div class="right-side-title" v-if="userRole === 1 || userRole === 2" @click="close">
        Edit gallery
      </div>
      <div class="right-side-title" @click="close">
        Comments
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue';
import { usePage } from '@inertiajs/vue3';

const { props } = usePage();
const user = props.auth.user;
const userRole = computed(() => (user ? user.role_id : 0));
const authenticated = computed(() => !!user);

const close = () => {
  // Emit close event or handle the close action
  // Implement close logic if necessary
};
</script>

<style scoped>
.menu {
  min-width: 300px;
  width: max-content;
  display: flex;
  opacity: 1 !important;
  background-color: #fff;
  height: 100%;
}
.left-menu-side {
  background: #723B1B;
  display: flex;
  flex-direction: column;
  color: #fff;
  text-align: center;
  padding-top: 171px;
  min-width: 56px;
  max-width: 56px;
}
.right-menu-side {
  background-color: #fff;
  padding: 164px 2.5vw;
  width: 100%;
  font-family: "Oswald", sans-serif;
  text-transform: uppercase;
}
.right-side-title {
  cursor: pointer;
  color: #723B1B;
  margin-bottom: 20px;
}
.right-side-title:hover {
  color: #221108;
}
.tab-title {
  max-width: 100%;
  color: #444;
  font-size: 30px;
  text-decoration: underline;
  margin-bottom: 30px;
}
</style>
