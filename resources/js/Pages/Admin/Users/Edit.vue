<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";
import VueMultiselect from "vue-multiselect";
import Table from "@/Components/Table.vue";
import TableRow from "@/Components/TableRow.vue";
import TableDataCell from "@/Components/TableDataCell.vue";
import TableHeaderCell from "@/Components/TableHeaderCell.vue";
import { onMounted, watch } from "vue";

const props = defineProps({
  user: {
    type: Object,
    required: true,
  },
  roles: Array,
  permissions: Array
});

const form = useForm({
  name: props.user?.name,
  email: props.user?.email,
  roles: [],
  permissions: []
});

const submit = () => {
  form.put(route("users.update", props.user?.id));
};

onMounted(() => {
  form.permissions = props.user?.permissions;
  form.roles = props.user?.roles;
});

watch(
  () => props.user,
  () => {
    form.permissions = props.user?.permissions,
    form.roles = props.user?.roles
  }
);
</script>

<template>
  <AdminLayout>
    <Head title="Edit user" />
    <div class="py-4 max-w-7xl mx-auto">
        <div class="flex justify-end">
            <Link :href="route('users.index')" class="px-3 py-2 mr-3 font-semibold text-white bg-indigo-500 rounded hover:bg-indigo-700">Back</Link>
        </div>
    </div>
    <div class="max-w-6x1 p-6 mx-6 rounded-lg shadow-lg bg-slate-300">
      <form @submit.prevent="submit">
        <div>
          <InputLabel for="name" value="Name" />

          <TextInput
            id="name"
            type="text"
            class="mt-1 block w-full"
            v-model="form.name"
            required
            autofocus
            autocomplete="name"
          />

          <InputError class="mt-2" :message="form.errors.name" />
        </div>

        <div class="mt-4">
          <InputLabel for="email" value="Email" />

          <TextInput
            id="email"
            type="email"
            class="mt-1 block w-full"
            v-model="form.email"
            required
            autocomplete="username"
          />

          <InputError class="mt-2" :message="form.errors.email" />
        </div>

        <div class="mt-4">
            <InputLabel for="roles" value="Roles" />
            <VueMultiselect
              v-model="form.roles"
              :options="roles"
              :multiple="true"
              :close-on-select="true"
              placeholder="Pick some"
              label="name"
              track-by="id"
            />
          </div>
        <div class="flex items-center justify-end mt-4">
          <PrimaryButton
            class="ml-4"
            :class="{ 'opacity-25': form.processing }"
            :disabled="form.processing"
          >
            Update User
          </PrimaryButton>
        </div>
      </form>
    </div>
    <div class="max-w-6x1 p-6 mx-6 mt-6 rounded-lg shadow-lg bg-slate-300">
        <h1 class="text-2xl font-semibold text-indigo-700">Roles</h1>
        <div class="bg-white">
          <Table>
            <template #header>
              <TableRow>
                <TableHeaderCell>ID</TableHeaderCell>
                <TableHeaderCell>Name</TableHeaderCell>
                <TableHeaderCell>Action</TableHeaderCell>
              </TableRow>
            </template>
            <template #default>
              <TableRow
                v-for="userRole in user.roles"
                :key="userRole.id"
                class="border-b text-center"
              >
                <TableDataCell>{{ userRole.id }}</TableDataCell>
                <TableDataCell>{{ userRole.name }}</TableDataCell>
                <TableDataCell class="space-x-4">
                  <Link
                    :href="route('users.roles.destroy', [user.id, userRole.id])"
                    method="DELETE"
                    as="button"
                    class="text-red-400 hover:text-red-600"
                    preserve-scroll>Revoke</Link
                  >
                </TableDataCell>
              </TableRow>
            </template>
          </Table>
        </div>
      </div>
  </AdminLayout>
</template>
<style src="vue-multiselect/dist/vue-multiselect.css"></style>
