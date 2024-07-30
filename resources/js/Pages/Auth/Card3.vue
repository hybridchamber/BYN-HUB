<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { router } from '@inertiajs/vue3';

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};

const handleCardClick = (routeName) => {
    router.visit(route(routeName));
};

const choices = [
    { value: 'mallig', label: 'MALLIG' },
    { value: 'casili', label: 'CASILI' },
    { value: 'san_pedro', label: 'SAN PEDRO' },
];
</script>

<template>
    <GuestLayout>
        <Head title="Log in" />

        <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
            {{ status }}
        </div>

        <div class="mb-4">
           
            <div class="flex flex-wrap gap-4">
                <div v-for="choice in choices" :key="choice.value" class="relative border rounded-md p-4 cursor-pointer flex-1" :class="{'border-indigo-500': selectedChoice === choice.value}">
                    <input type="radio" :id="choice.value" :value="choice.value" v-model="selectedChoice" class="sr-only" />
                    <label :for="choice.value" class="block text-center">
                        {{ choice.label }}
                    </label>
                </div>
            </div>
        </div>

        <form @submit.prevent="submit">
            <div>
                <InputLabel for="email" value="Email" />

                <TextInput
                    id="email"
                    type="email"
                    class="mt-1 block w-full"
                    v-model="form.email"
                    required
                    autofocus
                    autocomplete="username"
                />

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="mt-4">
                <InputLabel for="password" value="Password" />

                <TextInput
                    id="password"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password"
                    required
                    autocomplete="current-password"
                />

                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="block mt-4">
                <label class="flex items-center">
                    <Checkbox name="remember" v-model:checked="form.remember" />
                    <span class="ms-2 text-sm text-gray-600">Remember me</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                <Link
                    v-if="canResetPassword"
                    :href="route('password.request')"
                    class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                >
                    Forgot your password?
                </Link>

                <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Log in
                </PrimaryButton>
            </div>
        </form>
    </GuestLayout>
</template>

<script>
export default {
    data() {
        return {
            selectedChoice: '',
            form: {
                email: '',
                password: '',
                remember: false,
                processing: false,
                errors: {}
            },
            status: null,
            canResetPassword: true,
            choices: [
                { value: 'mallig', label: 'MALLIG' },
                { value: 'casili', label: 'CASILI' },
                { value: 'san_pedro', label: 'SAN PEDRO' },
            ]
        };
    },
    methods: {
        submit() {
            // Your form submission logic
        }
    }
};
</script>

<style>
.radio-box {
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
}

.radio-box div {
    flex: 1 1 calc(33.333% - 1rem);
    border: 1px solid #d1d5db;
    border-radius: 0.375rem;
    padding: 1rem;
    cursor: pointer;
    text-align: center;
    transition: border-color 0.2s ease;
}

.radio-box input[type="radio"] {
    display: none;
}

.radio-box input[type="radio"]:checked + label {
    border-color: #6366f1;
    background-color: #eef2ff;
}
</style>
