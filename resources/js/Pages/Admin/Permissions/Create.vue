<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link, useForm }  from "@inertiajs/vue3";
import  PrimaryButton  from "@/Components/PrimaryButton.vue";
import  InputLabel  from "@/Components/InputLabel.vue";
import  InputError  from "@/Components/InputError.vue";
import  TextInput  from "@/Components/TextInput.vue";


const form = useForm({
    name: ""
})
</script>

<template>
    <Head title="Create Permission" />
    <AdminLayout>
        <div class="py-4 mx-auto max-w-7xl">
            <div class="flex justify-end">
                <Link :href="route('permissions.index')" >
                    <PrimaryButton
                    class="ml-4"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                     > Back </PrimaryButton>
                </Link>
            </div>
            <div class="max-w-md p-6 mx-auto mt-6 rounded-lg shadow-lg bg-slate-100">
                <h1 class="text-2xl font-semibold text-indigo-700">Create new permission</h1>
                <form @submit.prevent="form.post(route('permissions.store'))">
                    <div>
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
