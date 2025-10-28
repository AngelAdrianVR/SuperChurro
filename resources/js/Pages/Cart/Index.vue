<template>
  <AppLayout title="Carrito">
    <!-- 
      MODIFICADO: 
      - Contenedor de acciones rediseñado.
      - Se usa 'flex-col md:flex-row' para responsividad.
      - 'justify-between items-center' y 'gap-4' para alineación y espaciado.
      - Se añade padding 'px-4 md:px-10'.
    -->
    <div class="md:mx-10 mx-4 flex flex-col md:flex-row justify-between items-center gap-4 my-9">
      <IconInput @keyup.enter="handleSearch" v-model="inputSearch" class="w-full md:w-1/2 lg:w-1/3"
        inputPlaceholder="Buscar producto" inputType="text">
        <el-tooltip content="Buscar producto" placement="top">
          <!-- MODIFICADO: Se añade color al icono -->
          <i class="fa-solid fa-magnifying-glass text-gray-400"></i>
        </el-tooltip>
      </IconInput>

      <div>
        <Link :href="route('product-request.create')">
        <PrimaryButton class="">Solicitar mercancía</PrimaryButton>
        </Link>
      </div>
    </div>

    <!-- 
      MODIFICADO: 
      - Contenedor de "Colaboradores" ahora es una tarjeta moderna.
      - Se reemplaza 'border border-gray-300 p-4 rounded-lg' por 'bg-white shadow-xl rounded-2xl p-6'.
    -->
    <div class="md:mx-10 mx-4 my-7 bg-white shadow-xl rounded-2xl p-6">
      <div class="text-center">
        <!-- MODIFICADO: Estilo de título de tarjeta -->
        <p class="text-lg font-semibold text-gray-900 mb-4">
          Colaboradores en carrito
        </p>
        <!-- MODIFICADO: Se usa 'flex flex-col gap-2' y se centra el contenedor -->
        <div class="flex flex-col gap-2 max-w-xs mx-auto">
          <p v-for="employee in employees" :key="employee.id"
            class="text-sm text-gray-600 flex items-center gap-3">
            <i class="fa-regular fa-circle-user text-gray-400"></i>
            <span>{{ employee.name }}</span>
          </p>
          <p v-if="Array.isArray(employees) && employees.length === 0"
            class="text-gray-400 text-xs text-center col-span-full pt-2">
            No hay colaboradores en carrito
          </p>
        </div>
        <Link :href="route('sales-to-employees.create')">
        <ThirthButton class="mt-6">Venta a empleado / Cortesías</ThirthButton>
        </Link>
      </div>
    </div>

    <!-- MODIFICADO: Contenedor para la sección de Solicitudes -->
    <div class="md:mx-10 mx-4 mt-12">
      <!-- MODIFICADO: Título de sección con link "Ver historial" alineado -->
      <div class="flex items-center justify-between mb-4">
        <p class="text-lg font-semibold text-gray-700">
          Solicitudes de mercancía / Consumibles (Hoy)
        </p>
        <Link :href="route('carts.requests-index')">
        <p class="text-sm font-medium text-indigo-600 hover:text-indigo-500" v-if="$page.props.user.is_admin">
          Ver historial
        </p>
        </Link>
      </div>

      <!-- MODIFICADO: 'globe-container' reemplazado por 'space-y-3' para una lista limpia -->
      <div class="space-y-3">
        <!-- MODIFICADO: 'globe' reemplazado por un estilo de tarjeta de lista -->
        <Link :href="route('product-request.show', request)" v-for="request in requests" :key="request.id"
          class="flex items-center justify-between p-4 bg-white shadow-lg rounded-xl hover:bg-gray-50 transition-colors duration-200">
        <div class="">
          <span class="text-sm font-medium text-gray-700 flex items-center gap-2">
            <i class="fa-solid fa-user text-gray-400"></i>
            {{ request.user.name }}
          </span>
        </div>
        <div class="flex justify-between items-center">
          <span class="text-sm text-gray-500">
            {{ request.products.length }} producto(s) - (click para ver)
          </span>
        </div>
        </Link>
        <p v-if="!requests.length" class="text-center text-sm text-gray-500 pt-4">
          No hay solicitudes aún
        </p>
      </div>
    </div>

    <!-- MODIFICADO: Contenedor para la sección de Inventario -->
    <div class="mt-12">
      <!-- MODIFICADO: Título de sección con botón alineado -->
      <div class="md:mx-10 mx-4 flex items-center justify-between mb-4">
        <p class="text-lg font-semibold text-gray-700">
          Inventario Actual
        </p>
        <div class="flex justify-center">
          <Link :href="route('cart.remove-products')">
          <ThirthButton>Remover mercancía</ThirthButton>
          </Link>
        </div>
      </div>

      <!-- 
        MODIFICADO: 
        - 'globe-container flex-col' reemplazado por la cuadrícula de productos moderna.
        - Es el mismo estilo usado en 'Cocina' (Index.vue) para consistencia.
      -->
      <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4 p-4">
        <!-- 
          MODIFICADO: 
          - Se cambia 'globe' por el estilo de tarjeta de producto.
          - 'grid grid-cols-2' interno eliminado, la cuadrícula ahora es el padre.
        -->
        <div v-for="cart_product_id in filteredTableData" :key="cart_product_id"
          class="bg-white shadow-lg rounded-xl overflow-hidden">
          
          <!-- MODIFICADO: Imagen con 'w-full h-40 object-cover' -->
          <figure v-if="products.find(product => product.id == cart_product_id )?.media.length > 0">
            <img :src="products.find(product => product.id == cart_product_id )?.media[0]?.original_url"
              alt="Imagen del producto" class="w-full h-40 object-cover">
          </figure>
          <!-- MODIFICADO: Fallback de imagen moderno -->
          <div v-else class="w-full h-40 bg-gray-200 flex items-center justify-center">
            <i class="fa-solid fa-camera text-4xl text-gray-400"></i>
          </div>

          <!-- MODIFICADO: Contenedor de texto con padding -->
          <div class="p-4">
            <!-- MODIFICADO: Estilo de título de producto -->
            <div class="text-base font-semibold text-gray-900 text-center truncate"
              :title="products.find((product) => product.id == cart_product_id)?.name">
              {{
                products.find((product) => product.id == cart_product_id)?.name
              }}
            </div>
            <!-- MODIFICADO: Estilo de stock -->
            <div class="flex justify-center items-baseline gap-2 mt-2">
              <p class="text-xl font-bold text-gray-900">
                {{ cart_products[0].products[cart_product_id] }}
              </p>
              <span class="text-sm text-gray-600">
                {{
                  products.find((product) => product.id == cart_product_id).unit?.name
                }}
              </span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script>
// El script permanece sin cambios
import AppLayout from "@/Layouts/AppLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import ConfirmationModal from "@/Components/ConfirmationModal.vue";
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
    SecondaryButton,
    ConfirmationModal,
    ThirthButton,
    IconInput,
    PrimaryButton,
    Link
  },
  props: {
    products: Array,
    requests: Array,
    cart_products: Object,
    employees: Object,
    sales: Array,
  },
  methods: {
    timeFormatter(timestamp) {
      const date_n_time = timestamp.split("T");
      return " a las " + date_n_time[1].split(".")[0];
    },
    handleSearch() {
      this.search = this.inputSearch;
    },
  },
  computed: {
    filteredTableData() {
      if (!this.search) {
        // Si no hay término de búsqueda, devuelve todos los IDs
        return this.products.map(product => product.id);
      } else {
        // Filtra los productos por nombre y devuelve los IDs
        return this.products
          .filter(product => product.name.toLowerCase().includes(this.search.toLowerCase()))
          .map(filteredProduct => filteredProduct.id);
      }
    },
  },
};
</script>

