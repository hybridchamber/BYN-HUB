<template>
    <div class="chart-container">
      <Pie :data="chartData" :options="options" />
    </div>
  </template>

  <script setup>
  import { defineProps, computed } from 'vue';
  import { Pie } from 'vue-chartjs';
  import { Chart as ChartJS, Title, Tooltip, Legend, ArcElement, CategoryScale, LinearScale } from 'chart.js';

  ChartJS.register(Title, Tooltip, Legend, ArcElement, CategoryScale, LinearScale);

  const props = defineProps({
    data: {
      type: Array,
      required: true,
    },
    label: {
      type: String,
      required: true,
    },
    colors: {
      type: Array,
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
          data: Object.values(dataGroups),
          backgroundColor: props.colors,
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
    width: 80%;
  }
  </style>
