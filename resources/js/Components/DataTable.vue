<template>
  <div class="data-table">
    <div class="mb-4 flex justify-between">
      <input
        type="text"
        v-model="searchQuery"
        placeholder="Search..."
        class="p-2 border rounded w-full"
        @input="onSearch"
      />
      <slot name="create-button"></slot>
    </div>
    <table class="min-w-full bg-white">
      <thead>
        <tr>
          <th v-for="column in columns" :key="column.key" class="py-2 cursor-pointer" @click="sort(column.key)">
            {{ column.label }}
            <span v-if="sortKey === column.key">
              {{ sortOrder === 'asc' ? '▲' : '▼' }}
            </span>
          </th>
          <th class="py-2">Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="item in data" :key="item.id">
          <td v-for="column in columns" :key="column.key" class="border px-4 py-2">
            {{ item[column.key] }}
          </td>
          <td class="border px-4 py-2">
            <slot name="actions" :item="item"></slot>
          </td>
        </tr>
      </tbody>
    </table>
    <div class="flex justify-between mt-4">
      <SecondaryButton @click="prevPage" :disabled="currentPage === 1">
        Previous
      </SecondaryButton>
      <span>Page {{ currentPage }} of {{ totalPages }}</span>
      <SecondaryButton @click="nextPage" :disabled="currentPage === totalPages">
        Next
      </SecondaryButton>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, watch, onMounted } from 'vue';
import { router } from '@inertiajs/vue3';
import SecondaryButton from '@/Components/SecondaryButton.vue';

const props = defineProps({
  columns: Array,
  itemsPerPage: Number,
  routeName: String,
  initialData: Array,
  totalItems: Number,
});

const searchQuery = ref("");
const currentPage = ref(1);
const sortKey = ref("");
const sortOrder = ref("asc");
const data = ref(props.initialData);
const totalPages = computed(() => Math.ceil(props.totalItems / props.itemsPerPage));

const loadData = () => {
  router.get(route(props.routeName), {
    page: currentPage.value,
    itemsPerPage: props.itemsPerPage,
    searchQuery: searchQuery.value,
    sortKey: sortKey.value,
    sortOrder: sortOrder.value,
  }, {
    preserveState: true,
    replace: true,
    onSuccess: (page) => {
      data.value = page.props.users.data;
      totalPages.value = Math.ceil(page.props.users.total / props.itemsPerPage);
    }
  });
};

const prevPage = () => {
  if (currentPage.value > 1) {
    currentPage.value--;
    loadData();
  }
};

const nextPage = () => {
  if (currentPage.value < totalPages.value) {
    currentPage.value++;
    loadData();
  }
};

const sort = (key) => {
  if (sortKey.value === key) {
    sortOrder.value = sortOrder.value === 'asc' ? 'desc' : 'asc';
  } else {
    sortKey.value = key;
    sortOrder.value = 'asc';
  }
  loadData();
};

const onSearch = () => {
  currentPage.value = 1;
  loadData();
};

watch([currentPage, sortKey, sortOrder, searchQuery], () => {
  loadData();
});

onMounted(() => {
  loadData();
});
</script>

<style scoped>
.data-table {
  width: 100%;
  border-collapse: collapse;
}

th,
td {
  text-align: left;
  padding: 8px;
  border: 1px solid #ddd;
}

th {
  background-color: #f2f2f2;
  cursor: pointer;
}

tr:hover {
  background-color: #f5f5f5;
}
</style>
