<template>
  <AppLayout title="Historial de movimientos">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
        Historial de "{{ product.name }}"
      </h2>
    </template>

    <div class="flex justify-start">
      <Link
        :href="route('warehouses.index')"
        class="flex items-center mt-2 text-secondary"
      >
        <i
          class="fas fa-solid fa-angle-left text-lg active:bg-gray-300 bg-opacity-100 rounded-full w-7 h-7 pl-1 lg:ml-8"
        ></i>
        <span class="ml-1 cursor-default">Atrás</span>
      </Link>
    </div>

    <div
      class="border-y border-[#9a9a9a] flex mt-4 transition-all duration-300 ease-in"
    >
      <p
        @click="tab = 1"
        :class="tab == 1 ? 'text-primary underline' : ''"
        class="px-4 py-2 md:ml-24 cursor-pointer hover:text-primary hover:underline"
      >
        Historial
      </p>
      <div class="border-r my-1 border-[#9a9a9a]"></div>
      <p
        @click="tab = 2"
        :class="tab == 2 ? 'text-primary underline' : ''"
        class="px-4 py-2 cursor-pointer hover:text-primary hover:underline"
      >
        Stock
      </p>
    </div>

    

    <!-- --------------------------------tab 1 History starts ------------------------- -->
    <div v-if="tab == 1" class="overflow-auto">
      <table class="border-separate border-spacing-x-8 mt-4 mx-auto">
        <thead>
          <tr>
            <th class="pr-4">Solicitado por</th>
            <th class="px-4">Tipo</th>
            <th class="px-4">Solicitado el</th>
            <th class="px-4">Para</th>
            <th class="px-4">Notas</th>
            <th class="px-4">Cantidad</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="(movement, index) in movements.data"
            :key="index"
            class="text-gray-600"
          >
            <td class="text-left pb-3">
              {{ movement.user.name }}
            </td>
            <td class="text-center pb-3">
              {{ movement.concept.name }}
            </td>
            <td class="text-center pb-3">
              {{ movement.created_at.split("T")[0] }}
            </td>
            <td class="text-center pb-3">
              {{ movement.warehouse_id }}
            </td>
            <td class="text-center pb-3">
              {{ movement.notes ?? "--" }}
            </td>
            <td
              :class="
                movement.concept.is_entry ? 'text-green-500' : 'text-red-500'
              "
              class="text-center pb-3 flex items-center"
            >
              <i
                v-if="movement.concept.is_entry"
                class="fa-solid fa-plus mr-1"
              ></i>
              <i v-else class="fa-solid fa-minus mr-1"></i>
              <span>{{ movement.quantity }} {{ product.unit.name }}</span>
            </td>
          </tr>
        </tbody>
      </table>
      <p
        v-if="movements.data.length === 0"
        class="text-sm text-gray-500 text-center my-3"
      >
        No hay ningún movimiento registrado para este producto.
      </p>
    <MovementPagination :pagination="movements" />
    </div>
    <!-- --------------------------------tab 1 History ends ------------------------- -->

    <!-- --------------------------------tab 1 History starts ------------------------- -->
    <div v-if="tab == 2">
      <table class="border-separate border-spacing-x-8 mt-2">
        <thead>
          <tr>
            <th class="pr-4">Nombre del producto</th>
            <th class="px-4">Stock</th>
            <th class="px-4">Fecha</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <tr class="text-gray-600 cursor-pointer mb-4">
            <td class="text-left pb-3">
              <!-- {{ Product.name }} -->
            </td>
            <td class="text-center pb-3">
              <!-- {{ Product.low_stock }} {{ Product.unit?.name }} -->
            </td>
            <td class="text-center pb-3">
              <!-- {{ Product.name }} -->
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <!-- --------------------------------tab 1 History ends ------------------------- -->
  </AppLayout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Link } from "@inertiajs/inertia-vue3";
import MovementPagination from "@/Components/MovementPagination.vue";

export default {
  data() {
    return {
      movements_reversed: null,
      tab: 1,
    };
  },
  components: {
    AppLayout,
    Link,
    MovementPagination,
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