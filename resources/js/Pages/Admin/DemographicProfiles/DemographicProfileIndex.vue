<script setup>
import { ref, onMounted } from "vue";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";
import { usePermission } from "@/composables/permissions";
import Modal from "@/Components/Modal.vue";
import DangerButton from "@/Components/DangerButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import TableHeaderCell from "@/Components/TableHeaderCell.vue";
import TableRow from "@/Components/TableRow.vue";
import TableDataCell from "@/Components/TableDataCell.vue";
import Table from "@/Components/Table.vue";

defineProps(["youthprofiles"]);
const form = useForm({});
const showConfirmDeleteProfileModal = ref(false);
const { hasPermission } = usePermission();

const confirmDeleteProfile = (profile) => {
    form.youthprofile = profile;
    showConfirmDeleteProfileModal.value = true;
};

const closeModal = () => {
    showConfirmDeleteProfileModal.value = false;
};

const deleteProfile = () => {
    form.delete(route("youthprofiles.destroy", form.youthprofile.id), {
        onSuccess: () => closeModal(),
    });
};

onMounted(() => {
    console.log("Create profile permission:", hasPermission('create profile'));
});
</script>

<template>
    <Head title="Youth Profiles Index" />

    <AdminLayout>
        <div class="py-4 mx-auto max-w-7xl">
            <div class="flex justify-end">
                <template v-if="hasPermission('create profile')">
                    <Link
                        :href="route('youthprofiles.create')"
                        class="px-3 py-2 mr-3 font-semibold text-white bg-indigo-500 rounded hover:bg-indigo-700">
                        New Profile
                    </Link>
                </template>
            </div>
            <div class="mt-6 flex justify-center">
                <div class="w-full max-w-5xl mx-4 shadow-lg">
                    <Table>
                        <template #header>
                            <TableRow>
                                <TableHeaderCell class="text-center">Name</TableHeaderCell>
                                <TableHeaderCell class="text-center">Email</TableHeaderCell>
                                <TableHeaderCell class="text-center">Region</TableHeaderCell>
                                <TableHeaderCell class="text-center">Province</TableHeaderCell>
                                <TableHeaderCell class="text-center">Municipality</TableHeaderCell>
                                <TableHeaderCell class="text-center">Baranggay</TableHeaderCell>
                                <TableHeaderCell class="text-center">Purok</TableHeaderCell>
                                <TableHeaderCell class="text-center">Sex</TableHeaderCell>
                                <TableHeaderCell class="text-center">Age</TableHeaderCell>
                                <TableHeaderCell class="text-center">Birthdate</TableHeaderCell>
                                <TableHeaderCell class="text-center">Contact No</TableHeaderCell>
                                <TableHeaderCell class="text-center">Civil Status</TableHeaderCell>
                                <TableHeaderCell class="text-center">Youth Age Group</TableHeaderCell>
                                <TableHeaderCell class="text-center">Educational Background</TableHeaderCell>
                                <TableHeaderCell class="text-center">Youth Classification</TableHeaderCell>
                                <TableHeaderCell class="text-center">Specific Needs Detail</TableHeaderCell>
                                <TableHeaderCell class="text-center">Work Status</TableHeaderCell>
                                <TableHeaderCell class="text-center">Registered SK Voter</TableHeaderCell>
                                <TableHeaderCell class="text-center">Registered National Voter</TableHeaderCell>
                                <TableHeaderCell class="text-center">SK Assembly</TableHeaderCell>
                                <TableHeaderCell class="text-center">Times Attended SK Assembly</TableHeaderCell>
                                <TableHeaderCell class="text-center">Reasons for Not Attending SK Assembly</TableHeaderCell>
                                <TableHeaderCell class="text-center">Vote Last SK Election</TableHeaderCell>
                                <TableHeaderCell class="text-center">Action</TableHeaderCell>
                            </TableRow>
                        </template>
                        <template #default>
                            <TableRow v-for="youthprofile in youthprofiles" :key="youthprofile.id" class="border-b text-center space-x-4">
                                <TableDataCell class="text-center">{{ youthprofile.first_name }} {{ youthprofile.middle_name }} {{ youthprofile.last_name }}</TableDataCell>
                                <TableDataCell class="text-center">{{ youthprofile.email }}</TableDataCell>
                                <TableDataCell class="text-center">{{ youthprofile.region }}</TableDataCell>
                                <TableDataCell class="text-center">{{ youthprofile.province }}</TableDataCell>
                                <TableDataCell class="text-center">{{ youthprofile.municipality }}</TableDataCell>
                                <TableDataCell class="text-center">{{ youthprofile.baranggay }}</TableDataCell>
                                <TableDataCell class="text-center">{{ youthprofile.purok }}</TableDataCell>
                                <TableDataCell class="text-center">{{ youthprofile.sex ? 'Male' : 'Female' }}</TableDataCell>
                                <TableDataCell class="text-center">{{ youthprofile.age }}</TableDataCell>
                                <TableDataCell class="text-center">{{ youthprofile.birthdate }}</TableDataCell>
                                <TableDataCell class="text-center">{{ youthprofile.contact_no }}</TableDataCell>
                                <TableDataCell v-if="youthprofile.demographic" class="text-center">{{ youthprofile.demographic.civil_status }}</TableDataCell>
                                <TableDataCell v-else class="text-center">N/A</TableDataCell>
                                <TableDataCell v-if="youthprofile.demographic" class="text-center">{{ youthprofile.demographic.youth_age_group }}</TableDataCell>
                                <TableDataCell v-else class="text-center">N/A</TableDataCell>
                                <TableDataCell v-if="youthprofile.demographic" class="text-center">{{ youthprofile.demographic.educational_background }}</TableDataCell>
                                <TableDataCell v-else class="text-center">N/A</TableDataCell>
                                <TableDataCell v-if="youthprofile.demographic" class="text-center">{{ youthprofile.demographic.youth_classification }}</TableDataCell>
                                <TableDataCell v-else class="text-center">N/A</TableDataCell>
                                <TableDataCell v-if="youthprofile.demographic" class="text-center">{{ youthprofile.demographic.specific_needs_detail }}</TableDataCell>
                                <TableDataCell v-else class="text-center">N/A</TableDataCell>
                                <TableDataCell v-if="youthprofile.demographic" class="text-center">{{ youthprofile.demographic.work_status }}</TableDataCell>
                                <TableDataCell v-else class="text-center">N/A</TableDataCell>
                                <TableDataCell v-if="youthprofile.demographic" class="text-center">{{ youthprofile.demographic.registered_sk_voter ? 'Yes' : 'No' }}</TableDataCell>
                                <TableDataCell v-else class="text-center">N/A</TableDataCell>
                                <TableDataCell v-if="youthprofile.demographic" class="text-center">{{ youthprofile.demographic.registered_national_voter ? 'Yes' : 'No' }}</TableDataCell>
                                <TableDataCell v-else class="text-center">N/A</TableDataCell>
                                <TableDataCell v-if="youthprofile.demographic" class="text-center">{{ youthprofile.demographic.sk_assembly ? 'Yes' : 'No' }}</TableDataCell>
                                <TableDataCell v-else class="text-center">N/A</TableDataCell>
                                <TableDataCell v-if="youthprofile.demographic" class="text-center">{{ youthprofile.demographic.sk_assembly_times_attended }}</TableDataCell>
                                <TableDataCell v-else class="text-center">N/A</TableDataCell>
                                <TableDataCell v-if="youthprofile.demographic" class="text-center">{{ youthprofile.demographic.sk_assembly_not_attended }}</TableDataCell>
                                <TableDataCell v-else class="text-center">N/A</TableDataCell>
                                <TableDataCell v-if="youthprofile.demographic" class="text-center">{{ youthprofile.demographic.vote_last_sk_election ? 'Yes' : 'No' }}</TableDataCell>
                                <TableDataCell v-else class="text-center">N/A</TableDataCell>
                                <TableDataCell class="text-center space-x-4">
                                    <template v-if="hasPermission('update profile')">
                                        <Link
                                            :href="route('youthprofiles.edit', youthprofile.id)"
                                            class="text-green-400 hover:text-green-600"
                                        >
                                            Edit
                                        </Link>
                                    </template>
                                    <template v-if="hasPermission('delete profile')">
                                        <button
                                            @click="confirmDeleteProfile(youthprofile)"
                                            class="text-red-400 hover:text-red-600"
                                        >
                                            Delete
                                        </button>
                                    </template>
                                </TableDataCell>
                            </TableRow>
                        </template>
                    </Table>
                </div>
            </div>
            <Modal
                :show="showConfirmDeleteProfileModal"
                @close="closeModal"
            >
                <div class="p-6">
                    <h2 class="text-lg font-semibold text-slate-800">
                        Are you sure you want to delete this profile?
                    </h2>
                    <div class="mt-6 flex space-x-4">
                        <DangerButton @click="deleteProfile">Delete</DangerButton>
                        <SecondaryButton @click="closeModal">Cancel</SecondaryButton>
                    </div>
                </div>
            </Modal>
        </div>
    </AdminLayout>
</template>
