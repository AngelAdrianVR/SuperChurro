
<template>
  <AppLayout title="Dashboard">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
        Inicio
      </h2>
    </template>

    <!-- Avisos ----------------------------------------- -->
    <section v-if="notices.length > 0">
      <div class="lg:col-span-3 mt-9">
        <h1 class="font-bold text-lg text-primary text-center">AVISOS</h1>
      </div>

      <div v-if="notices.length">
        <div v-for="notice in notices" :key="notice.id" class="globe my-2">
          <div class="globe-title">{{ notice.title }}</div>
          <div class="flex justify-between items-center text-xs">
            <p class="text-center">{{ notice.content }}</p>
          </div>
        </div>
      </div>
      <p v-else class="text-center text-gray-500 text-xs">No hay avisos para mostrar.</p>
    </section>

    <div class="md:mx-12 mx-1">
      <p class="text-primary font-bold text-lg">Operaciones</p>

      <div class="globe-container flex-col">
        <EmployeeStations />
        <BirthdatesCard :users="collaborators_birthdays" />
      </div>
      <p class="text-primary font-bold text-lg mt-5">Estadisticas</p>
      <div class="globe-container flex-col">
        <BarChart :options="yearSalesComparisonChartOptions" title="Ventas año en curso vs anterior" />
        <BarChart :options="yearOutcomesComparisonChartOptions" title="Egresos año en curso vs anterior" />
        <Kpi :options="profitKpiOptions" title="Ganancias de este mes vs mes anterior" />
      </div>
    </div>
    <!-- 
      <SecondaryButton @click="getPosition" class="mt-3"
        >Probar geolocalización</SecondaryButton
      > -->
  </AppLayout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import BirthdatesCard from "@/Components/MyComponents/Dashboard/BirthdatesCard.vue";
import BarChart from "@/Components/MyComponents/Charts/BarChart.vue";
import Kpi from "@/Components/MyComponents/Charts/Kpi.vue";
import EmployeeStations from "@/Components/MyComponents/Dashboard/EmployeeStations.vue";
import { Link } from "@inertiajs/inertia-vue3";

export default {
  data() {
    return {
      geolocation_options: {
        enableHighAccuracy: true,
        timeout: 5000,
        maximumAge: 0,
      },
      valid_areas: [
        {
          label: "Audicarr",
          latitudes: [20.71203, 20.71208],
          longitudes: [-103.37882, -103.37863],
        },
        {
          label: "Carrito",
          latitudes: [20.71246, 20.71258],
          longitudes: [-103.37795, -103.37776],
        },
        {
          label: "Casa",
          latitudes: [20.76441, 20.76641],
          longitudes: [-103.42651, -103.40651],
        },
      ],

      // chart options
      yearSalesComparisonChartOptions: {
        colors: ['#BEBFC1', '#F07209'],
        categories: ['Ene', 'Feb', 'Mar'],
        series: [{
          name: 'Año pasado',
          data: [10, 11, 9]
        },
        {
          name: 'Año en curso',
          data: [9, 12, 8.5]
        }],
      },
      yearOutcomesComparisonChartOptions: {
        colors: ['#BEBFC1', '#F07209'],
        categories: ['Ene', 'Feb', 'Mar'],
        series: [{
          name: 'Año pasado',
          data: [10, 11, 9]
        },
        {
          name: 'Año en curso',
          data: [9, 12, 8.5]
        }],
      },
      profitKpiOptions: {
        currentVal: 1155.8,
        refVal: 1000,
        tooltipCurrentVal: 'Ganancias mes actual',
        tooltipRefVal: 'Ganancias mes anterior',
        unit: '$',
      }
    };
  },
  components: {
    AppLayout,
    PrimaryButton,
    SecondaryButton,
    Link,
    BirthdatesCard,
    EmployeeStations,
    BarChart,
    Kpi,
  },
  props: {
    checked_in: Boolean,
    checked_out: Boolean,
    leaves: Array,
    loan: Object,
    notices: Array,
    collaborators_birthdays: Array,
  },
  methods: {
    getPosition() {
      if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
          this.analyzePosition,
          this.error,
          this.geolocation_options
        );
      } else {
        alert(
          "error",
          "Geolocación no soportada por navegador, inténtalo en uno diferente"
        );
      }
    },
    error(e) {
      alert("ERROR(" + e.code + "): " + e.message);
    },
    analyzePosition(current_position) {
      const validated_area = this.valid_areas.find((valid_area) =>
        this.isCurrentPositionInsideArea(valid_area, current_position)
      );

      if (validated_area !== undefined) {
        alert(
          validated_area.label +
          ". Posición: " +
          current_position.coords.latitude +
          ", " +
          current_position.coords.longitude
        );
      } else {
        alert(
          "Ubicación no válida para registrar asistencia." +
          current_position.coords.latitude +
          ", " +
          current_position.coords.longitude
        );
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
      else return 0;
    },
    between(x, range) {
      return x >= range[0] && x <= range[1];
    },
  },
};
</script>