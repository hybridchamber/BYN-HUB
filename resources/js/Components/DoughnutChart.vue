<template>
    <div class="chart-container">
      <Doughnut :data="chartData" :options="options" />
    </div>
  </template>
  
  <script setup>
  import { defineProps, computed } from 'vue';
  import { Doughnut } from 'vue-chartjs';
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
    const labels = [...new Set(props.data)];
    const dataGroups = labels.reduce((acc, label) => {
      acc[label] = props.data.filter(item => item === label).length;
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
    height:195px;
    width: 100%;
  }
  </style>
  