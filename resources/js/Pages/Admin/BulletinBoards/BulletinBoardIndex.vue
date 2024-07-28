<script setup>
import { ref, onMounted } from "vue";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";
import { usePermission } from "@/composables/permissions";
import Modal from "@/Components/Modal.vue";
import DangerButton from "@/Components/DangerButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";

defineProps(["bulletinboards"]);
const form = useForm({});
const showConfirmDeleteBulletinBoardModal = ref(false);
const showFileModal = ref(false);
const selectedFileUrl = ref(null);
const { hasPermission } = usePermission();

const confirmDeleteBulletinBoard = (bulletinboard) => {
    form.bulletinboard = bulletinboard;
    showConfirmDeleteBulletinBoardModal.value = true;
};

const closeModal = () => {
    showConfirmDeleteBulletinBoardModal.value = false;
    showFileModal.value = false;
};

const deleteBulletinBoard = () => {
    form.delete(route("bulletinboards.destroy", form.bulletinboard.id), {
        onSuccess: () => closeModal(),
    });
};

const viewFile = (fileUrl) => {
    selectedFileUrl.value = fileUrl;
    showFileModal.value = true;
};

onMounted(() => {
    console.log("Create bulletinboard permission:", hasPermission('create bulletinboard'));
});
</script>

<template>
    <Head title="Bulletinboards Index" />

    <AdminLayout>
        <div class="py-4 mx-auto max-w-7xl">
            <div class="flex justify-end">
                <template v-if="hasPermission('create bulletinboard')">
                    <Link
                        :href="route('bulletinboards.create')"
                        class="px-3 py-2 mr-3 font-semibold text-white bg-yellow-500 rounded hover:bg-yellow-700">
                        New Bulletinboard
                    </Link>
                </template>
            </div>
            <div class="mt-6 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 ml-3">
                <template v-for="bulletinboard in bulletinboards" :key="bulletinboard.id">
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <div class="p-6">
                            <h2 class="text-xl font-bold text-gray-800">{{ bulletinboard.caption }}</h2>
                            <div class="mb-2">
                                <span class="text-sm text-gray-600">{{ bulletinboard.date_time }}</span>
                            </div>
                            <div class="mt-4">
                                <div class="mb-2">
                                    <button
                                        v-if="bulletinboard.bb_file_url"
                                        @click="viewFile(bulletinboard.bb_file_url)"
                                        class="ml-2 text-blue-500 hover:text-blue-700"
                                    >
                                        View File   
                                    </button>
                                </div>

                            </div>
                            <div class="mt-4 flex justify-between items-center">
                                <template v-if="hasPermission('update bulletinboard')">
                                    <Link
                                        :href="route('bulletinboards.edit', bulletinboard.id)"
                                        class="text-green-500 hover:text-green-700"
                                    >
                                        Edit
                                    </Link>
                                </template>
                                <template v-if="hasPermission('delete bulletinboard')">
                                    <button
                                        @click="confirmDeleteBulletinBoard(bulletinboard)"
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
            :show="showConfirmDeleteBulletinBoardModal"
            @close="closeModal"
        >
            <div class="p-6">
                <h2 class="text-lg font-semibold text-slate-800">
                    Are you sure you want to delete this bulletinboard?
                </h2>
                <div class="mt-6 flex space-x-4">
                    <DangerButton @click="deleteBulletinBoard">
                        Delete
                    </DangerButton>
                    <SecondaryButton @click="closeModal">
                        Cancel
                    </SecondaryButton>
                </div>
            </div>
        </Modal>
        <Modal
            :show="showFileModal"
            @close="closeModal"
            maxWidth="5x1"
        >
            <div class="p-6">
                <h2 class="text-lg font-semibold text-slate-800">
                    Viewing File
                </h2>
                <iframe :src="selectedFileUrl" class="w-full h-96"></iframe>
                <div class="mt-4 flex justify-end">
                    <SecondaryButton @click="closeModal">
                        Close
                    </SecondaryButton>
                </div>
            </div>
        </Modal>
    </AdminLayout>
</template>
