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

defineProps(['roles']);

const form = useForm({});

const showConfirmDeleteRoleModal = ref(false);
const deletingRole = ref(null); // To store the Role being deleted

const confirmDeleteRole = (role) => {
    deletingRole.value = role; // Set the Role to be deleted
    showConfirmDeleteRoleModal.value = true;
};

const closeModal = () => {
    showConfirmDeleteRoleModal.value = false;
};

const deleteRole = () => {
    if (deletingRole.value) {
        form.delete(route('roles.destroy', deletingRole.value.id), {
            onSuccess: () => closeModal()
        });
    }
};
</script>


<template>
    <Head title="Roles" />
    <AdminLayout>
        <div class="py-4 mx-auto max-w-7xl">
            <div class="flex justify-end">
                <Link :href="route('roles.create')" class="px-3 py-2 mr-3 font-semibold text-white bg-indigo-500 rounded hover:bg-indigo-700">New Role</Link>
            </div>
            <div class="mt-6 flex justify-center">
                <div class="w-full max-w-4xl mx-4">
                    <Table>
                        <template #header>
                            <TableRow>
                                <TableHeaderCell>ID</TableHeaderCell>
                                <TableHeaderCell>Name</TableHeaderCell>
                                <TableHeaderCell>Action</TableHeaderCell>
                            </TableRow>
                        </template>
                        <template #default>
                            <TableRow v-for="role in roles" :key="role.id" class="border-b text-center space-x-4">
                                <TableDataCell>{{ role.id }}</TableDataCell>
                                <TableDataCell>{{ role.name }}</TableDataCell>
                                <TableDataCell class="space-x-4">
                                    <Link :href="route('roles.edit', role.id)" class="text-green-400 hover:bg-green-600">Edit</Link>
                                    <button @click="() => confirmDeleteRole(role)" class="text-red-400 hover:text-red-600">Delete</button>
                                    <Modal :show="showConfirmDeleteRoleModal" @close="closeModal">
                                        <div class="p-6">
                                            <h2 class="text-lg font-semibold text-slate-800">Are you sure to delete role '{{ deletingRole ? deletingRole.name : '' }}'?</h2>
                                            <div class="mt-6 flex space-x-4">
                                                <DangerButton @click="deleteRole">Delete</DangerButton>
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

