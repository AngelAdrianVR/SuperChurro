<template>
  <AppLayout title="Dashboard">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Inicio
      </h2>
    </template>

    <!-- 
      MODERNIZACIÓN:
      - Contenedor principal con padding estándar (py-8) y 'max-w-7xl'.
      - Eliminado 'md:mx-12 mx-1' en favor de un contenedor centrado.
      - Reemplazado 'globe-container' por un layout de CSS Grid ('grid').
      - Títulos de sección ('h2') más limpios y modernos.
    -->
    <div class="py-8">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 px-4">

        <!-- Sección de Avisos -->
        <section v-if="notices.length > 0" class="mb-8">
          <h2 class="text-2xl font-semibold text-gray-900 mb-4">Avisos</h2>
          <div class="space-y-3">
            <!-- Tarjeta de Aviso Moderna -->
            <div v-for="notice in notices" :key="notice.id"
              class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4 rounded-lg shadow-sm"
              role="alert">
              <p class="font-bold text-blue-800">{{ notice.title }}</p>
              <p class="text-blue-700">{{ notice.content }}</p>
            </div>
          </div>
        </section>

        <!-- Sección de Operaciones -->
        <section class="mb-8">
          <h2 class="text-2xl font-semibold text-gray-900 mb-4">Operaciones</h2>
          <!-- Layout de Grid para Operaciones -->
          <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- EmployeeStations ocupará 2 columnas en pantallas grandes -->
            <div class="lg:col-span-2">
              <EmployeeStations />
            </div>
            <!-- BirthdatesCard ocupará 1 columna -->
            <div class="lg:col-span-1">
              <BirthdatesCard :users="collaborators_birthdays" />
            </div>
          </div>
        </section>

        <!-- Sección de Estadísticas -->
        <section>
          <h2 class="text-2xl font-semibold text-gray-900 mb-4">Estadísticas</h2>
          <!-- Layout de Grid para Estadísticas -->
          <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Gráfica de Ventas (Ancha) -->
            <div class="lg:col-span-3">
              <BarChart :options="yearSalesComparisonChartOptions" title="Ventas año en curso vs anterior" />
            </div>
            <!-- Gráfica de Egresos -->
            <div class="lg:col-span-3">
              <BarChart :options="yearOutcomesComparisonChartOptions" title="Egresos año en curso vs anterior" />
            </div>
            <!-- KPI de Ganancias -->
            <div class="lg:col-span-1">
              <Kpi :options="profitKpiOptions" title="Ganancias de este mes vs mes anterior" />
            </div>
          </div>
        </section>
      </div>
    </div>
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

import { format, subMonths as subMonthsFn, getMonth, getYear } from 'date-fns';
import { es } from 'date-fns/locale';

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
      sales: [],
      outcomes: [],

      // chart options
      yearSalesComparisonChartOptions: {
        colors: ['#a8b3cf', '#3b82f6'], // Colores modernos (gris-azulado, azul-500)
        categories: this.salesLastYear.map(item => item.month),
        series: [{
          name: 'Año pasado',
          data: this.salesLastYear.map(item => (item.amount).toFixed(2))
        },
        {
          name: 'Año en curso',
          data: this.salesCurrentYear.map(item => (item.amount).toFixed(2))
        }],
      },
      yearOutcomesComparisonChartOptions: {
        colors: ['#a8b3cf', '#ef4444'], // Colores modernos (gris-azulado, red-500)
        categories: this.outcomesLastYear.map(item => item.month),
        series: [{
          name: 'Año pasado',
          data: this.outcomesLastYear.map(item => (item.amount).toFixed(2))
        },
        {
          name: 'Año en curso',
          data: this.outcomesCurrentYear.map(item => (item.amount).toFixed(2))
        }],
      },
      profitKpiOptions: {
        currentVal: this.getMonthProfit(0), // Mes actual
        refVal: this.getMonthProfit(1), // Mes anterior
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
    salesCurrentYear: Array,
    outcomesCurrentYear: Array,
    salesLastYear: Array,
    outcomesLastYear: Array,
  },
  methods: {
    // Lógica de `getMonthProfit` mejorada para más claridad
    getMonthProfit(subMonths = 0) {
      try {
        const currentDate = new Date();
        const targetDate = subMonthsFn(currentDate, subMonths);
        const targetMonthIndex = getMonth(targetDate); // 0-11
        const targetYear = getYear(targetDate);
        const currentYear = getYear(currentDate);

        let sales = 0;
        let outcomes = 0;

        if (targetYear === currentYear) {
          sales = this.salesCurrentYear[targetMonthIndex]?.amount || 0;
          outcomes = this.outcomesCurrentYear[targetMonthIndex]?.amount || 0;
        } else {
          // Asumimos que si no es el año actual, es el anterior
          sales = this.salesLastYear[targetMonthIndex]?.amount || 0;
          outcomes = this.outcomesLastYear[targetMonthIndex]?.amount || 0;
        }

        // El valor ya parece estar en miles, no multiplicamos
        return (sales - outcomes);
      } catch (e) {
        console.error("Error calculating profit:", e);
        return 0; // Retornar 0 si hay un error
      }
    },
    
    // --- Métodos de geolocalización sin cambios ---
    getPosition() {
      if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
          this.analyzePosition,
          this.error,
          this.geolocation_options
        );
      } else {
        // Reemplazar 'alert' por un método de notificación moderno si existe
        console.error("Geolocación no soportada por navegador.");
        // alert(
        //   "error",
        //   "Geolocación no soportada por navegador, inténtalo en uno diferente"
        // );
      }
    },
    error(e) {
      console.error("Error de geolocalización (" + e.code + "): " + e.message);
      // alert("ERROR(" + e.code + "): " + e.message);
    },
    analyzePosition(current_position) {
      const validated_area = this.valid_areas.find((valid_area) =>
        this.isCurrentPositionInsideArea(valid_area, current_position)
      );

      const posString = `${current_position.coords.latitude}, ${current_position.coords.longitude}`;

      if (validated_area !== undefined) {
        console.log(`Área válida: ${validated_area.label}. Posición: ${posString}`);
        // alert(
        //   validated_area.label +
        //   ". Posición: " +
        //   posString
        // );
      } else {
        console.warn(`Ubicación no válida para registrar asistencia: ${posString}`);
        // alert(
        //   "Ubicación no válida para registrar asistencia." +
        //   posString
        // );
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
