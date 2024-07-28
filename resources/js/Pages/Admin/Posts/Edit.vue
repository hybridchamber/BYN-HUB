<script setup>
import { Head, Link, useForm, router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';
import TextInput from '@/Components/TextInput.vue';
import TextArea from '@/Components/TextArea.vue';
import DateTimePicker from '@/Components/DateTimePicker.vue';
import Checkbox from '@/Components/Checkbox.vue';
import ChooseInput from '@/Components/ChooseInput.vue';

const props = defineProps({
  post: {
    type: Object,
    required: true,
    cover_photo: String,
  },
});

const form = useForm({
  title: props.post.title,
  cover_photo: null,
  description: props.post.description,
  location: props.post.location,
  date_time: props.post.date_time,
  category: props.post.category,
  invite: !!props.post.invite,
});

function submitForm() {
  router.post(`/posts/${props.post.id}`, {
  _method: 'put',
  title: form.title,
  description: form.description,
  location: form.location,
  date_time: form.date_time,
  category: form.category,
  invite: form.invite,
  cover_photo: form.cover_photo,
  })
};
</script>

<template>
    <Head title="Update post" />

    <AdminLayout>
      <div class="max-w-7xl mx-auto py-4">
        <div class="flex justify-between">
          <Link
            :href="route('posts.index')"
            class="px-3 py-2 text-white font-semibold bg-red-700 hover:bg-red-900 rounded"
          >
            Back
          </Link>
        </div>
        <div class="mt-6 max-w-6xl mx-auto bg-slate-100 shadow-lg rounded-lg p-6">
          <h1 class="text-2xl font-semibold text-indigo-700">Update post</h1>
          <form @submit.prevent="submitForm">
            <div class="mt-4">
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
            </div>

            <div class="mt-4">
              <InputLabel for="cover_photo" value="Cover Photo" />
              <input
               type="file"
               id="cover_photo"
                ame="cover_photo" @input="form.cover_photo = $event.target.files[0]" />

              <InputError class="mt-2" :message="form.errors.cover_photo" />
              <img :src="post.cover_photo_url" alt="Cover Photo" class="w-full h-48 object-cover"/>
            </div>
            <div class="mt-4">
              <InputLabel for="description" value="Description" />
              <TextArea
                id="description"
                class="mt-1 block w-full"
                v-model="form.description"
              />
              <InputError class="mt-2" :message="form.errors.description" />
            </div>

            <div class="mt-4">
              <InputLabel for="category" value="Category" />
              <ChooseInput
                id="category"
                class="mt-1 block w-full"
                v-model="form.category"
                :options="['Singing', 'Dancing', 'Pageant']"
                />
              <InputError class="mt-2" :message="form.errors.category" />
            </div>

            <div class="mt-4">
              <InputLabel for="location" value="Location" />
              <TextInput
                id="location"
                type="text"
                class="mt-1 block w-full"
                v-model="form.location"
              />
              <InputError class="mt-2" :message="form.errors.location" />
            </div>

            <div class="mt-4">
              <InputLabel for="date_time" value="Date and Time" />
              <DateTimePicker
                id="date_time"
                class="mt-1 block w-full"
                v-model="form.date_time"
              />
              <InputError class="mt-2" :message="form.errors.date_time" />
            </div>

            <div class="mt-4">
              <InputLabel for="invite" value="Send Invitation" />
              <Checkbox
                id="invite"
                name="invite"
                v-model="form.invite"
              />
              <InputError class="mt-2" :message="form.errors.invite" />
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


