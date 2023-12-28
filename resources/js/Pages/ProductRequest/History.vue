<template>
  <AppLayout title="Historial de Solicitudes de mercancía">
    <template #header>
      <div class="flex items-center mt-2">
        <Back />
        <h2 class="font-semibold text-xl text-gray-800 text-center ml-5 lg:ml-28">
          Historial de Solicitudes de mercancía
        </h2>
      </div>
    </template>

    <div class="globe-container flex-col">
        <Link :href="route('product-request.show', request)" v-for="request in requests.data" :key="request.id"
          class="globe hover:bg-gray-200 cursor-pointer">
        <div class="globe-title !justify-between pb-2">
          <span class="text-gray-500"><i class="fa-solid fa-user mr-1"></i> {{ request.user.name }}</span>
          <!-- <small class="text-gray-400">{{ timeFormatter(request.created_at) }}</small> -->
        </div>
        <div class="flex justify-between items-center">
          <span> {{ request.products.length }} producto(s) - (click para ver)</span>
        </div>
        <div class="mt-2 text-xs text-gray-500 -mb-2">
          <span> {{ request.created_at }}</span>
        </div>
        </Link>
        <p v-if="!requests.data.length" class="text-center text-xs text-gray-500 col-span-full">
          No hay solicitudes aún
        </p>
      </div>

      <div class="flex justify-end">
      <Pagination :pagination="requests" />
    </div>

  </AppLayout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import Pagination from "@/Components/Pagination.vue";
import Back from "@/Components/Back.vue";
import { Link } from "@inertiajs/inertia-vue3";

export default {
  data() {
    return {

    };
  },
  components: {
    AppLayout,
    Pagination,
    Back,
    Link,
  },
  props: {
    requests: Array,
  },
  methods: {

  },
};
</script>