<script setup>
import { ref, watch, onMounted } from 'vue';

const props = defineProps({
  coordinates: {
    type: Array,
    default: () => []
  }
});

const map = ref(null);

const initializeMap = () => {
  if (window.google) {
    const mapOptions = {
      center: { lat: props.coordinates[0]?.latitude || 0, lng: props.coordinates[0]?.longitude || 0 },
      zoom: 10,
    };

    map.value = new google.maps.Map(document.querySelector('.map-container'), mapOptions);

    // Add markers using google.maps.Marker
    props.coordinates.forEach(coord => {
      // Check if coordinates are valid numbers
      const lat = parseFloat(coord.latitude);
      const lng = parseFloat(coord.longitude);
      if (!isNaN(lat) && !isNaN(lng)) {
        new google.maps.Marker({
          position: { lat, lng },
          map: map.value,
          title: coord.name || 'No name'
        });
      } else {
        console.error('Invalid coordinates:', coord);
      }
    });
  } else {
    console.error('Google Maps API not loaded.');
  }
};

onMounted(() => {
  initializeMap();
});

watch(() => props.coordinates, () => {
  initializeMap();
});
</script>

<template>
  <div ref="map" class="map-container"></div>
</template>

<style scoped>
.map-container {
  height: 400px;
  width: 100%;
}
</style>
