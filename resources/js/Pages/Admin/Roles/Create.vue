<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link, useForm }  from "@inertiajs/vue3";
import  PrimaryButton  from "@/Components/PrimaryButton.vue";
import  InputLabel  from "@/Components/InputLabel.vue";
import  InputError  from "@/Components/InputError.vue";
import  TextInput  from "@/Components/TextInput.vue";
import VueMultiselect from 'vue-multiselect';


defineProps({
    permissions: Array,
});

const form = useForm({
    name: "",
    permissions: [],
})

</script>

<template>
    <Head title="Create Role" />
    <AdminLayout>
        <div class="py-4 mx-auto max-w-7xl">
            <div class="flex justify-end">
                <Link :href="route('roles.index')" class="px-3 py-2 mr-3 font-semibold text-white bg-red-700 rounded hover:bg-red-900">Back</Link>
            </div>
            <div class="max-w-md p-6 mx-auto mt-6 rounded-lg shadow-lg bg-slate-100">
                <h1 class="p-4 mb-5 text-2xl text-center">Create new role</h1>
                <form @submit.prevent="form.post(route('roles.store'))">
                    <div class="mt-4">
                        <InputLabel for="name" value="Name" />

                        <TextInput
                            id="name"
                            type="text"
                            class="block w-full mt-1"
                            v-model="form.name"
                            autofocus
                            autocomplete="username"
                        />

                        <InputError class="mt-2" :message="form.errors.name" />
                    </div>
                    <div class="mt-4">
                        <InputLabel for="permissions" value="Permissions" />

                        <VueMultiselect
                            v-model="form.permissions"
                            :options="permissions"
                            :multiple="true"
                            :close-on-select="true"
                            placeholder="Pick permissions"
                            label="name"
                            track-by="id"
                            open-direction="bottom"
                        />

                        <InputError class="mt-2" :message="form.errors.permissions" />
                    </div>
                    <div class="flex items-start mt-4">
                        <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing" class="bg-red-700">
                            Create
                        </PrimaryButton>
                    </div>
                </form>
            </div>
        </div>
    </AdminLayout>
</template>

<style src="vue-multiselect/dist/vue-multiselect.css"></style>

<script>
export default {
    components: {
        Head,
        PrimaryButton,
        InputLabel,
        InputError,
        TextInput,
    },
};
</script>
