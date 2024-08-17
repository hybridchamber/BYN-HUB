<template>
    <Head title="Users" />
    <AdminLayout>
      <div class="py-4 mx-auto max-w-7xl">
        <div class="flex justify-end">
          <Link :href="route('users.create')" class="px-3 py-2 mr-3 font-semibold text-black bg-yellow-500 rounded hover:bg-yellow-900">New User</Link>
        </div>
        <div class="mt-6 flex justify-center">
          <div class="w-full max-w-4xl mx-4">
            <!-- Search Input -->
            <input v-model="searchQuery" placeholder="Search by name" class="border p-2 rounded mb-4" />
  
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
                <TableRow v-for="user in filteredUsers" :key="user.id" class="border-b text-center space-x-4">
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
  
  <script setup>
  import { ref, computed } from 'vue';
  import { Head, Link, useForm } from "@inertiajs/vue3";
  import AdminLayout from "@/Layouts/AdminLayout.vue";
  import Table from "@/Components/Table.vue";
  import TableRow from "@/Components/TableRow.vue";
  import TableHeaderCell from "@/Components/TableHeaderCell.vue";
  import TableDataCell from "@/Components/TableDataCell.vue";
  import Modal from "@/Components/Modal.vue";
  import DangerButton from "@/Components/DangerButton.vue";
  import SecondaryButton from "@/Components/SecondaryButton.vue";
  
  const props = defineProps(['users']);
  const searchQuery = ref('');
  const form = useForm({});
  const showConfirmDeleteUserModal = ref(false);
  const deletingUser = ref(null);
  
  const filteredUsers = computed(() => {
    const query = searchQuery.value.toLowerCase();
    return props.users.filter(user => user.name.toLowerCase().includes(query));
  });
  
  const confirmDeleteUser = (user) => {
    deletingUser.value = user;
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
  