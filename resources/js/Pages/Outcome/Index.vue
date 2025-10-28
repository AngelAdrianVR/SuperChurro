<template>
  <!-- Usamos 'loading' para mostrar el indicador mientras Inertia carga -->
  <LoadingIndicator v-if="loading" />
  <AppLayout title="Historial de Egresos">
    <template #header>
      <div class="flex items-center mt-2">
        <h2 class="font-semibold text-xl text-gray-800 text-center ml-5 lg:ml-28">
          Egresos
        </h2>
      </div>
    </template>

    <div class="flex justify-between mx-5">
      <div class="block">
        <el-date-picker
          @change="filterData"
          v-model="dateRange"
          type="daterange"
          placeholder="Selecciona rango de fechas"
          format="DD/MM/YYYY"
          value-format="YYYY-MM-DD"
        />
      </div>
      <Link :href="route('outcomes.create')">
        <PrimaryButton class="mb-5 !rounded-md"><i class="fa-solid fa-plus mr-2"></i> Nuevo</PrimaryButton>
      </Link>
    </div>

    <!-- El total ahora es siempre el del mes filtrado -->
    <div class="text-center font-bold mb-4">
      <label>Egresos del período: ${{ total_outcomes_money }} </label>
    </div>

    <!-- Pasamos 'outcomes_groups' a la tabla -->
    <div v-if="!loading" class="mx-auto">
      <OutcomesTable class="w-[95%]" :outcomes="outcomes_groups" />
    </div>

    <!-- Componente de paginación. Asume que 'Pagination.vue' acepta el objeto paginador de Laravel -->
    <div class="mt-4 flex justify-center">
        <Pagination :pagination="outcomes" />
    </div>
  </AppLayout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import Pagination from "@/Components/Pagination.vue"; // Tu componente de paginación
import OutcomesTable from "@/Components/MyComponents/Outcome/OutcomesTable.vue";
import LoadingIndicator from "@/Components/MyComponents/LoadingIndicator.vue";
import Back from "@/Components/Back.vue";
import { Link } from "@inertiajs/inertia-vue3";
// Quitamos la importación de 'router' que causaba el error

export default {
  data() {
    return {
      // Inicializa 'dateRange' con los filtros si existen, si no, null
      dateRange: this.filters.date_from && this.filters.date_to
            ? [this.filters.date_from, this.filters.date_to]
            : null,
      loading: false, // Controlamos el estado de carga
    }
  },
  components: {
    AppLayout,
    SecondaryButton,
    PrimaryButton,
    Pagination,
    OutcomesTable,
    LoadingIndicator,
    Back,
    Link
  },
  props: {
    outcomes: Object, // Objeto paginador de Laravel (contiene links, data, total, etc.)
    outcomes_groups: Object, // Los egresos agrupados por día para la página actual
    total_outcomes_money: String, // Total del período
    filters: Object, // Objeto con { date_from, date_to }
  },
  methods: {
    /**
     * Filtra los datos haciendo una visita Inertia GET a la misma ruta (index)
     * con los nuevos parámetros de rango de fechas.
     */
    filterData() {
      let params = {};
      
      // Si tenemos un rango de fechas, lo agregamos a los parámetros
      if (this.dateRange && this.dateRange.length === 2) {
        params = {
            date_from: this.dateRange[0],
            date_to: this.dateRange[1],
        };
      }
      
      // CORRECCIÓN: Usamos 'this.$inertia.get' en lugar de 'router.get'
      this.$inertia.get(route('outcomes.index'), params, {
        preserveState: true, // Mantiene el estado del scroll
        replace: true, // No agrega una nueva entrada al historial del navegador
        onStart: () => { this.loading = true },
        onFinish: () => { this.loading = false }
      });
    }
  }
};
</script>

