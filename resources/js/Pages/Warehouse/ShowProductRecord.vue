<template>
  <AppLayout title="Historial de movimientos">
    <template #header>
      <div class="flex items-center mt-2">
        <Back />
        <h2 class="font-semibold text-xl text-gray-800 text-center ml-5 lg:ml-28">
           Historial de "{{ product.name }}"
        </h2>
      </div>
    </template>

    <div
      class="border-y border-[#9a9a9a] flex mt-4 transition ease-linearn duration-300"
    >
      <p
        @click="tab = 1"
        :class="tab == 1 ? 'text-primary' : ''"
        class="px-7 py-2 md:ml-48 cursor-pointer hover:text-primary"
      >
        Historial
      </p>
      <!-- <div class="border-r my-2 border-[#9a9a9a]"></div>
      <p
        @click="tab = 2"
        :class="tab == 2 ? 'text-primary' : ''"
        class="px-4 py-2 cursor-pointer hover:text-primary"
      >
        Stock
      </p> -->
    </div>

    

    <!-- --------------------------------tab 1 History starts ------------------------- -->
    <div v-if="tab == 1" class="overflow-auto">
      <WarehouseRecordTable :movements="movements.data" :product="product" />
      <MovementPagination :pagination="movements" />
    </div>
    <!-- --------------------------------tab 1 History ends ------------------------- -->

    <!-- --------------------------------tab 1 History starts ------------------------- -->
    <div v-if="tab == 2">
      <ProductStockTable />
    </div>
    <!-- --------------------------------tab 1 History ends ------------------------- -->
  </AppLayout>
</template>

<script>
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