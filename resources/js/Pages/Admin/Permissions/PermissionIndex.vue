<script setup>
import { Head, Link, useForm } from "@inertiajs/vue3";
import { ref } from "vue";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import Table from "@/Components/Table.vue";
import TableRow from "@/Components/TableRow.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TableHeaderCell from "@/Components/TableHeaderCell.vue";
import TableDataCell from "@/Components/TableDataCell.vue";
import Modal from "@/Components/Modal.vue";
import DangerButton from "@/Components/DangerButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";

defineProps(['permissions']);

const form = useForm({});

const showConfirmDeletePermissionModal = ref(false);
const deletingPermission = ref(null); // To store the Permission being deleted

const confirmDeletePermission = (permission) => {
    deletingPermission.value = permission; // Set the Permission to be deleted
    showConfirmDeletePermissionModal.value = true;
};

const closeModal = () => {
    showConfirmDeletePermissionModal.value = false;
};

const deletePermission = () => {
    if (deletingPermission.value) {
        form.delete(route('permissions.destroy', deletingPermission.value.id), {
            onSuccess: () => closeModal()
        });
    }
};
</script>


<template>
    <Head title="Permissions" />
    <AdminLayout>
        <div class="py-4 mx-auto max-w-7xl">
            <div class="flex justify-end">
                <Link :href="route('permissions.create')">
                     <PrimaryButton
                        class="ml-4"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                        >
                         New Permission
                        </PrimaryButton>
                </Link>
            </div>
            <div class="mt-6 flex justify-center">
                <div class="w-full max-w-4xl mx-4">
                    <Table class="rounded-lg overflow-hidden">
                        <template #header>
                            <TableRow  class=" text-white">
                                <TableHeaderCell>ID</TableHeaderCell>
                                <TableHeaderCell>Name</TableHeaderCell>
                                <TableHeaderCell>Action</TableHeaderCell>
                            </TableRow>
                        </template>
                        <template #default>
                            <TableRow v-for="permission in permissions" :key="permission.id" class="border-b text-center space-x-4">
                                <TableDataCell>{{ permission.id }}</TableDataCell>
                                <TableDataCell>{{ permission.name }}</TableDataCell>
                                <TableDataCell class="space-x-4">
                                    <Link :href="route('permissions.edit', permission.id)" class="text-green-400 hover:text-green-600">Edit</Link>
                                    <button @click="() => confirmDeletePermission(permission)" class="text-red-400 hover:text-red-600">Delete</button>
                                    <Modal :show="showConfirmDeletePermissionModal" @close="closeModal">
                                        <div class="p-6">
                                            <h2 class="text-lg font-semibold text-slate-800">Are you sure to delete '{{ deletingPermission ? deletingPermission.name : '' }}'?</h2>
                                            <div class="mt-6 flex space-x-4">
                                                <DangerButton @click="deletePermission">Delete</DangerButton>
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



