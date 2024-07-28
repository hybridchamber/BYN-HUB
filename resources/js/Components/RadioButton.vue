<template>
    <div class="radio-group">
      <label v-for="option in options" :key="option" class="radio-label">
        <input
          type="radio"
          :value="option"
          :checked="modelValue === option"
          @change="updateValue(option)"
          class="radio-input"
        />
        {{ option }}
      </label>
    </div>
  </template>

  <script setup>
  import { defineProps, defineEmits } from 'vue';

  const props = defineProps({
    modelValue: String,
    options: {
      type: Array,
      default: () => ['Yes', 'No'],
    },
  });

  const emit = defineEmits(['update:modelValue']);

  function updateValue(value) {
    emit('update:modelValue', value);
  }
  </script>

  <style scoped>
  .radio-group {
    display: flex;
    gap: 10px;
  }
  .radio-label {
    display: flex;
    align-items: center;
    cursor: pointer;
  }
  .radio-input {
    margin-right: 5px;
  }
  </style>
