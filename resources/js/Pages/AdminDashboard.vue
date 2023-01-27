
<template>
  <AppLayout title="Dashboard">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Inicio</h2>
    </template>
    <SecondaryButton @click="getPosition" class="mt-3">Probar geolocalización</SecondaryButton>
    <h1 class="text-gray-600 text-center py-6 text-6xl"> En desarrollo </h1>
  </AppLayout>
</template>

<script>

import AppLayout from "@/Layouts/AppLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import { Link } from "@inertiajs/inertia-vue3";

export default {
  data() {
    return {
      geolocation_options: {
        enableHighAccuracy: true,
        timeout: 5000,
        maximumAge: 0
      },
      valid_areas: [
        {
          label: "Audicarr",
          latitudes: [20.71203, 20.71208],
          longitudes: [-103.37882, -103.37863]
        },
        {
          label: "Carrito",
          latitudes: [20.71246, 20.71258],
          longitudes: [-103.37795, -103.37776]
        },
        {
          label: "Casa",
          latitudes: [20.76441, 20.76641],
          longitudes: [-103.42651, -103.40651]
        }
      ],
    };
  },
  components: {
    AppLayout,
    PrimaryButton,
    SecondaryButton,
    Link,
  },
  props: {
    checked_in: Boolean,
    checked_out: Boolean,
    leaves: Array,
    loan: Object
  },
  methods: {
    getPosition() {
      if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(this.analyzePosition, this.error, this.geolocation_options);
      } else {
        alert('error', 'Geolocación no soportada por navegador, inténtalo en uno diferente');
      }
    },
    error(e) {
      alert('ERROR(' + e.code + '): ' + e.message);
    },
    analyzePosition(current_position) {
      const validated_area = this.valid_areas.find(
        valid_area => this.isCurrentPositionInsideArea(valid_area, current_position
        ));

      if (validated_area !== undefined) {
        alert(validated_area.label + '. Posición: ' +
          current_position.coords.latitude + ', ' + current_position.coords.longitude);
      } else {
        alert('Ubicación no válida para registrar asistencia.' +
          current_position.coords.latitude + ', ' + current_position.coords.longitude);
      }
    },
    isCurrentPositionInsideArea(valid_area, current_position) {
      var current_latitude = current_position.coords.latitude;
      var current_longitude = current_position.coords.longitude;

      if (
        this.between(current_latitude, valid_area.latitudes) &&
        this.between(current_longitude, valid_area.longitudes)
      )
        return valid_area;
      else
        return 0;
    },
    between(x, range) {
      return x >= range[0] && x <= range[1];
    },
  }
};
</script>