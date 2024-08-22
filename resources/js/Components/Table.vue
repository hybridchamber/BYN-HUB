<script setup>
</script>

<template>
  <div class="overflow-x-auto shadow lg mb-5 bg-white rounded">
    <table class="min-w-full divide-y divide-grey-700">
      <thead style="background-color:firebrick;">
       <slot name = "header"></slot>
      </thead>
      <tbody class="bg-white divide-y divide-gray-200">
      <slot></slot>
      </tbody>
    </table>
  </div>
</template>
