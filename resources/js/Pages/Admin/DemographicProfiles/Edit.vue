<script setup>
import { Head, useForm, Link } from '@inertiajs/vue3';
import { ref, watch, computed, onMounted } from 'vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import ChooseInput from '@/Components/ChooseInput.vue';
import DatePicker from '@/Components/DatePicker.vue';
import RadioButton from '@/Components/RadioButton.vue';
import axios from 'axios';

const props = defineProps({
  youthprofile: Object,
});

const form = useForm({
  id: props.youthprofile.id,
  first_name: props.youthprofile.first_name,
  middle_name: props.youthprofile.middle_name,
  last_name: props.youthprofile.last_name,
  suffix: props.youthprofile.suffix,
  region: props.youthprofile.region,
  province: props.youthprofile.province,
  municipality: props.youthprofile.municipality,
  baranggay: props.youthprofile.baranggay,
  purok: props.youthprofile.purok,
  sex: props.youthprofile.sex,
  age: props.youthprofile.age,
  birthdate: props.youthprofile.birthdate,
  email: props.youthprofile.email,
  contact_no: props.youthprofile.contact_no,
  civil_status: props.youthprofile.demographic.civil_status,
  youth_age_group: props.youthprofile.demographic.youth_age_group,
  educational_background: props.youthprofile.demographic.educational_background,
  youth_classification: props.youthprofile.demographic.youth_classification,
  specific_needs_detail: props.youthprofile.demographic.specific_needs_detail,
  work_status: props.youthprofile.demographic.work_status,
  registered_sk_voter: props.youthprofile.demographic.registered_sk_voter,
  registered_national_voter: props.youthprofile.demographic.registered_national_voter,
  sk_assembly: props.youthprofile.demographic.sk_assembly,
  sk_assembly_times_attended: props.youthprofile.demographic.sk_assembly_times_attended,
  sk_assembly_not_attended: props.youthprofile.demographic.sk_assembly_not_attended,
  vote_last_sk_election: props.youthprofile.demographic.vote_last_sk_election,
});

const handleSubmit = async () => {
  validateAge();
  if (!form.errors.age && !form.errors.birthdate) {
             await form.put(route("youthprofiles.update", form.id), {
        });
    }
};

watch(() => form.age, (newAge) => {
  if (newAge >= 15 && newAge <= 17) {
    form.youth_age_group = 'Child Youth (15-17 Years Old)';
  } else if (newAge >= 18 && newAge <= 24) {
    form.youth_age_group = 'Core Youth (18-24 Years Old)';
  } else if (newAge >= 25 && newAge <= 30) {
    form.youth_age_group = 'Young Adult (25-30 Years Old)';
  } else {
    form.youth_age_group = '';
  }
});

// Calculate age from birthdate
const calculateAge = (birthdate) => {
  const today = new Date();
  const birthDate = new Date(birthdate);
  let age = today.getFullYear() - birthDate.getFullYear();
  const monthDifference = today.getMonth() - birthDate.getMonth();
  if (monthDifference < 0 || (monthDifference === 0 && today.getDate() < birthDate.getDate())) {
    age--;
  }
  return age;
};

// Validate age and birthdate
const validateAge = () => {
  if (form.birthdate) {
    const calculatedAge = calculateAge(form.birthdate);
    if (calculatedAge !== parseInt(form.age)) {
      form.errors.age = 'Age and Birthdate do not match.';
      form.errors.birthdate = 'Age and Birthdate do not match.';
    } else {
      delete form.errors.age;
      delete form.errors.birthdate;
    }
  } else {
    delete form.errors.age;
    delete form.errors.birthdate;
  }
};

// Watchers to validate age and birthdate
watch(() => form.birthdate, validateAge);
watch(() => form.age, validateAge);


const showSpecificNeedsDetail = ref(false);
watch(() => form.youth_classification, (newValue) => {
  showSpecificNeedsDetail.value = newValue === 'Youth w/ Specific Needs';
  if (!showSpecificNeedsDetail.value) {
    form.specific_needs_detail = 'Youth without Specific Needs';
  } else {
    form.specific_needs_detail = '';
  }
});

const showSKAssemblyDetails = ref(false);
const showSKAssemblyNotAttended = ref(false);

watch(() => form.sk_assembly, (newValue) => {
  if (newValue === 'Yes') {
    showSKAssemblyDetails.value = true;
    showSKAssemblyNotAttended.value = false;
  } else if (newValue === 'No') {
    showSKAssemblyDetails.value = false;
    showSKAssemblyNotAttended.value = true;
  } else {
    showSKAssemblyDetails.value = false;
    showSKAssemblyNotAttended.value = false;
  }
});

