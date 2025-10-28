<template>
  <Loading v-if="loading" class="mt-20" />
  <section v-else>
    <!-- MODIFICADO: 
      - Se cambió 'globe-container flex-col' por un grid responsivo ('grid grid-cols-1 md:grid-cols-2 gap-4').
      - Esto presentará las tarjetas en dos columnas en pantallas medianas y más grandes.
    -->
    <div v-if="productRequests.length" class="grid grid-cols-1 md:grid-cols-2 gap-4">
      
      <!-- MODIFICADO: 
        - Se reemplazaron las clases 'globe' por un diseño de tarjeta moderno.
        - Se usa 'bg-white dar:bg-gray-800', 'rounded-2xl', 'shadow-lg'.
        - Se agrega 'transition-all duration-300' y 'hover:shadow-xl hover:-translate-y-1' para un efecto de hover sutil.
        - Se reorganizó el contenido interno para mejor estructura y espaciado ('p-5').
      -->
      <Link :href="route('product-request.show', request)" v-for="request in productRequests" :key="request.id"
        class="
          block 
          p-5 
          bg-white 
          dar:bg-gray-800 
          rounded-2xl 
          shadow-lg 
          transition-all 
          duration-300 
          ease-in-out
          hover:shadow-xl 
          hover:-translate-y-1
        ">
        
        <!-- MODIFICADO: 
          - Contenedor para la cabecera de la tarjeta.
          - Se usa 'text-sm' y colores de modo oscuro.
        -->
        <div class="flex items-center justify-between pb-2 border-b border-gray-200 dar:border-gray-700">
          <span class="text-sm font-medium text-gray-600 dar:text-gray-400">
            <i class="fa-solid fa-user mr-2 text-indigo-500"></i>
            {{ request.user.name }}
          </span>
        </div>

        <!-- MODIFICADO: 
          - Cuerpo de la tarjeta con la información principal.
          - Se aumentó el tamaño de fuente y se mejoró el color.
        -->
        <div class="mt-4">
          <span class="text-lg font-semibold text-gray-900 dar:text-gray-100">
            {{ request.products.length }} producto(s)
          </span>
          <p class="text-sm text-indigo-600 dar:text-indigo-400 font-medium">
            (click para ver detalles)
          </p>
        </div>

        <!-- MODIFICADO: 
          - Pie de la tarjeta para la fecha.
        -->
        <div class="mt-4 text-xs text-gray-500 dar:text-gray-500 text-right">
          <span>{{ request.created_at }}</span>
        </div>
      </Link>
      
      <!-- MODIFICADO: 
        - Contenedor del paginador/botón 'Cargar más'.
        - Se usa 'md:col-span-2' para que ocupe ambas columnas en grid.
      -->
      <div class="md:col-span-2 text-center mt-4">
        <p v-if="productRequests.length" class="text-gray-600 dar:text-gray-400 text-sm mt-1">
          Mostrando {{ productRequests.length }} de {{ totalItems }} elementos
        </p>
        <p v-if="loadingItems" class="text-sm my-4 text-center text-gray-600 dar:text-gray-400">
          Cargando <i class="fa-sharp fa-solid fa-circle-notch fa-spin ml-2 text-indigo-500"></i>
        </p>
        
        <!-- MODIFICADO: 
          - Botón 'Cargar más' estilizado como un botón secundario moderno.
          - Se reemplazó 'underline' por un botón real para mejor UX/UI.
        -->
        <button v-else-if="productRequests.length && totalItems > 30 && productRequests.length < totalItems"
          @click="fetchItemsByPage" 
          class="
            mt-4 
            px-6 
            py-2 
            text-sm 
            font-medium 
            text-indigo-700 
            bg-indigo-100 
            dar:text-indigo-300 
            dar:bg-indigo-900
            rounded-full 
            hover:bg-indigo-200 
            dar:hover:bg-indigo-800
            focus:outline-none 
            focus:ring-2 
            focus:ring-indigo-500 
            focus:ring-offset-2
            dar:focus:ring-offset-gray-900
            transition-colors
          ">
          Cargar más elementos
        </button>
      </div>
    </div>
    
    <!-- MODIFICADO: 
      - Mensaje de "No hay solicitudes" centrado y con mejor estilización.
    -->
    <p v-else class="text-center text-base text-gray-500 dar:text-gray-400 col-span-full mt-10">
      No hay solicitudes de mercancía aún
    </p>
  </section>
</template>

<script>
// El script permanece sin cambios
import Loading from "@/Components/MyComponents/Loading.vue";
import Back from "@/Components/Back.vue";
import { Link } from "@inertiajs/inertia-vue3";
import axios from "axios";

export default {
  data() {
    return {
      loading: false,
      productRequests: [],
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
        const response = await axios.get(route('product-request.index'));

        if (response.status === 200) {
          this.productRequests = response.data.items;
          this.totalItems = response.data.total_items;
        }
      } catch (error) {
        console.error(error);
        this.$notify({
          title: "Problema al obtener las solicitudes de mercancía",
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
        const response = await axios.get(route('product-request.get-by-page', this.currentPage));

        if (response.status === 200) {
          this.productRequests = [...this.productRequests, ...response.data.items];
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
