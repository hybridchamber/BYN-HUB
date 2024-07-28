<template>
    <div class="chart-container">
      <Bar :data="chartData" :options="options" />
    </div>
  </template>

  <script setup>
  import { defineProps, computed } from 'vue';
  import { Bar } from 'vue-chartjs';
  import { Chart as ChartJS, Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale } from 'chart.js';

  ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale);

  const props = defineProps({
    data: {
      type: Array,
      required: true,
    },
    label: {
      type: String,
      required: true,
    }
  });

  const chartData = computed(() => {
    const labels = [...new Set(props.data.map(item => item[props.label]))];
    const dataGroups = labels.reduce((acc, label) => {
      acc[label] = props.data.filter(item => item[props.label] === label).length;
      return acc;
    }, {});

    return {
      labels: Object.keys(dataGroups),
      datasets: [
        {
          label: props.label,
          backgroundColor: 'orange',
          data: Object.values(dataGroups),
        },
      ],
    };
  });

  const options = {
    responsive: true,
    maintainAspectRatio: false,
  };
  </script>

  <style scoped>
  .chart-container {
    position: relative;
    height: 190px;
    width: 70%;
  }
  </style>