onMounted(() => {
  showSpecificNeedsDetail.value = form.youth_classification === 'Youth w/ Specific Needs';
  if (form.sk_assembly === 'Yes') {
    showSKAssemblyDetails.value = true;
    showSKAssemblyNotAttended.value = false;
  } else if (form.sk_assembly === 'No') {
    showSKAssemblyDetails.value = false;
    showSKAssemblyNotAttended.value = true;
  } else {
    showSKAssemblyDetails.value = false;
    showSKAssemblyNotAttended.value = false;
  }
});

const regions = ref([]);
const provinces = ref([]);
const municipalities = ref([]);
const barangays = ref([]);

const loadingRegions = ref(false);
const loadingProvinces = ref(false);
const loadingMunicipalities = ref(false);
const loadingBarangays = ref(false);

const regionMap = ref({});
const provinceMap = ref({});
const municipalityMap = ref({});
const barangayMap = ref({});

const fetchRegions = async () => {
  loadingRegions.value = true;
  try {
    const response = await axios.get('/api/regions');
    regions.value = response.data;
    response.data.forEach(region => {
      regionMap.value[region.name] = region.code;
    });
  } catch (error) {
    console.error('Error fetching regions:', error);
    setTimeout(fetchRegions, 1000);
  } finally {
    loadingRegions.value = false;
  }
};

const fetchProvinces = async (regionName) => {
  loadingProvinces.value = true;
  try {
    const regionCode = regionMap.value[regionName];
    const response = await axios.get(`/api/regions/${regionCode}/provinces`);
    provinces.value = response.data;
    provinceMap.value = {};
    response.data.forEach(province => {
      provinceMap.value[province.name] = province.code;
    });
    municipalities.value = [];
    barangays.value = [];
  } catch (error) {
    console.error('Error fetching provinces:', error);
    setTimeout(() => fetchProvinces(regionName), 1000);
  } finally {
    loadingProvinces.value = false;
  }
};

const fetchMunicipalities = async (provinceName) => {
  loadingMunicipalities.value = true;
  try {
    const provinceCode = provinceMap.value[provinceName];
    const response = await axios.get(`/api/provinces/${provinceCode}/municipalities`);
    municipalities.value = response.data;
    municipalityMap.value = {};
    response.data.forEach(municipality => {
      municipalityMap.value[municipality.name] = municipality.code;
    });
    barangays.value = [];
  } catch (error) {
    console.error('Error fetching municipalities:', error);
    setTimeout(() => fetchMunicipalities(provinceName), 1000);
  } finally {
    loadingMunicipalities.value = false;
  }
};

const fetchBarangays = async (municipalityName) => {
  loadingBarangays.value = true;
  try {
    const municipalityCode = municipalityMap.value[municipalityName];
    const response = await axios.get(`/api/municipalities/${municipalityCode}/barangays`);
    barangays.value = response.data;
    barangayMap.value = {};
    response.data.forEach(barangay => {
      barangayMap.value[barangay.name] = barangay.code;
    });
  } catch (error) {
    console.error('Error fetching barangays:', error);
    setTimeout(() => fetchBarangays(municipalityName), 1000);
  } finally {
    loadingBarangays.value = false;
  }
};

// Fetch regions on component mount
onMounted(async () => {
  await fetchRegions();
  await fetchProvinces(form.region);
  await fetchMunicipalities(form.province);
  await fetchBarangays(form.municipality);
});

watch(() => form.region, async (newRegion) => {
  if (newRegion) {
    form.province = '';
    form.municipality = '';
    form.baranggay = '';
    await fetchProvinces(newRegion);
  }
});

watch(() => form.province, async (newProvince) => {
  if (newProvince) {
    form.municipality = '';
    form.baranggay = '';
    await fetchMunicipalities(newProvince);
  }
});

