<script setup>
import { Head, Link, useForm } from "@inertiajs/vue3";
import { ref } from "vue";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import Table from "@/Components/Table.vue";
import TableRow from "@/Components/TableRow.vue";
import TableHeaderCell from "@/Components/TableHeaderCell.vue";
import TableDataCell from "@/Components/TableDataCell.vue";
import Modal from "@/Components/Modal.vue";
import DangerButton from "@/Components/DangerButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";

defineProps(['users']);

const form = useForm({});

const showConfirmDeleteUserModal = ref(false);
const deletingUser = ref(null); // To store the user being deleted

const confirmDeleteUser = (user) => {
    deletingUser.value = user; // Set the user to be deleted
    showConfirmDeleteUserModal.value = true;
};

const closeModal = () => {
    showConfirmDeleteUserModal.value = false;
};

const deleteUser = (id) => {
    form.delete(route('users.destroy', id), {
        onSuccess: () => closeModal()
    });
};
</script>

    
<template>
    <Head title="Users" />
    <AdminLayout>
        <div class="py-4 mx-auto max-w-7xl">
            <div class="flex justify-end">
                <Link :href="route('users.create')" class="px-3 py-2 mr-3 font-semibold text-black bg-yellow-500 rounded hover:bg-yellow-900">New User</Link>
            </div>
            <div class="mt-6 flex justify-center">
                <div class="w-full max-w-4xl mx-4">
                    <Table class="rounded-lg overflow-hidden">
                        <template #header>
                            <TableRow class="bg-red-700 text-white">
                                <TableHeaderCell class="text-center">ID</TableHeaderCell>
                                <TableHeaderCell class="text-center">Name</TableHeaderCell>
                                <TableHeaderCell class="text-center">Email</TableHeaderCell>
                                <TableHeaderCell class="text-center">Action</TableHeaderCell>
                            </TableRow>
                        </template>
                        <template #default>
                            <TableRow v-for="user in users" :key="user.id" class="border-b text-center space-x-4">
                                <TableDataCell class="text-center">{{ user.id }}</TableDataCell>
                                <TableDataCell class="text-center">{{ user.name }}</TableDataCell>
                                <TableDataCell class="text-center">{{ user.email }}</TableDataCell>
                                <TableDataCell class="text-center space-x-4">
                                    <Link :href="route('users.edit', user.id)" class="text-green-400 hover:text-green-600">Edit</Link>
                                    <button @click="() => confirmDeleteUser(user)" class="text-red-400 hover:text-red-600">Delete</button>
                                    <Modal :show="showConfirmDeleteUserModal" @close="closeModal">
                                        <div class="p-6">
                                            <h2 class="text-lg font-semibold text-slate-800">Are you sure to delete account '{{ deletingUser ? deletingUser.name : '' }}'?</h2>
                                            <div class="mt-6 flex space-x-4">
                                                <DangerButton @click="deleteUser(deletingUser.id)">Delete</DangerButton>
                                                <SecondaryButton @click="closeModal">Cancel</SecondaryButton>
                                            </div>
                                        </div>
                                    </Modal>
                                </TableDataCell>
                            </TableRow>
                        </template>
                    </Table>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<script>
export default {
    components: {
        Head,
        Link,
        useForm,
        Table,
        TableRow,
        TableHeaderCell,
        TableDataCell,
        AdminLayout,
        Modal,
        DangerButton,
        SecondaryButton,
    },
};
</script>
