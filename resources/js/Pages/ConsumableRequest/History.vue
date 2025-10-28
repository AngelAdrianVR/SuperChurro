<template>
  <!-- 
    MODIFICACIÓN: 
    - Se añade padding (px-4) al contenedor principal.
  -->
  <section class="px-4">
    <Loading v-if="loading" class="mt-20" />
    <div v-else>
      <!-- 
        MODIFICACIÓN: 
        - Se reemplaza 'globe-container' por un grid moderno.
        - 'space-y-4' para separar las tarjetas.
      -->
      <div v-if="ConsumableRequests.length" class="max-w-3xl mx-auto space-y-4 mt-6">
        <Link
          :href="route('consumable-request.show', request)"
          v-for="request in ConsumableRequests"
          :key="request.id"
          class="block p-5 bg-white rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-200"
        >
          <!-- 
            MODIFICACIÓN: 
            - Se reemplaza 'globe-title' por flexbox.
            - Mejor estilo tipográfico para el usuario.
          -->
          <div class="flex justify-between items-center border-b pb-3 mb-3">
            <span class="text-sm font-medium text-gray-700 flex items-center">
              <i class="fa-solid fa-user mr-2 text-gray-400"></i>
              {{ request.user.name }}
            </span>
          </div>
          <!-- 
            MODIFICACIÓN: 
            - Texto principal más claro y con mejor contraste.
          -->
          <div class="flex justify-between items-center">
            <span class="text-base font-semibold text-gray-900">
              {{ request.consumables.length }} consumible(s)
            </span>
            <span class="text-sm text-blue-600 font-medium">Ver detalles</span>
          </div>
          <!-- 
            MODIFICACIÓN: 
            - Fecha alineada a la derecha y con mejor formato.
          -->
          <div class="mt-3 text-right">
            <span class="text-xs text-gray-500">{{ request.created_at }}</span>
          </div>
        </Link>

        <!-- Paginación y conteo -->
        <div class="pt-4">
          <p v-if="ConsumableRequests.length" class="text-gray-600 text-sm text-center">
            Mostrando {{ ConsumableRequests.length }} de {{ totalItems }} solicitudes
          </p>
          
          <!-- 
            MODIFICACIÓN: 
            - Indicador de carga centrado y estilizado.
          -->
          <p v-if="loadingItems" class="text-sm text-center text-gray-600 py-4">
            Cargando
            <i class="fa-sharp fa-solid fa-circle-notch fa-spin ml-2 text-blue-600"></i>
          </p>
          
          <!-- 
            MODIFICACIÓN: 
            - Botón "Cargar más" estilizado como un botón real.
          -->
          <button
            v-else-if="ConsumableRequests.length && totalItems > 30 && ConsumableRequests.length < totalItems"
            @click="fetchItemsByPage"
            class="w-full max-w-xs mx-auto block text-center text-blue-600 bg-blue-50 hover:bg-blue-100 py-2 px-4 rounded-lg font-medium my-4 transition-colors"
          >
            Cargar más elementos
          </button>
        </div>
      </div>
      
      <!-- 
        MODIFICACIÓN: 
        - Mensaje de "sin solicitudes" más prominente.
      -->
      <p v-else class="text-center text-base text-gray-500 mt-12">
        No hay solicitudes de consumibles aún
      </p>
    </div>
  </section>
</template>

<!-- El script se mantiene idéntico -->
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
