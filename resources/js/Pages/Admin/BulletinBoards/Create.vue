<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import TextInput from "@/Components/TextInput.vue";
import DatePicker from "@/Components/DatePicker.vue";
import { ref } from "vue";

const form = useForm({
  caption: "",
  bb_file: null,
  date_time: "",
});

const bbFilePreview = ref(null);

const updateBbFile = (file) => {
  form.bb_file = file;
  if (file) {
    bbFilePreview.value = URL.createObjectURL(file);
  } else {
    bbFilePreview.value = null;
  }
};
</script>

<template>
  <Head title="Create new event" />

  <AdminLayout>
    <div class="max-w-7xl mx-auto py-4">
      <div class="flex justify-end">
        <Link
          :href="route('bulletinboards.index')"
          class="px-3 py-2 mr-3 font-semibold text-white bg-red-700 rounded hover:bg-red-900"
          >Back</Link>
      </div>
      <div class="max-w-4xl p-6 mx-auto mt-6 rounded-lg shadow-lg bg-slate-100">
        <h1 class="text-2xl font-semibold text-indigo-700">Bulletin Upload</h1>

        <form @submit.prevent="form.post(route('bulletinboards.store'))" enctype="multipart/form-data">
          <div class="mt-4">
            <h2 class="text-lg font-semibold">Upload</h2>
            <input type="file" id="bb_file" name="bb_file" @input="updateBbFile($event.target.files[0])" />
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

            <InputLabel for="date_time" value="Date" class="mt-4" />
            <DatePicker
              id="date_time"
              class="mt-1 block w-full"
              v-model="form.date_time"
            />
            <InputError class="mt-2" :message="form.errors.date_time" />

          </div>

          <div class="flex items-center mt-6">
            <PrimaryButton
              class="ml-4 bg-red-700"
              :class="{ 'opacity-25': form.processing }"
              :disabled="form.processing"
            >
              Upload
            </PrimaryButton>
          </div>
        </form>
      </div>
    </div>
  </AdminLayout>
</template>
