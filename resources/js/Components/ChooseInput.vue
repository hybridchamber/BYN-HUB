<template>
    <div>
      <select
        :id="id"
        :name="name"
        :value="modelValue"
        :class="['mt-1 block w-full rounded-md shadow-sm', error ? 'border-red-500' : 'border-gray-300']"
        @change="updateValue"
      >
        <option v-for="option in options" :key="option" :value="option">
          {{ option }}
        </option>
      </select>
      <p v-if="error" class="mt-2 text-sm text-red-600">{{ error }}</p>
    </div>
  </template>

  <script setup>
  import { defineProps, defineEmits } from 'vue';

  const props = defineProps({
    id: String,
    name: String,
    modelValue: String,
    options: {
      type: Array,
      default: () => [],
    },
    error: String,
  });

  const emits = defineEmits(['update:modelValue']);

  const updateValue = (event) => {
    emits('update:modelValue', event.target.value);
  };
  </script>
