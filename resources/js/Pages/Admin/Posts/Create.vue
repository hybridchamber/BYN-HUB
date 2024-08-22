<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import TextInput from "@/Components/TextInput.vue";
import TextArea from "@/Components/TextArea.vue";
import DateTimePicker from "@/Components/DateTimePicker.vue";
import ChooseInput from "@/Components/ChooseInput.vue";
import { ref } from "vue";

const form = useForm({
  title: "",
  cover_photo: null,
  description: "",
  location: "",
  date_time: "",
  category: "",
  invite: false,
});

const coverPhotoPreview = ref(null);

const updateCoverPhoto = (file) => {
  form.cover_photo = file;
  if (file) {
    coverPhotoPreview.value = URL.createObjectURL(file);
  } else {
    coverPhotoPreview.value = null;
  }
};
</script>

<template>
  <Head title="Create new event" />

  <AdminLayout>
    <div class="max-w-7xl mx-auto py-4">
      <div class="flex justify-end">
        <Link
          :href="route('posts.index')"
          ><PrimaryButton
                    class="ml-4"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                     > Back </PrimaryButton>
        </Link>
      </div>
      <div class="max-w-4xl p-6 mx-auto mt-6 rounded-lg shadow-lg bg-slate-100">
        <h1 class="text-2xl font-semibold text-indigo-700">Create an event</h1>

        <form @submit.prevent="form.post(route('posts.store'))">
          <!-- Upload cover section -->
          <div class="mt-4">
            <h2 class="text-lg font-semibold">Upload cover</h2>
            <input type="file" id="cover_photo" name="cover_photo" @input="updateCoverPhoto($event.target.files[0])" />
            <div class="m-2 p-2" v-if="coverPhotoPreview">
                <img :src="coverPhotoPreview" class="w-full h-auto max-w-xs max-h-52 object-cover rounded"/>
            </div>
          </div>

          <!-- General Information section -->
          <div class="mt-4">
            <h2 class="text-lg font-semibold">General Information</h2>

            <InputLabel for="title" value="Title" />
            <TextInput
              id="title"
              type="text"
              class="mt-1 block w-full"
              v-model="form.title"
              autofocus
              autocomplete="title"
            />
            <InputError class="mt-2" :message="form.errors.title" />

            <InputLabel for="description" value="Description" class="mt-4" />
            <TextArea
              id="description"
              class="mt-1 block w-full"
              v-model="form.description"
              rows="3"
            />
            <InputError class="mt-2" :message="form.errors.description" />

            <InputLabel for="category" value="Category" class="mt-4" />
            <ChooseInput
              id="category"
              class="mt-1 block w-full"
              v-model="form.category"
              :options="['Singing', 'Dancing', 'Pageant']"
            />
            <InputError class="mt-2" :message="form.errors.category" />
          </div>

          <!-- Location and Time section -->
          <div class="mt-4">
            <InputLabel for="location" value="Location" />
            <TextInput
              id="location"
              type="text"
              class="mt-1 block w-full"
              v-model="form.location"
              autocomplete="location"
            />
            <InputError class="mt-2" :message="form.errors.location" />

            <InputLabel for="date_time" value="Date and Time" class="mt-4" />
            <DateTimePicker
              id="date_time"
              class="mt-1 block w-full"
              v-model="form.date_time"
            />
            <InputError class="mt-2" :message="form.errors.date_time" />

            <Checkbox
              id="invite"
              class="mt-4"
              v-model="form.invite"
              label="Send invitation to the youth"
            />
          </div>

          <div class="flex items-center mt-6">
            <PrimaryButton
              class="ml-4 bg-red-700"
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