watch(() => form.municipality, async (newMunicipality) => {
  if (newMunicipality) {
    form.baranggay = '';
    await fetchBarangays(newMunicipality);
  }
});
</script>
<template>
  <Head title="Edit Youth Profile" />

  <AdminLayout>
    <div class="max-w-7xl mx-auto py-4">
      <div class="flex justify-end">
        <Link
          :href="route('youthprofiles.index')">
          <PrimaryButton
               class="ml-4"
              :class="{ 'opacity-25': form.processing }"
              :disabled="form.processing"
              > Back 
          </PrimaryButton>
        </Link>
      </div>
      <div class="mt-6 max-w-6xl mx-auto bg-slate-100 shadow-lg rounded-lg p-6">
        <h1 class="text-2xl font-semibold text-indigo-700">Create Youth Profile</h1>
        <form @submit.prevent=submit>
          <!-- Youth Profile Fields -->
          <div class="mt-4">
            <InputLabel for="first_name" value="First Name" />
            <TextInput
              id="first_name"
              type="text"
              class="mt-1 block w-full"
              v-model="form.first_name"
              autofocus
              autocomplete="first_name"
            />
            <InputError class="mt-2" :message="form.errors.first_name" />
          </div>

          <div class="mt-4">
            <InputLabel for="middle_name" value="Middle Name" />
            <TextInput
              id="middle_name"
              type="text"
              class="mt-1 block w-full"
              v-model="form.middle_name"
            />
            <InputError class="mt-2" :message="form.errors.middle_name" />
          </div>

          <div class="mt-4">
            <InputLabel for="last_name" value="Last Name" />
            <TextInput
              id="last_name"
              type="text"
              class="mt-1 block w-full"
              v-model="form.last_name"
            />
            <InputError class="mt-2" :message="form.errors.last_name" />
          </div>

          <div class="mt-4">
            <InputLabel for="suffix" value="Suffix" />
            <TextInput
              id="suffix"
              type="text"
              class="mt-1 block w-full"
              v-model="form.suffix"
            />
            <InputError class="mt-2" :message="form.errors.suffix" />
          </div>

          <div class="mt-4">
            <InputLabel for="region" value="Region" />
            <TextInput
              id="region"
              type="text"
              class="mt-1 block w-full"
              v-model="form.region"
            />
            <InputError class="mt-2" :message="form.errors.region" />
          </div>

          <div class="mt-4">
            <InputLabel for="province" value="Province" />
            <TextInput
              id="province"
              type="text"
              class="mt1 block w-full"
              v-model="form.province"
            />
            <InputError class="mt-2" :message="form.errors.province" />
          </div>

          <div class="mt-4">
            <InputLabel for="municipality" value="Municipality" />
            <TextInput
              id="municipality"
              type="text"
              class="mt-1 block w-full"
              v-model="form.municipality"
            />
            <InputError class="mt-2" :message="form.errors.municipality" />
          </div>

          <div class="mt-4">
            <InputLabel for="baranggay" value="Baranggay" />
            <TextInput
              id="baranggay"
              type="text"
              class="mt-1 block w-full"
              v-model="form.baranggay"
            />
            <InputError class="mt-2" :message="form.errors.baranggay" />
          </div>

          <div class="mt-4">
            <InputLabel for="purok" value="Purok" />
            <TextInput
              id="purok"
              type="text"
              class="mt-1 block w-full"
              v-model="form.purok"
            />
            <InputError class="mt-2" :message="form.errors.purok" />
          </div>

          <div class="mt-4">
            <InputLabel for="sex" value="Sex" />
            <RadioButton
              id="sex"
              :options="['Male', 'Female']"
              v-model="form.sex"
            />
            <InputError class="mt-2" :message="form.errors.sex" />
          </div>

          <div class="mt-4">
            <InputLabel for="age" value="Age" />
            <TextInput
              id="age"
              class="mt-1 block w-full"
              v-model="form.age"
            />
            <InputError class="mt-2" :message="form.errors.age" />
          </div>

          <div class="mt-4">
            <InputLabel for="birthdate" value="Birthdate" />
            <DatePicker
              id="birthdate"
              class="mt-1 block w-full"
              v-model="form.birthdate"
            />
            <InputError class="mt-2" :message="form.errors.birthdate" />
          </div>

          <div class="mt-4">
            <InputLabel for="email" value="Email" />
            <TextInput
              id="email"
              type="email"
              class="mt-1 block w-full"
              v-model="form.email"
            />
            <InputError class="mt-2" :message="form.errors.email" />
          </div>

          <div class="mt-4">
            <InputLabel for="contact_no" value="Contact Number" />
            <TextInput
              id="contact_no"
              type="text"
              class="mt-1 block w-full"
              v-model="form.contact_no"
            />
            <InputError class="mt-2" :message="form.errors.contact_no" />
          </div>

          <!-- Demographic Fields -->
          <div class="mt-4">
            <InputLabel for="civil_status" value="Civil Status" />
            <ChooseInput
              id="civil_status"
              name="civil_status"
              v-model="form.civil_status"
              :options="[
                'Single',
                'Married',
                'Divorced',
                'Widowed',
                'Separated'
              ]"
            />
            <InputError class="mt-2" :message="form.errors.civil_status" />
          </div>

          <div class="mt-4">
            <InputLabel for="youth_age_group" value="Youth Age Group" />
            <TextInput
              id="youth_age_group"
              type="text"
              class="mt-1 block w-full"
              v-model="form.youth_age_group"
              readonly
            />
            <InputError class="mt-2" :message="form.errors.youth_age_group" />
          </div>

          <div class="mt-4">
            <InputLabel for="educational_background" value="Educational Background" />
            <ChooseInput
              id="educational_background"
              name="educational_background"
              v-model="form.educational_background"
              :options="[
                'Elementary Level',
                'Elementary Graduate',
                'High School Level',
                'High School Graduate',
                'College Level',
                'College Graduate',
                'Master\'s Level',
                'Master\'s Graduate',
                'Doctorate Level',
                'Doctorate Graduate'
              ]"
            />
            <InputError class="mt-2" :message="form.errors.educational_background" />
          </div>

          <div class="mt-4">
            <InputLabel for="youth_classification" value="Youth Classification" />
            <ChooseInput
              id="youth_classification"
              name="youth_classification"
              v-model="form.youth_classification"
              :options="[
                'In School Youth',
                'Out of School Youth',
                'Working Youth',
                'Youth w/ Specific Needs'
              ]"
            />
            <InputError class="mt-2" :message="form.errors.youth_classification" />
          </div>

          <div v-if="showSpecificNeedsDetail" class="mt-4">
            <InputLabel for="specific_needs_detail" value="Specific Needs Detail" />
            <ChooseInput
              id="specific_needs_detail"
              name="specific_needs_detail"
              v-model="form.specific_needs_detail"
              :options="[
                'Person w/ Disability',
                'Children in Conflict w/ Law',
                'Indigenous People'
              ]"
            />
            <InputError class="mt-2" :message="form.errors.specific_needs_detail" />
          </div>

          <div class="mt-4">
            <InputLabel for="work_status" value="Work Status" />
            <ChooseInput
              id="work_status"
              name="work_status"
              v-model="form.work_status"
              :options="[
                'Employed',
                'Unemployed',
                'Self-Employed',
                'Currently looking for a job',
                'Not Interested Looking for a job'
              ]"
            />
            <InputError class="mt-2" :message="form.errors.work_status" />
          </div>

          <div class="mt-4">
            <InputLabel for="registered_sk_voter" value="Registered SK Voter" />
            <RadioButton
              id="registered_sk_voter"
              v-model="form.registered_sk_voter"
            />
            <InputError class="mt-2" :message="form.errors.registered_sk_voter" />
          </div>

          <div class="mt-4">
            <InputLabel for="registered_national_voter" value="Registered National Voter" />
            <RadioButton
              id="registered_national_voter"
              :options="['Yes', 'No']"
              v-model="form.registered_national_voter"
            />
            <InputError class="mt-2" :message="form.errors.registered_national_voter" />
          </div>

          <div class="mt-4">
            <InputLabel for="vote_last_sk_election" value="Did you vote in the last SK Election?" />
            <RadioButton
              id="vote_last_sk_election"
              v-model="form.vote_last_sk_election"
            />
            <InputError class="mt-2" :message="form.errors.vote_last_sk_election" />
          </div>

          <div class="mt-4">
            <InputLabel for="sk_assembly" value="Have you already attended a KK Assembly?" />
            <RadioButton
              id="sk_assembly"
              :options="['Yes', 'No']"
              v-model="form.sk_assembly"
            />
            <InputError class="mt-2" :message="form.errors.sk_assembly" />
          </div>

          <div v-if="showSKAssemblyDetails" class="mt-4">
            <InputLabel for="sk_assembly_times_attended" value="Times Attended SK Assembly" />
            <ChooseInput
              id="sk_assembly_times_attended"
              class="mt-1 block w-full"
              v-model="form.sk_assembly_times_attended"
              :options="['1-2 Times', '3-4 Times', '5 and above']"
            />
            <InputError class="mt-2" :message="form.errors.sk_assembly_times_attended" />
          </div>

          <div v-if="showSKAssemblyNotAttended" class="mt-4">
            <InputLabel for="sk_assembly_not_attended" value="Reasons for Not Attending SK Assembly" />
            <ChooseInput
              id="sk_assembly_not_attended"
              class="mt-1 block w-full"
              :options="['There was no KK Assembly Meeting', 'Not Interested to Attend']"
              v-model="form.sk_assembly_not_attended"
            />
            <InputError class="mt-2" :message="form.errors.sk_assembly_not_attended" />
          </div>

          <div class="flex items-center mt-4">
            <PrimaryButton
              class="ml-4 bg-red-700"
              :class="{ 'opacity-25': form.processing }"
              :disabled="form.processing"
            >
              Update
            </PrimaryButton>
          </div>
        </form>
      </div>
    </div>
  </AdminLayout>
</template>
