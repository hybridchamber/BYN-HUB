<script setup>
import { router } from '@inertiajs/vue3';

const handleCardClick = (routeName) => {
    router.visit(route(routeName));
};
</script>

<template>
    <GuestLayout>
        <div class="flex items-center justify-center min-h-screen bg-cover bg-center" style="background-image: url('/image/Design (16).png');">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 bg-opacity-75 p-4 rounded">
                <div @click="handleCardClick('card1')" class="p-4 border rounded shadow cursor-pointer bg-gray-200 bg-opacity-90">
                    <img src="/image/admin (3).png" alt="User 1" class="w-16 h-16 rounded-full mx-auto mb-4">
                    <h3 class="text-lg font-semibold text-center">ADMIN</h3>
                </div>
                <div @click="handleCardClick('card2')" class="p-4 border rounded shadow cursor-pointer bg-gray-200 bg-opacity-90">
                    <img src="/image/SK.png" alt="User 2" class="w-16 h-16 rounded-full mx-auto mb-4">
                    <h3 class="text-lg font-semibold text-center">SK-MEMBER</h3>
                </div>
                <div @click="handleCardClick('card3')" class="p-4 border rounded shadow cursor-pointer bg-gray-200 bg-opacity-90">
                    <img src="/image/youth (3).png" alt="User 3" class="w-16 h-16 rounded-full mx-auto mb-4">
                    <h3 class="text-lg font-semibold text-center">YOUTH</h3>
                </div>
            </div>
        </div>
    </GuestLayout>
</template>