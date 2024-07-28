<template>
  <Head title="Admin" />
  <AdminLayout>
    <div class="py-4 background-image">
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        <PieChart v-if="youthprofiles?.length" :data="youthprofiles" label="sex" :colors="['navy', 'purple']" />
        <BarChart v-if="youthprofiles?.length" :data="youthprofiles" label="barangay"/>
        <BarChart v-if="youthprofiles?.length" :data="youthprofiles" label="purok" />
        <DoughnutChart v-if="youthprofiles?.length" :data="civilStatusData" label="civil_status" :colors="['navy', 'crimson', 'orange', 'forestgreen']" />
        <DoughnutChart v-if="youthprofiles?.length" :data="youthAgeGroupData" label="youth_age_group" :colors="['navy', 'crimson', 'orange', 'forestgreen']" />
        <DoughnutChart v-if="youthprofiles?.length" :data="educationalBackground" label="educational_background" :colors="['navy', 'crimson', 'orange', 'forestgreen']" />
        <DoughnutChart v-if="youthprofiles?.length" :data="youthClassification" label="youth_classification" :colors="['coral', 'cadetblue', 'darkkhaki', 'darkolivegreen']" />
        <DoughnutChart v-if="youthprofiles?.length" :data="specificNeedsDetail" label="specific_needs_detail" :colors="['coral', 'cadetblue', 'darkkhaki', 'darkolivegreen']" />
        <DoughnutChart v-if="youthprofiles?.length" :data="workStatus" label="work_status" :colors="['coral', 'cadetblue', 'darkkhaki', 'darkolivegreen']" />
      </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import { ref, computed } from 'vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head } from '@inertiajs/vue3';
import BarChart from '@/Components/BarChart.vue';
import DoughnutChart from '@/Components/DoughnutChart.vue';
import PieChart from '@/Components/PieChart.vue';

const props = defineProps({
  youthprofiles: Array
});

const youthprofiles = ref(props.youthprofiles);

const civilStatusData = computed(() => {
  return youthprofiles.value.map(profile => profile.demographic.civil_status);
});

const youthAgeGroupData = computed(() => {
  return youthprofiles.value.map(profile => profile.demographic.youth_age_group);
});

const educationalBackground = computed(() => {
  return youthprofiles.value.map(profile => profile.demographic.educational_background);
});

const youthClassification = computed(() => {
  return youthprofiles.value.map(profile => profile.demographic.youth_classification);
});

const specificNeedsDetail = computed(() => {
  return youthprofiles.value.map(profile => profile.demographic.specific_needs_detail);
});

const workStatus = computed(() => {
  return youthprofiles.value.map(profile => profile.demographic.work_status);
});

console.log('youthprofiles:', youthprofiles.value); // Add this to see if data is correct
console.log('civilStatusData:', civilStatusData.value); // Add this to see if civil status data is correct
console.log('youthAgeGroupData:', youthAgeGroupData.value); // Add this to see if youth age group data is correct
</script>

<style scoped>
.background-image {
  background-image: url('/image/Design (3).png'); /* Replace with your image path */
  background-size: cover;
  background-position: center;
  background-repeat: no-repeat;
  min-height: 100vh; /* Ensure it covers the full viewport height */
}
</style>