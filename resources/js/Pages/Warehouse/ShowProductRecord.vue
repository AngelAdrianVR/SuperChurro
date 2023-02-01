<template>
  <AppLayout title="Historial de movimientos">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Historial de "{{ product.name }}"
      </h2>
    </template>

    <div class="flex justify-start">
      <Link :href="route('warehouses.index')" class="flex items-center mt-2 text-slate-700">
      <i class="
            fas
            fa-long-arrow-alt-left
            text-lg
            active:bg-gray-300
            bg-opacity-100
            rounded-full
            w-7
            h-7
            pl-1
            ml-2
          "></i>
      <span class="ml-1 cursor-default">Atrás</span>
      </Link>
    </div>
    <div class="globe-container flex-col">
      <div v-for="movement in product.movements" :key="movement" class="globe">
        <p class="globe-title !justify-between pb-2 text-gray-500">
          <div>
            <i class="fa-solid fa-user mr-1"></i>
            {{ movement.user.name }}
          </div>
          <!-- <small class="text-gray-400">{{ dateTimeFormatter(movement.created_at) }}</small> -->
        </p>
        <p class="font-bold">
          <i class="fa-solid fa-tag mr-1"></i>
          {{ movement.concept.name }}
        </p>
        <p style="white-space: pre-line;" class="my-1 text-gray-500 text-sm">
          <i class="fa-regular fa-comment mr-1"></i>
          {{ movement.notes ?? '--'}}
        </p>
        <div class="flex items-center"
          :class="movement.concept.is_entry ? 'text-green-500' : 'text-red-500'">
          <i v-if="movement.concept.is_entry" class="fa-solid fa-plus mr-1"></i>
          <i v-else class="fa-solid fa-minus mr-1"></i>
          <span>{{ movement.quantity }} {{ product.unit.name }}</span>
        </div>
      </div>
      <p v-if="product.movements.length === 0" class="text-sm text-gray-500 text-center my-3">
        No hay ningún movimiento registrado para este producto.
      </p>
    </div>
  </AppLayout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Link } from "@inertiajs/inertia-vue3";

export default {
  data() {
    return {
      movements_reversed: null
    };
  },
  components: {
    AppLayout,
    Link,
  },
  props: {
    product: Object,
  },
  methods: {
    dateTimeFormatter(timestamp) {
      const date_n_time = timestamp.split('T');
      return date_n_time[0] + ' a las ' + date_n_time[1].split('.')[0];
    }
  },
};
</script>