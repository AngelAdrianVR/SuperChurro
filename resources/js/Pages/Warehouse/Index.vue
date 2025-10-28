<template>
  <AppLayout title="Cocina">
    <!-- 
      MODIFICADO: 
      - Contenedor de acciones rediseñado.
      - 'justify-end' cambiado a 'justify-between' para alinear la búsqueda a la izquierda y el botón a la derecha.
      - 'items-center' para alinear verticalmente.
      - 'gap-4' para espaciado.
    -->
    <div class="flex flex-col md:flex-row justify-between items-center gap-4 md:mr-10 mr-4 mt-10 mx-4">
      <IconInput @keyup.enter="handleSearch" v-model="inputSearch" class="w-full md:w-1/2 lg:w-1/3"
        inputPlaceholder="Buscar producto" inputType="text">
        <el-tooltip content="Buscar producto" placement="top">
          <i class="fa-solid fa-magnifying-glass text-gray-400"></i>
        </el-tooltip>
      </IconInput>

      <!-- MODIFICADO: Se elimina el 'div' contenedor innecesario -->
      <Link :href="route('warehouse-movements.create')">
      <PrimaryButton>Registrar entrada / salida</PrimaryButton>
      </Link>
    </div>

    <!-- 
      MODIFICADO: 
      - El contenedor de "Colaboradores" ahora es una tarjeta moderna.
      - Se reemplaza 'border border-gray3 rounded-md inline-block' por 'bg-white dar:bg-gray-800 shadow-lg rounded-xl'.
      - Se añade 'my-6' para espaciado vertical y se ajusta el padding a 'p-4'.
    -->
    <div class="bg-white dar:bg-gray-800 shadow-lg rounded-xl p-4 mx-4 my-6">
      <!-- MODIFICADO: Estilo de título de tarjeta -->
      <p class="text-lg font-semibold text-gray-900 dar:text-white mb-3 text-left">
        Colaborador(es) en cocina
      </p>
      <!-- MODIFICADO: Se usa 'flex flex-col gap-2' para una lista espaciada verticalmente -->
      <div class="flex flex-col gap-2">
        <!-- MODIFICADO: Se añade 'flex items-center gap-2' y estilos de texto suaves -->
        <p class="flex items-center gap-2 text-sm text-gray-600 dar:text-gray-300" v-for="employee in employees"
          :key="employee.id">
          <i class="fa-regular fa-circle-user text-gray-400"></i>
          <span>{{ employee.name }}</span>
        </p>
        <!-- MODIFICADO: Estilo de "placeholder" mejorado -->
        <p v-if="Array.isArray(employees) && employees.length === 0"
          class="text-gray-400 dar:text-gray-500 text-xs text-center py-3 col-span-full">
          No hay colaboradores en cocina
        </p>
      </div>
    </div>

    <div>
      <!-- 
        MODIFICADO: 
        - 'globe-container' reemplazado por un 'grid' responsive de Tailwind.
        - Esto crea una cuadrícula moderna que se adapta a diferentes tamaños de pantalla.
        - Añadido 'p-4' para espaciar la cuadrícula de los bordes.
      -->
      <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4 p-4">
        <!-- 
          MODIFICADO: 
          - La clase 'globe' se reemplaza por un estilo de tarjeta de producto completa.
          - 'bg-white dar:bg-gray-800', 'shadow-lg', 'rounded-xl', 'overflow-hidden' para un look de tarjeta.
          - Efectos 'hover:shadow-2xl hover:-translate-y-1' para interactividad.
        -->
        <Link v-for="product_id in filteredTableData" :key="product_id"
          :href="route('warehouse-movements.show-product-record', product_id)"
          class="block bg-white dar:bg-gray-800 shadow-lg rounded-xl overflow-hidden transform transition-all duration-300 hover:shadow-2xl hover:-translate-y-1">
        <!-- 
            MODIFICADO: 
            - La imagen ahora usa 'w-full h-40 object-cover' para un tamaño uniforme y moderno.
            - Se elimina 'justify-center', 'pt-2' y 'rounded-lg h-32 mx-auto'.
          -->
        <figure v-if="products.find(product => product.id == product_id)?.media.length > 0">
          <img :src="products.find(product => product.id == product_id)?.media[0]?.original_url"
            alt="Imagen del producto" class="w-full h-40 object-cover">
        </figure>
        <!-- Fallback para imagen si no existe -->
        <div v-else class="w-full h-40 bg-gray-200 dar:bg-gray-700 flex items-center justify-center">
            <i class="fa-solid fa-camera text-4xl text-gray-400 dar:text-gray-500"></i>
        </div>

        <!-- MODIFICADO: Contenedor con padding para el texto -->
        <div class="p-4">
          <!-- MODIFICADO: Estilos para el título del producto. 'truncate' evita desbordamiento de texto. -->
          <div class="text-base font-semibold text-gray-900 dar:text-white text-center truncate"
            :title="products.find(product => product.id == product_id)?.name">
            {{ products.find(product => product.id == product_id)?.name }}
          </div>
          <!-- 
              MODIFICADO: 
              - Se aumenta el tamaño de fuente del stock a 'text-xl font-bold'.
              - Se añade 'items-baseline' y 'gap-2' para mejor alineación.
            -->
          <div class="flex justify-center items-baseline gap-2 mt-2"
            :class="warehouse.products[product_id] <= products.find(product => product.id == product_id).low_stock ? 'text-red-500' : 'text-green-600 dar:text-green-400'">
            <span class="text-xl font-bold">{{ warehouse.products[product_id] }}</span>
            <span class="text-sm">{{ products.find(product => product.id == product_id).unit?.name }}</span>
            <i v-if="warehouse.products[product_id] <= products.find(product => product.id == product_id).low_stock"
              class="fa-solid fa-triangle-exclamation text-xs"></i>
          </div>
        </div>
        </Link>
      </div>
    </div>
  </AppLayout>
</template>

<script>
// El script permanece sin cambios
import AppLayout from "@/Layouts/AppLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import ThirthButton from "@/Components/ThirthButton.vue";
import IconInput from "@/Components/IconInput.vue";
import { Link } from "@inertiajs/inertia-vue3";

export default {
  data() {
    return {
      search: "",
      inputSearch: "",
    };
  },
  components: {
    AppLayout,
    PrimaryButton,
    SecondaryButton,
    IconInput,
    ThirthButton,
    Link
  },
  props: {
    warehouse: Object,
    products: Array,
    employees: Object,
  },
  methods: {
    handleSearch() {
      this.search = this.inputSearch;
    },
  },
  computed: {
    filteredTableData() {
      if (!this.search) {
        // Si no hay término de búsqueda, devuelve todos los IDs
        return this.products.filter(product => product.id != 29).map(product => product.id);
      } else {
        // Filtra los productos por nombre y devuelve los IDs
        return this.products
          .filter(product => product.name.toLowerCase().includes(this.search.toLowerCase()) && product.id != 29)
          .map(filteredProduct => filteredProduct.id);
      }
    },
  },
};
</script>
