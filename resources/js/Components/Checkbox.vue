<template>
    <div>
      <input
        type="checkbox"
        :id="id"
        :name="name"
        :checked="modelValue"
        @change="updateValue"
        class="form-checkbox h-5 w-5 text-indigo-600 transition duration-150 ease-in-out"
      />
      <label :for="id" class="ml-2 block text-sm leading-5 text-gray-900">{{ label }}</label>
      <p v-if="error" class="mt-2 text-sm text-red-600">{{ error }}</p>
    </div>
  </template>

  <script setup>
  import { defineProps, defineEmits } from 'vue';

  const props = defineProps({
    id: String,
    name: String,
    modelValue: Boolean,
    label: String,
    error: String,
  });

  const emit = defineEmits(['update:modelValue']);

  const updateValue = (event) => {
    emit('update:modelValue', event.target.checked);
  };
  </script>
