<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, usePage, router } from "@inertiajs/vue3";
import { ref, computed } from "vue";
import Modal from "@/Components/Modal.vue"; // Import Modal component
import { useForm } from "@inertiajs/vue3"; // Import useForm
import TextInput from "@/Components/TextInput.vue"; // Import TextInput component
import InputLabel from "@/Components/InputLabel.vue"; // Import InputLabel component
import InputError from "@/Components/InputError.vue"; // Import InputError component
import PrimaryButton from "@/Components/PrimaryButton.vue"; // Import PrimaryButton component
import SecondaryButton from "@/Components/SecondaryButton.vue"; // Import SecondaryButton component

const { props } = usePage();
const { auth, users: initialUserData } = props;

const user = auth.user;
const searchQuery = ref("");
const currentPage = ref(1);
const itemsPerPage = ref(2);

const showModal = ref(false); // State to show/hide the modal
const modalData = ref({}); // Data for the modal (create or edit)
const users = ref(initialUserData); // Use ref for users data

const form = useForm({
    id: null,
    name: "",
    email: "",
    password: "",
    password_confirmation: "",
    role: "",
});

const openModal = (data = {}) => {
    modalData.value = { ...data, password: '', password_confirmation: '' };
    form.id = data.id || null;
    form.name = data.name || "";
    form.email = data.email || "";
    form.password = "";
    form.password_confirmation = "";
    form.role = data.role || "";
    showModal.value = true;
};

const closeModal = () => {
    showModal.value = false;
    modalData.value = {};
    form.reset();
};

const saveUser = () => {
    form.post(route("users.store"), {
        preserveScroll: true,
        onSuccess: (page) => {
            const savedUser = page.props.users.find(u => u.id === form.id);
            if (form.id) {
                // Update the existing user in the users array
                const index = users.value.findIndex(u => u.id === form.id);
                if (index !== -1) {
                    users.value[index] = savedUser;
                }
            } else {
                // Add the new user to the users array
                users.value.push(savedUser);
            }
            closeModal();
        },
    });
};

const filteredUsers = computed(() => {
    return users.value.filter((user) =>
        user.name.toLowerCase().includes(searchQuery.value.toLowerCase())
    );
});

const paginatedUsers = computed(() => {
    const start = (currentPage.value - 1) * itemsPerPage.value;
    const end = start + itemsPerPage.value;
    return filteredUsers.value.slice(start, end);
});

const totalPages = computed(() => {
    return Math.ceil(filteredUsers.value.length / itemsPerPage.value);
});

const goToPage = (page) => {
    if (page >= 1 && page <= totalPages.value) {
        currentPage.value = page;
    }
};

const deleteUser = (id) => {
    if (confirm("Are you sure you want to delete this user?")) {
        router.delete(route("users.destroy", id), {
            preserveScroll: true,
            onSuccess: () => {
                // Remove the user from the users array
                users.value = users.value.filter(user => user.id !== id);
            }
        });
    }
};

</script>

<template>
    <Head title="User Management" />

    <AuthenticatedLayout :user-role-route="'admin.dashboard'">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="mb-4 flex justify-between">
                            <input
                                type="text"
                                v-model="searchQuery"
                                placeholder="Search..."
                                class="p-2 border rounded w-full"
                            />
                            <PrimaryButton @click="openModal" class="ml-4">Create</PrimaryButton>
                        </div>
                        <table class="min-w-full bg-white">
                            <thead>
                                <tr>
                                    <th class="py-2">ID</th>
                                    <th class="py-2">Name</th>
                                    <th class="py-2">Email</th>
                                    <th class="py-2">Role</th>
                                    <th class="py-2">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="user in paginatedUsers"
                                    :key="user.id"
                                >
                                    <td class="border px-4 py-2">
                                        {{ user.id }}
                                    </td>
                                    <td class="border px-4 py-2">
                                        {{ user.name }}
                                    </td>
                                    <td class="border px-4 py-2">
                                        {{ user.email }}
                                    </td>
                                    <td class="border px-4 py-2">
                                        {{ user.role }}
                                    </td>
                                    <td class="border px-4 py-2">
                                        <button @click="openModal(user)" class="text-yellow-500 mr-2">Edit</button>
                                        <button @click="deleteUser(user.id)" class="text-red-500">Delete</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="flex justify-between mt-4">
                            <SecondaryButton
                                @click="goToPage(currentPage - 1)"
                                :disabled="currentPage === 1"
                            >
                                Previous
                            </SecondaryButton>
                            <span>
                                Page {{ currentPage }} of {{ totalPages }}
                            </span>
                            <SecondaryButton
                                @click="goToPage(currentPage + 1)"
                                :disabled="currentPage === totalPages"
                            >
                                Next
                            </SecondaryButton>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
    <!-- Modal Component -->
    <Modal :show="showModal" @close="closeModal">
        <template #default>
            <div class="p-6">
                <h2 v-if="modalData.id">Edit User</h2>
                <h2 v-else>Create User</h2>
                <form @submit.prevent="saveUser">
                    <div class="mt-4">
                        <InputLabel for="name" value="Name" />
                        <TextInput id="name" type="text" v-model="form.name" required autofocus />
                        <InputError :message="form.errors.name" class="mt-2" />
                    </div>
                    <div class="mt-4">
                        <InputLabel for="email" value="Email" />
                        <TextInput id="email" type="email" v-model="form.email" required />
                        <InputError :message="form.errors.email" class="mt-2" />
                    </div>
                    <div class="mt-4">
                        <InputLabel for="password" value="Password" />
                        <TextInput id="password" type="password" v-model="form.password" :required="!modalData.id" />
                        <InputError :message="form.errors.password" class="mt-2" />
                    </div>
                    <div class="mt-4">
                        <InputLabel for="password_confirmation" value="Confirm Password" />
                        <TextInput id="password_confirmation" type="password" v-model="form.password_confirmation" :required="!modalData.id" />
                        <InputError :message="form.errors.password_confirmation" class="mt-2" />
                    </div>
                    <div class="mt-4">
                        <InputLabel for="role" value="Role" />
                        <TextInput id="role" type="text" v-model="form.role" required />
                        <InputError :message="form.errors.role" class="mt-2" />
                    </div>
                    <div class="mt-4 flex justify-end">
                        <SecondaryButton type="button" @click="closeModal">Cancel</SecondaryButton>
                        <PrimaryButton type="submit" class="ml-4">Save</PrimaryButton>
                    </div>
                </form>
            </div>
        </template>
    </Modal>
</template>

<style scoped>
table {
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
}

tr:hover {
    background-color: #f5f5f5;
}

input[type="text"], input[type="email"], input[type="password"] {
    width: 100%;
    padding: 8px;
    box-sizing: border-box;
}
</style>
