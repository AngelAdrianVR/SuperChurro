
<template>
  <AppLayout title="Dashboard">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Inicio</h2>
    </template>
    <!-- -----------------------Registro de entrada y salida------------ -->
    <div class="py-7">
      <div class="globe-container">
        <div class="globe">
          <div v-if="checked_out" class="flex items-center">
            <i class="fa-regular fa-clock text-lg text-blue-600 mr-2"></i>
            <span class="text-blue-600">Salida registrada</span>
          </div>
          <div v-else-if="checked_in" class="flex items-center justify-between">
            <div>
              <i class="fa-regular fa-clock text-lg text-green-600 mr-2"></i>
              <span class="text-green-600">Entrada registrada.</span>
            </div>
            <SecondaryButton @click="getPosition">Salida</SecondaryButton>
          </div>
          <div v-else class="flex items-center justify-between">
            <div>
              <i class="fa-regular fa-clock text-lg mr-2"></i>
              No has registrado entrada hoy
            </div>
            <SecondaryButton @click="getPosition">Entrada</SecondaryButton>
          </div>
        </div>
        <!-- ------------Permutas------------- -->
        <!-- <div class="globe">
          <div class="globe-title">Permutas</div>
          <div>
            <p class="text-center">No hay información para mostrar.</p>
            <p>información de permutas.</p>
          </div>
        </div> -->
        <!-- -----------------Permisos----------------- -->
        <div class="globe">
          <div class="globe-title">Permisos</div>
          <div v-for="leave in leaves" :key="leave.id" class="flex justify-between items-center text-xs">
            <span><i class="fa-regular fa-calendar-days"></i>{{ leave.date.split('T')[0] }}</span>
            <span>{{ leave.permission_type.name }}</span>
            <span v-if="leave.status === 0" class="text-orange-600 font-bold"><i
                class="fa-solid fa-hourglass-start"></i>Revisando.</span>
            <span v-else-if="leave.status === 1" class="text-green-600 font-bold"><i
                class="fa-solid fa-check"></i>Aprobado.</span>
            <span v-else class="text-red-600 font-bold"><i class="fa-solid fa-xmark"></i>Rechazado.</span>
          </div>
          <p v-if="!leaves.length" class="text-center text-gray-500 text-xs">No hay información para mostrar.</p>
        </div>
        <!-- -----------------Préstamos----------------- -->
        <div class="globe">
          <div class="globe-title">Préstamos</div>
          <div v-if="loan" class="flex justify-between items-center text-xs">
            <span><i class="fa-regular fa-calendar-days"></i>{{ loan.created_at.split('T')[0] }}</span>
            <span>${{ loan.amount }} solicitado</span>
            <span v-if="!loan.authorized_at" class="text-orange-600 font-bold"><i
                class="fa-solid fa-hourglass-start"></i>Revisando.</span>
            <span v-else-if="loan.remaining" class="text-green-600 font-bold"><i
                class="fa-solid fa-check"></i>Aprobado.</span>
            <span v-else class="text-red-600 font-bold"><i class="fa-solid fa-xmark"></i>Rechazado.</span>
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
        timeout: 5000,
        maximumAge: 0
      },
      valid_areas: [
        {
          label: "Audycarr",
          latitudes: [20.71190, 20.71212],
          longitudes: [-103.37888, -103.37857]
        },
        {
          label: "Carrito",
          latitudes: [20.71244, 20.71268],
          longitudes: [-103.37807, -103.37766]
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
    loan: Object
  },
};
</script>