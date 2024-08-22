<script setup>
import { Head, useForm, Link } from '@inertiajs/vue3';
import { ref, watch } from 'vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import ChooseInput from '@/Components/ChooseInput.vue';
import DatePicker from '@/Components/DatePicker.vue';
import RadioButton from '@/Components/RadioButton.vue';
import axios from 'axios';

const form = useForm({
  // Youth Profile fields
  first_name: '',
  middle_name: '',
  last_name: '',
  suffix: '',
  region: '',
  province: '',
  municipality: '',
  baranggay: '',
  purok: '',
  sex: '',
  age: '',
  birthdate: '',
  email: '',
  contact_no: '',

  // Demographic fields
  civil_status: '',
  youth_age_group: '',
  educational_background: '',
  youth_classification: '',
  specific_needs_detail: '',
  work_status: '',
  registered_sk_voter: '',
  registered_national_voter: '',
  sk_assembly: '',
  sk_assembly_times_attended: '',
  sk_assembly_not_attended: '',
  vote_last_sk_election: '',
});

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


const showSpecificNeedsDetail = ref(false);
watch(() => form.youth_classification, (newValue) => {
  if (newValue === 'Youth w/ Specific Needs') {
    showSpecificNeedsDetail.value = true;
  } else {
    showSpecificNeedsDetail.value = false;
    form.specific_needs_detail = 'Youth without Specific Needs';
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
      regionMap.value[region.code] = region.name;
    });
  } catch (error) {
    console.error('Error fetching regions:', error);
    setTimeout(fetchRegions, 1000);
  } finally {
    loadingRegions.value = false;
  }
};

const fetchProvinces = async () => {
  loadingProvinces.value = true;
  try {
    const response = await axios.get(`/api/regions/${form.region}/provinces`);
    provinces.value = response.data;
    response.data.forEach(province => {
      provinceMap.value[province.code] = province.name;
    });
    municipalities.value = [];
    barangays.value = [];
  } catch (error) {
    console.error('Error fetching provinces:', error);
    setTimeout(fetchProvinces, 1000);
  } finally {
    loadingProvinces.value = false;
  }
};

const fetchMunicipalities = async () => {
  loadingMunicipalities.value = true;
  try {
    const response = await axios.get(`/api/provinces/${form.province}/municipalities`);
    municipalities.value = response.data;
    response.data.forEach(municipality => {
      municipalityMap.value[municipality.code] = municipality.name;
    });
    barangays.value = [];
  } catch (error) {
    console.error('Error fetching municipalities:', error);
    setTimeout(fetchMunicipalities, 1000);
  } finally {
    loadingMunicipalities.value = false;
  }
};

const fetchBarangays = async () => {
  loadingBarangays.value = true;
  try {
    const response = await axios.get(`/api/municipalities/${form.municipality}/barangays`);
    barangays.value = response.data;
    response.data.forEach(barangay => {
      barangayMap.value[barangay.code] = barangay.name;
    });
  } catch (error) {
    console.error('Error fetching barangays:', error);
    setTimeout(fetchBarangays, 1000);
  } finally {
    loadingBarangays.value = false;
  }
};

const updateFormWithNames = () => {
  form.region = regionMap.value[form.region];
  form.province = provinceMap.value[form.province];
  form.municipality = municipalityMap.value[form.municipality];
  form.baranggay = barangayMap.value[form.baranggay];
};

fetchRegions();

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

const handleSubmit = async () => {
  updateFormWithNames();
  validateAge();
  if (!form.errors.age && !form.errors.birthdate) {
    await form.post(route('youthprofiles.store'));
  }
};

</script>

