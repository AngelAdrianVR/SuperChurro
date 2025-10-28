<template>
  <AppLayout title="Historial de movimientos">
    <template #header>
      <!-- MODIFICADO: Se añade 'gap-4' para un espaciado limpio y mejor alineación -->
      <div class="flex items-center mt-2 gap-4">
        <Back />
        <!-- MODIFICADO: Se elimina 'ml-5 lg:ml-28' -->
        <h2 class="font-semibold text-xl text-gray-800">
          Historial de "{{ product.name }}"
        </h2>
      </div>
    </template>

    <!-- 
      MODIFICADO: 
      - Se rediseña la navegación de pestañas.
      - Se elimina 'border-y border-[#9a9a9a]' y se reemplaza por un contenedor flex con fondo ligero.
      - Se añaden estilos de "píldora" (pill) para la pestaña activa.
    -->
    <div class="mt-4 px-4 sm:px-6 lg:px-8">
      <div class="max-w-4xl mx-auto">
        <div class="flex space-x-1 bg-gray-100 p-1 rounded-lg">
          <button @click="tab = 1" :class="tab == 1 ? 'bg-white text-indigo-700 shadow' : 'text-gray-600 hover:bg-gray-200'"
            class="w-full px-4 py-2 rounded-md text-sm font-medium transition-colors duration-200 ease-in-out">
            Historial
          </button>
          <!-- <button
            @click="tab = 2"
            :class="tab == 2 ? 'bg-white text-indigo-700 shadow' : 'text-gray-600 hover:bg-gray-200'"
            class="w-full px-4 py-2 rounded-md text-sm font-medium transition-colors duration-200 ease-in-out"
          >
            Stock
          </button> -->
        </div>
      </div>
    </div>

    <!-- 
      MODIFICADO: 
      - Se envuelve el contenido de las pestañas en un contenedor con espaciado.
    -->
    <div class="mt-6 px-4 sm:px-6 lg:px-8">
      <div class="max-w-4xl mx-auto">
        <!-- Contenido de la Pestaña 1: Historial -->
        <div v-if="tab == 1" class="overflow-x-auto bg-white shadow-xl rounded-2xl">
          <!-- 
            NOTA: Asumo que WarehouseRecordTable es un <table>. 
            El 'overflow-x-auto' y el 'bg-white shadow-xl rounded-2xl' deben ir en el contenedor padre 
            para que la tabla sea responsive y tenga el estilo de tarjeta.
          -->
          <WarehouseRecordTable :movements="movements.data" :product="product" />
          <MovementPagination :pagination="movements" />
        </div>

        <!-- Contenido de la Pestaña 2: Stock -->
        <div v-if="tab == 2" class="overflow-x-auto bg-white shadow-xl rounded-2xl">
          <ProductStockTable />
        </div>
      </div>
    </div>

  </AppLayout>
</template>

<script>
// El script permanece sin cambios
import AppLayout from "@/Layouts/AppLayout.vue";
import MovementPagination from "@/Components/MovementPagination.vue";
import WarehouseRecordTable from "@/Components/MyComponents/WarehouseRecord/WarehouseRecordTable.vue";
import ProductStockTable from "@/Components/MyComponents/WarehouseRecord/ProductStockTable.vue";
import Back from "@/Components/Back.vue";
import { Link } from "@inertiajs/inertia-vue3";

export default {
  data() {
    return {
      movements_reversed: null,
      tab: 1,
    };
  },
  components: {
    AppLayout,
    MovementPagination,
    WarehouseRecordTable,
    ProductStockTable,
    Back,
    Link,
  },
  props: {
    product: Object,
    movements: Object,
  },
  methods: {
    dateTimeFormatter(timestamp) {
      const date_n_time = timestamp.split("T");
      return date_n_time[0] + " a las " + date_n_time[1].split(".")[0];
    },
  },
};
</script>
