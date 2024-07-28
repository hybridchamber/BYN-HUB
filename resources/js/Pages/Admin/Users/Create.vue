<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import VueMultiselect from "vue-multiselect";

defineProps({
  roles: Array,
  permissions: Array
})

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    roles: [],
    permissions: []
});

const submit = () => {
    form.post(route('users.store'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <Head title="Create User" />
    <AdminLayout>
        <div class="py-4 mx-auto max-w-7xl">
            <div class="flex justify-end">
                <Link :href="route('users.index')" class="px-3 py-2 mr-3 font-semibold text-white bg-red-700 rounded hover:bg-red-900">Back</Link>
            </div>
            <form @submit.prevent="submit" class="max-w-md mx-auto bg-white p-6 rounded-lg shadow-md">
                <h1 class="text-2xl font-bold text-center mb-4">Create New User</h1>

                <!-- Name Field -->
                <div class="mb-4">
                    <InputLabel for="name" value="Name" />
                    <TextInput
                        id="name"
                        type="text"
                        v-model="form.name"
                        required
                        autofocus
                        autocomplete="name"
                        placeholder="Enter name"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                    />
                    <InputError :message="form.errors.name" class="mt-2" />
                </div>

                <!-- Email Field -->
                <div class="mb-4">
                    <InputLabel for="email" value="Email" />
                    <TextInput
                        id="email"
                        type="email"
                        v-model="form.email"
                        required
                        autocomplete="email"
                        placeholder="Enter email"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                    />
                    <InputError :message="form.errors.email" class="mt-2" />
                </div>

                <!-- Password Field -->
                <div class="mb-4">
                    <InputLabel for="password" value="Password" />
                    <TextInput
                        id="password"
                        type="password"
                        v-model="form.password"
                        required
                        autocomplete="new-password"
                        placeholder="Enter password"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                    />
                    <InputError :message="form.errors.password" class="mt-2" />
                </div>

                <!-- Confirm Password Field -->
                <div class="mb-4">
                    <InputLabel for="password_confirmation" value="Confirm Password" />
                    <TextInput
                        id="password_confirmation"
                        type="password"
                        v-model="form.password_confirmation"
                        required
                        autocomplete="new-password"
                        placeholder="Confirm password"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                    />
                    <InputError :message="form.errors.password_confirmation" class="mt-2" />
                </div>
                <div class="mb-4">
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
                <!-- Submit Button -->
                <div class="flex justify-end">
                    <PrimaryButton
                        type="submit"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                        class="w-full md:w-auto bg-red-700"
                    >
                        {{ form.processing ? 'Creating...' : 'Create User' }}
                    </PrimaryButton>
                </div>
            </form>
        </div>
    </AdminLayout>
</template>
<style src="vue-multiselect/dist/vue-multiselect.css"></style>
<script>
export default {
    components: {
        Head,
        Link,
        InputError,
        InputLabel,
        PrimaryButton,
        TextInput,
        AdminLayout,
    },
};
</script>
