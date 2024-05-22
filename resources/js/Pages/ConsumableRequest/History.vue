<template>
    <div class="globe-container flex-col">
      <!-- <Link :href="route('consumable-request.show', request)" v-for="request in requests.data" :key="request.id"
        class="globe hover:bg-gray-200 cursor-pointer">
      <div class="globe-title !justify-between pb-2">
        <span class="text-gray-500"><i class="fa-solid fa-user mr-1"></i> {{ request.user.name }}</span>
      </div>
      <div class="flex justify-between items-center">
        <span> {{ request.consumables.length }} consumible(s) - (click para ver)</span>
      </div>
      <div class="mt-2 text-xs text-gray-500 -mb-2">
        <span> {{ request.created_at }}</span>
      </div>
      </Link>
      <p v-if="!requests.data.length" class="text-center text-xs text-gray-500 col-span-full">
        No hay solicitudes aún
      </p> -->
    </div>

    <!-- <div class="flex justify-end">
      <Pagination :pagination="requests" />
    </div> -->
</template>

<script>
import Pagination from "@/Components/Pagination.vue";
import Back from "@/Components/Back.vue";
import { Link } from "@inertiajs/inertia-vue3";

export default {
  data() {
    return {

    };
  },
  components: {
    Pagination,
    Back,
    Link,
  },
  props: {
    // requests: Array,
  },
  methods: {

  },
};
</script>