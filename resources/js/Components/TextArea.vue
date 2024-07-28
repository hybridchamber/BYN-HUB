<template>
    <div>
      <textarea
        :id="id"
        :name="name"
        :value="modelValue"
        :rows="rows"
        :class="['mt-1 block w-full rounded-md shadow-sm', error ? 'border-red-500' : 'border-gray-300']"
        @input="updateValue"
      ></textarea>
      <p v-if="error" class="mt-2 text-sm text-red-600">{{ error }}</p>
    </div>
  </template>

  <script setup>
  import { defineProps, defineEmits } from 'vue';

  const props = defineProps({
    id: String,
    name: String,
    modelValue: String,
    rows: {
      type: Number,
      default: 3,
    },
    error: String,
  });

  const emit = defineEmits(['update:modelValue']);

  const updateValue = (event) => {
    emit('update:modelValue', event.target.value);
  };
  </script>
