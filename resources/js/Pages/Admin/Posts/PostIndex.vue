<script setup>
import { ref, onMounted } from "vue";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";
import  PrimaryButton  from "@/Components/PrimaryButton.vue";
import { usePermission } from "@/composables/permissions";
import Modal from "@/Components/Modal.vue";
import DangerButton from "@/Components/DangerButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";

defineProps(["posts"]);
const form = useForm({});
const showConfirmDeletePostModal = ref(false);
const { hasPermission } = usePermission();

const confirmDeletePost = (post) => {
    form.post = post;
    showConfirmDeletePostModal.value = true;
};

const closeModal = () => {
    showConfirmDeletePostModal.value = false;
};

const deletePost = () => {
    form.delete(route("posts.destroy", form.post.id), {
        onSuccess: () => closeModal(),
    });
};

onMounted(() => {
    console.log("Create post permission:", hasPermission('create post'));
});
</script>

<template>
    <Head title="Posts Index" />

    <AdminLayout>
        <div class="py-4 mx-auto max-w-7xl">
            <div class="flex justify-end">
                <template v-if="hasPermission('create post')">
                    <Link
                        :href="route('posts.create')"
                        ><PrimaryButton
                    class="ml-4"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                     > New Post </PrimaryButton>
                    </Link>
                </template>
            </div>
            <div class="mt-6 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 ml-3">
                <template v-for="post in posts" :key="post.id">
                    <div class="bg-gray-200 rounded-lg shadow-md overflow-hidden">
                        <img :src="post.cover_photo_url" alt="Cover Photo" class="w-full h-48 object-cover"/>
                        <div class="p-6">
                            <h2 class="text-xl font-bold text-gray-800">{{ post.title }}</h2>
                            <p class="mt-2 text-gray-600">{{ post.description }}</p>
                            <div class="mt-4">
                                <div class="mb-2">
                                    <h3 class="font-semibold text-gray-700">Category</h3>
                                    <span class="text-sm text-gray-600">{{ post.category }}</span>
                                </div>
                                <div class="mb-2">
                                    <h3 class="font-semibold text-gray-700">Location</h3>
                                    <span class="text-sm text-gray-600">{{ post.location }}</span>
                                </div>
                                <div class="mb-2">
                                    <h3 class="font-semibold text-gray-700">Date and Time</h3>
                                    <span class="text-sm text-gray-600">{{ post.date_time }}</span>
                                </div>
                                <div class="mb-2">
                                    <h3 class="font-semibold text-gray-700">Send Invitation</h3>
                                    <span class="text-sm text-gray-600">{{ post.invite ? 'Yes' : 'No' }}</span>
                                </div>
                            </div>
                            <div class="mt-4 flex justify-between items-center">
                                <template v-if="hasPermission('update post')">
                                    <Link
                                        :href="route('posts.edit', post.id)"
                                        class="text-green-500 hover:text-green-700"
                                    >
                                        Edit
                                    </Link>
                                </template>
                                <template v-if="hasPermission('delete post')">
                                    <button
                                        @click="confirmDeletePost(post)"
                                        class="text-red-500 hover:text-red-700"
                                    >
                                        Delete
                                    </button>
                                </template>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </div>
        <Modal
            :show="showConfirmDeletePostModal"
            @close="closeModal"
        >
            <div class="p-6">
                <h2 class="text-lg font-semibold text-slate-800">
                    Are you sure you want to delete this post?
                </h2>
                <div class="mt-6 flex space-x-4">
                    <DangerButton @click="deletePost">
                        Delete
                    </DangerButton>
                    <SecondaryButton @click="closeModal">
                        Cancel
                    </SecondaryButton>
                </div>
            </div>
        </Modal>
    </AdminLayout>
</template>
