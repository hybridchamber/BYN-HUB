<script setup>
import { defineProps, computed, defineEmits, watch } from 'vue';

const props = defineProps({
  id: String,
  modelValue: String,
});

const emitUpdate = defineEmits(['update:modelValue']);

const formattedDateTime = computed(() => {
  if (!props.modelValue) return '';

  // Parse the incoming ISO date string and format it for the input
  const date = new Date(props.modelValue);
  const year = date.getFullYear();
  const month = String(date.getMonth() + 1).padStart(2, '0');
  const day = String(date.getDate()).padStart(2, '0');
  const hours = String(date.getHours()).padStart(2, '0');
  const minutes = String(date.getMinutes()).padStart(2, '0');

  return `${year}-${month}-${day}T${hours}:${minutes}`;
});

// Watch the modelValue and emit the correctly formatted date string on mount
watch(formattedDateTime, (newValue) => {
  if (newValue !== props.modelValue) {
    emitUpdate('update:modelValue', newValue);
  }
}, { immediate: true });

const updateValue = (value) => {
  emitUpdate('update:modelValue', value);
};
</script>

<template>
  <input
    :id="id"
    type="datetime-local"
    class="mt-1 block w-full"
    :value="formattedDateTime"
    @input="updateValue($event.target.value)"
  />
</template>
