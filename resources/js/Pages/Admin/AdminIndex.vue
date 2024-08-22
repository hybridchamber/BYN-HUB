<template>
  <Head title="Admin" />
  <AdminLayout>
    <div>
      <!-- Grouped Charts in a Larger Card -->
      <div v-if="youthprofiles?.length" class="card">
        <h3 class="font-semibold text-lg">Demographic Charts</h3>
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
          <div class="lg:col-span-2">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div class="card">
                <PieChart :data="youthprofiles" label="sex" :colors="['#9De3FF', '#D7278B']" />
              </div>
              <div class="card">
                <DoughnutChart :data="civilStatusData" label="civil_status" :colors="['#F67C79', '#F6EBBD', '#D75A4D', '#9D3223']" />
              </div>
              <div class="card">
                <DoughnutChart :data="youthAgeGroupData" label="youth_age_group" :colors="['#F67C79', '#F6EBBD', '#D75A4D', '#9D3223']" />
              </div>
              <div class="card">
                <DoughnutChart :data="youthClassification" label="youth_classification" :colors="['#F67C79', '#F6EBBD', '#D75A4D', '#9D3223']" />
              </div>
            </div>
          </div>

          <!-- Educational Background, Work Status, and Specific Needs Card -->
          <div class="card">
            <h3 class="font-semibold text-lg">Educational Background</h3>
            <ul>
              <li v-for="(count, key) in educationalBackgroundCounts" :key="key">
                {{ key }}: {{ count }}
              </li>
            </ul>

            <h4 class="font-semibold text-lg mt-4">Work Status</h4>
            <ul>
              <li v-for="(statusCount, statusKey) in workStatusCounts" :key="statusKey">
                {{ statusKey }}: {{ statusCount }}
              </li>
            </ul>

            <h4 class="font-semibold text-lg mt-4">Specific Needs</h4>
            <ul>
              <li v-for="(needsCount, needsKey) in specificNeedsDetailCounts" :key="needsKey">
                {{ needsKey }}: {{ needsCount }}
              </li>
            </ul>
          </div>
        </div>

        <!-- Bar Charts Side by Side -->
        <div class="lg:col-span-3 grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
          <div class="card">
            <BarChart :data="youthprofiles" label="baranggay" />
          </div>
          <div class="card">
            <BarChart :data="youthprofiles" label="purok" />
          </div>
        </div>
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

// Data computation for charts
const civilStatusData = computed(() => {
  return youthprofiles.value.map(profile => profile.demographic.civil_status);
});

const youthAgeGroupData = computed(() => {
  return youthprofiles.value.map(profile => profile.demographic.youth_age_group);
});

const educationalBackgroundCounts = computed(() => {
  const counts = {};
  youthprofiles.value.forEach(profile => {
    const background = profile.demographic.educational_background;
    if (counts[background]) {
      counts[background]++;
    } else {
      counts[background] = 1;
    }
  });
  return counts;
});

const youthClassification = computed(() => {
  return youthprofiles.value.map(profile => profile.demographic.youth_classification);
});

const specificNeedsDetailCounts = computed(() => {
  const counts = {};
  youthprofiles.value.forEach(profile => {
    const need = profile.demographic.specific_needs_detail;
    if (need) {
      if (counts[need]) {
        counts[need]++;
      } else {
        counts[need] = 1;
      }
    }
  });
  return counts;
});

const workStatus = computed(() => {
  return youthprofiles.value.map(profile => profile.demographic.work_status);
});

const workStatusCounts = computed(() => {
  const counts = {};
  workStatus.value.forEach(status => {
    if (counts[status]) {
      counts[status]++;
    } else {
      counts[status] = 1;
    }
  });
  return counts;
});
</script>

<style scoped>
.card {
  background: white;
  border-radius: 8px;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.4);
  padding: 15px;
}

.grid {
  gap: 1rem;
}

.mt-4 {
  margin-top: 1rem;
}
</style>