<template>
  <Head title="Create Youth Profile" />

  <AdminLayout>
    <div class="max-w-7xl mx-auto py-4">
      <div class="flex justify-end">
        <Link :href="route('youthprofiles.index')">
          <PrimaryButton
              class="ml-4"
              :class="{ 'opacity-25': form.processing }"
              :disabled="form.processing"
            >
          Back
        </PrimaryButton>
        </Link>
      </div>
      <div class="mt-6 max-w-6xl mx-auto bg-slate-100 shadow-lg rounded-lg p-6">
        <h1 class="text-2xl font-semibold text-blue-900">Create Youth Profile</h1>
        <form @submit.prevent="handleSubmit()">
          <!-- Grid Layout -->
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">

            <!-- Youth Profile Fields -->
            <div>
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

            <div>
              <InputLabel for="middle_name" value="Middle Name" />
              <TextInput
                id="middle_name"
                type="text"
                class="mt-1 block w-full"
                v-model="form.middle_name"
              />
              <InputError class="mt-2" :message="form.errors.middle_name" />
            </div>

            <div>
              <InputLabel for="last_name" value="Last Name" />
              <TextInput
                id="last_name"
                type="text"
                class="mt-1 block w-full"
                v-model="form.last_name"
              />
              <InputError class="mt-2" :message="form.errors.last_name" />
            </div>

            <div>
              <InputLabel for="suffix" value="Suffix" />
              <TextInput
                id="suffix"
                type="text"
                class="mt-1 block w-full"
                v-model="form.suffix"
              />
              <InputError class="mt-2" :message="form.errors.suffix" />
            </div>

            <div>
              <InputLabel for="region" value="Region" />
              <select
                id="region"
                class="mt-1 block w-full"
                v-model="form.region"
               @change="loadingProvinces = true; fetchProvinces()"
               :disabled="loadingRegions"
              >
                <option value="" disabled>Select Region</option>
                <option v-for="region in regions" :key="region.code" :value="region.code">
                  {{ region.name }}
                </option>
              </select>
              <InputError class="mt-2" :message="form.errors.region" />
            </div>

            <div>
              <InputLabel for="province" value="Province" />
              <select
                id="province"
                class="mt-1 block w-full"
                v-model="form.province"
                @change="loadingMunicipalities = true; fetchMunicipalities()"
               :disabled="loadingProvinces"
              >
                <option value="" disabled>Select Province</option>
                <option v-for="province in provinces" :key="province.code" :value="province.code">
                  {{ province.name }}
                </option>
              </select>
              <InputError class="mt-2" :message="form.errors.province" />
            </div>

            <div>
              <InputLabel for="municipality" value="Municipality" />
              <select
                id="municipality"
                class="mt-1 block w-full"
                v-model="form.municipality"
                @change="loadingBarangays = true; fetchBarangays()"
                :disabled="loadingMunicipalities"
              >
                <option value="" disabled>Select Municipality</option>
                <option v-for="municipality in municipalities" :key="municipality.code" :value="municipality.code">
                  {{ municipality.name }}
                </option>
              </select>
              <InputError class="mt-2" :message="form.errors.municipality" />
            </div>

            <div>
              <InputLabel for="baranggay" value="Barangay" />
              <select
                  id="baranggay"
                  class="mt-1 block w-full"
                  v-model="form.baranggay"
                  :disabled="loadingBarangays"
              >
                <option value="" disabled>Select Barangay</option>
                <option v-for="barangay in barangays" :key="barangay.code" :value="barangay.code">
                  {{ barangay.name }}
                </option>
              </select>
              <InputError class="mt-2" :message="form.errors.baranggay" />
            </div>

            <div>
              <InputLabel for="purok" value="Purok" />
              <TextInput
                id="purok"
                type="text"
                class="mt-1 block w-full"
                v-model="form.purok"
              />
              <InputError class="mt-2" :message="form.errors.purok" />
            </div>

            <div>
              <InputLabel for="sex" value="Sex" />
              <RadioButton
                id="sex"
                :options="['Male', 'Female']"
                v-model="form.sex"
              />
              <InputError class="mt-2" :message="form.errors.sex" />
            </div>

            <div>
              <InputLabel for="age" value="Age" />
              <TextInput
                id="age"
                class="mt-1 block w-full"
                v-model="form.age"
              />
              <InputError class="mt-2" :message="form.errors.age" />
            </div>

            <div>
              <InputLabel for="birthdate" value="Birthdate" />
              <DatePicker
                id="birthdate"
                class="mt-1 block w-full"
                v-model="form.birthdate"
              />
              <InputError class="mt-2" :message="form.errors.birthdate" />
            </div>

            <div>
              <InputLabel for="email" value="Email" />
              <TextInput
                id="email"
                type="email"
                class="mt-1 block w-full"
                v-model="form.email"
              />
              <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div>
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
            <div>
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

            <div>
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

            <div>
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

            <div>
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
          

          

          <!-- Submit Button -->
          <div class="flex items-center mt-4">
            <PrimaryButton
              class="ml-4"
              :class="{ 'opacity-25': form.processing }"
              :disabled="form.processing"
            >
              Create
            </PrimaryButton>
          </div>
        </form>
      </div>
    </div>
  </AdminLayout>
</template>