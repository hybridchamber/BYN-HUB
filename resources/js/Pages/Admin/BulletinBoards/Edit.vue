<script setup>
import { Head, Link, useForm, router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';
import TextInput from '@/Components/TextInput.vue';
import DatePicker from '@/Components/DatePicker.vue';

const props = defineProps({
  bulletinboard: {
    type: Object,
    required: true,
  },
});

const form = useForm({
  caption: props.bulletinboard.caption,
  date_time: props.bulletinboard.date_time,
  bb_file: null,
});

function submitForm() {
  const formData = new FormData();
  formData.append('_method', 'put');
  formData.append('caption', form.caption);
  formData.append('date_time', form.date_time);
  if (form.bb_file) {
    formData.append('bb_file', form.bb_file);
  }

  router.post(`/bulletinboards/${props.bulletinboard.id}`, formData, {
    headers: { 'Content-Type': 'multipart/form-data' },
  });
}
</script>

<template>
  <Head title="Update Bulletinboard" />

  <AdminLayout>
    <div class="max-w-7xl mx-auto py-4">
      <div class="flex justify-between">
        <Link
          :href="route('bulletinboards.index')"
          class="px-3 py-2 text-white font-semibold bg-red-700 hover:bg-red-900 rounded"
        >
          Back
        </Link>
      </div>
      <div class="mt-6 max-w-6xl mx-auto bg-slate-100 shadow-lg rounded-lg p-6">
        <h1 class="text-2xl font-semibold text-indigo-700">Update Bulletinboard</h1>
        <form @submit.prevent="submitForm">
          <div class="mt-4">
            <InputLabel for="caption" value="Caption" />
            <TextInput
              id="caption"
              type="text"
              class="mt-1 block w-full"
              v-model="form.caption"
              autofocus
              autocomplete="caption"
            />
            <InputError class="mt-2" :message="form.errors.caption" />
          </div>

          <div class="mt-4">
            <InputLabel for="bb_file" value="Files" />
            <input
              type="file"
              id="bb_file"
              name="bb_file"
              @change="event => form.bb_file = event.target.files[0]"
            />
            <span class="text-sm text-gray-600">Uploaded File: {{ bulletinboard.bb_file_url }}</span>
            <InputError class="mt-2" :message="form.errors.bb_file" />
          </div>

          <div class="mt-4">
            <InputLabel for="date_time" value="Date and Time" />
            <DatePicker
              id="date_time"
              class="mt-1 block w-full"
              v-model="form.date_time"
            />
            <InputError class="mt-2" :message="form.errors.date_time" />
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
