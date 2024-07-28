<template>
    <Link :href="href" :class="classes">
      <span class="mr-2">
        <slot name="icon" />
      </span>
      <span>
        <slot />
      </span>
    </Link>
  </template>

  <script setup>
  import { computed } from 'vue';
  import { Link } from '@inertiajs/vue3';

  const props = defineProps({
    href: {
      type: String,
      required: true,
    },
    active: {
      type: Boolean,
      default: false,
    },
  });

  const classes = computed(() => ({
    'block px-5 py-3 text-black hover:bg-indigo-500 text-lg rounded-lg flex items-center': true,
    'bg-indigo-200 text-black text-xl rounded-lg': props.active,
  }));
  </script>
