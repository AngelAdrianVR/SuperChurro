<template>
  <Loading v-if="loading" class="mt-20" />
  <section v-else>
    <div v-if="ConsumableRequests.length" class="globe-container flex-col">
      <Link :href="route('consumable-request.show', request)" v-for="request in ConsumableRequests" :key="request.id"
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
      <div class="col-span-full">
        <p v-if="ConsumableRequests.length" class="text-gray66 text-[11px] mt-1">
          {{ ConsumableRequests.length }} de {{ totalItems }}
          elementos
        </p>
        <p v-if="loadingItems" class="text-xs my-4 text-center">
          Cargando <i class="fa-sharp fa-solid fa-circle-notch fa-spin ml-2 text-primary"></i>
        </p>
        <button v-else-if="ConsumableRequests.length && totalItems > 30 && ConsumableRequests.length < totalItems"
          @click="fetchItemsByPage" class="w-full text-primary my-4 text-xs mx-auto underline ml-6">Cargar más
          elementos</button>
      </div>
    </div>
    <p v-else class="text-center text-xs text-gray-500 col-span-full mt-6">
      No hay solicitudes de consumibles aún
    </p>
  </section>
</template>

<script>
import Loading from "@/Components/MyComponents/Loading.vue";
import Back from "@/Components/Back.vue";
import { Link } from "@inertiajs/inertia-vue3";
import axios from "axios";

export default {
  data() {
    return {
      loading: false,
      ConsumableRequests: [],
      totalItems: null,
      //paginación
      loadingItems: false,
      currentPage: 1,
    };
  },
  components: {
    Loading,
    Back,
    Link,
  },
  props: {
  },
  methods: {
    async fetchItems() {
      try {
        this.loading = true;
        const response = await axios.get(route('consumable-request.index'));

        if (response.status === 200) {
          this.ConsumableRequests = response.data.items;
          this.totalItems = response.data.total_items;
        }
      } catch (error) {
        console.error(error);
        this.$notify({
          title: "Problema al obtener las solicitudes de consumibles",
          message: "",
          type: "error"
        })
      } finally {
        this.loading = false;
      }
    },
    async fetchItemsByPage() {
      try {
        this.loadingItems = true;
        const response = await axios.get(route('consumable-request.get-by-page', this.currentPage));

        if (response.status === 200) {
          this.ConsumableRequests = [...this.ConsumableRequests, ...response.data.items];
          this.currentPage++;
        }
      } catch (error) {
        console.log(error)
      } finally {
        this.loadingItems = false;
      }
    },
  },
  mounted() {
    this.fetchItems();
  }
};
</script>