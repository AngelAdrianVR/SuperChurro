
<template>
  <AppLayout title="Dashboard">
    <template #header>
      <h1 class="font-bold text-center text-lg">Panel de inicio</h1>
    </template>
    <!-- -----------------------Registro de entrada y salida------------ -->
    <div class="py-2">
          <div v-if="checked_out" class="flex items-center">
            <i class="fa-regular fa-clock text-lg text-blue-500 mr-2"></i>
            <span class="text-blue-500">Salida registrada</span>
          </div>
          <div v-else-if="checked_in" class="flex items-center justify-between">
            <div>
              <i class="fa-regular fa-clock text-lg text-green-500 mr-2"></i>
              <span class="text-green-500">Entrada registrada.</span>
            </div>
            <SecondaryButton @click="getPosition">Registrar salida</SecondaryButton>
          </div>
          <div v-else class="flex flex-col md:flex-row items-center justify-between space-x-5 md:mt-5">
            <PrimaryButton class="mt-5 md:mt-0" @click="getPosition">Registrar entrada</PrimaryButton>
          </div>

      <div class="globe-container">

        <!-- -----------------Avisos----------------- -->
        <div class="lg:col-span-3 mt-7 mx-8">
          <h1 class="font-bold text-lg text-primary text-left">Avisos</h1>
        </div>

        <div class="globe">
          <div v-if="notices.length">
            <div v-for="notice in notices" :key="notice.id" class="globe my-2">
              <div class="globe-title">{{ notice.title }}</div>
              <div class="flex justify-between items-center text-xs">
                <p class="text-center">{{ notice.content }}</p>
              </div>
            </div>
          </div>
          <p v-else class="text-center text-gray-500 text-xs">No hay avisos para mostrar.</p>
        </div>

        <!-- -----------------Permisos----------------- -->
        <div class="lg:col-span-3 mt-7 mx-8">
          <h1 class="font-bold text-lg text-primary text-left">Permisos</h1>
        </div>

        <div class="globe">
          <div v-for="leave in leaves" :key="leave.id" class="flex justify-between items-center text-xs">
            <p><i class="fa-regular fa-calendar-days mr-2"></i>{{ leave.date.split('T')[0] }}</p>
            <span>{{ leave.permission_type.name }}</span>
            <span v-if="leave.status === 1" class="ml-2 text-orange-500 font-bold"><i
                class="fa-solid fa-hourglass-start"></i> Revisando.</span>
            <span v-else-if="leave.status === 2" class="ml-2 text-green-500 font-bold"><i class="fa-solid fa-check"></i>
              Aprobado.</span>
            <span v-else class="ml-2 text-red-500 font-bold"><i class="fa-solid fa-xmark"></i> Rechazado.</span>
          </div>
          <p v-if="!leaves.length" class="text-center text-gray-500 text-xs">No hay información para mostrar.</p>
        </div>

        <!-- -----------------Préstamos----------------- -->
        <div class="lg:col-span-3 mt-7 mx-8">
          <h1 class="font-bold text-lg text-primary text-left">Préstamos</h1>
        </div>

        <div class="globe">
          <div v-if="loan" class="flex justify-between items-center text-xs">
            <span><i class="fa-regular fa-calendar-days"></i>{{ loan.created_at.split('T')[0] }}</span>
            <span>${{ loan.amount }} solicitado</span>
            <span v-if="!loan.authorized_at" class="ml-2 text-orange-500 font-bold"><i
                class="fa-solid fa-hourglass-start"></i> Revisando.</span>
            <span v-else-if="loan.remaining" class="ml-2 text-green-500 font-bold"><i class="fa-solid fa-check"></i>
              Aprobado.</span>
            <span v-else class="ml-2 text-red-500 font-bold"><i class="fa-solid fa-xmark"></i> Rechazado.</span>
          </div>
          <p v-else class="text-center text-gray-500 text-xs">No hay información para mostrar.</p>
        </div>
      </div>
    </div>
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
        timeout: 8000,
        maximumAge: 0
      },
      valid_areas: [
        {
          label: "Audycarr",
          latitudes: [20.71190, 20.73212],
          longitudes: [-103.38888, -103.37857]
        },
        {
          label: "Carrito",
          latitudes: [20.70000, 20.75000],
          longitudes: [-103.39000, -103.35000]
        },
        {
          label: "Casa",
          latitudes: [20.76441, 20.76641],
          longitudes: [-103.42651, -103.40651]
        },
        // {
        //   label: "LocalHost test",
        //   latitudes: [20.16441, 20.96641],
        //   longitudes: [-103.92651, -103.10651]
        // }
      ],
    };
  },
  components: {
    AppLayout,
    PrimaryButton,
    SecondaryButton,
    Link,
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
        alert(validated_area.label);
        this.$inertia.post(route('payroll.store-attendance'));
      } else {
        alert('Ubicación no válida para registrar entrada / salida.' +
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
  },
  props: {
    checked_in: Boolean,
    checked_out: Boolean,
    leaves: Array,
    notices: Array,
    loan: Object
  },
};
</script>