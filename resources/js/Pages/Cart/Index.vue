<template>
  <AppLayout title="Carrito">
    <!-- <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Carrito</h2>
    </template> -->
    <div class="md:mx-10 mx-2">
      <div class="md:flex justify-between items-center space-y-5 my-9">
        <div
          class="flex space-x-3 md:flex-row justify-between md:justify-end md:mr-10 items-center"
        >
          <IconInput
            @keyup.enter="handleSearch" 
            v-model="inputSearch"
            class="md:w-2/3 w-1/2"
            inputPlaceholder="Buscar producto"
            inputType="text"
          >
            <el-tooltip content="Buscar producto" placement="top">
              <i class="fa-solid fa-magnifying-glass"></i>
            </el-tooltip>
          </IconInput>
          <!-- <InputError :message="form.errors.business_name" /> -->

          <div>
            <Link :href="route('product-request.create')">
              <PrimaryButton class="">Solicitar mercancía</PrimaryButton>
            </Link>
          </div>
        </div>
      </div>

      <div
        class="my-7 border border-gray-300 p-4 rounded-lg text-center"
      >
        <div class="">
          <p class="text-gray-700 text-center ml-3 my-3 font-semibold">
            Colaboradores en carrito
          </p>
          <div class="">
            <p v-for="employee in employees" :key="employee.id" class="mx-3 my-2">
              <i class="fa-regular fa-circle-user text-gray-600 mr-3"></i>
              <span>{{ employee.name }}</span>
            </p>
            <p
              v-if="Array.isArray(employees)"
              class="text-gray-500 text-xs text-center col-span-full mt-4"
            >
              No hay colaboradores en carrito
            </p>
          </div>
          <Link :href="route('sales-to-employees.create')">
            <ThirthButton class="mt-4">Venta a empleado / Cortesías</ThirthButton>
          </Link>
        </div>

        <!-- <div class="mb-4 mt-14 md:my-1 text-center">
          <p class="text-gray-700 ml-3 my-3 font-semibold">Cortes</p>

          <ul>
            <li class="flex items-center justify-center space-x-4">
              <p class="text-primary">Primer turno</p>
              <i class="fa-solid fa-check text-green-600"></i>
              <i class="fa-solid fa-minus text-gray-700"></i>
            </li>
            <li class="flex items-center justify-center space-x-4">
              <p class="text-primary">Segundo turno</p>
              <i class="fa-solid fa-check text-green-600"></i>
              <i class="fa-solid fa-minus text-gray-700"></i>
            </li>
          </ul>

          <div class="globe-container flex-col">
            <div v-for="sale in sales" :key="sale.id" class="globe">
              <p class="text-sm flex justify-between">
                {{ sale }}
                <i class="fa-solid fa-circle-check text-lg text-green-600"></i>
              </p>
            </div>
            <p
              v-if="!sales.length"
              class="text-center text-xs text-gray-500 col-span-full"
            >
              No se ha registrado ningún corte
            </p>
          </div>
          <Link :href="route('sales.create')">
            <PrimaryButton class="mt-2">Hacer corte</PrimaryButton>
          </Link>
        </div> -->
      </div>

      <div>
        <p class="text-gray-700 text-left mx-4 my-3 font-semibold flex items-center">
          Solicitudes de mercancía / Consumibles (Hoy)
          <Link :href="route('carts.requests-index')">
            <p class="ml-9 text-primary font-normal" v-if="$page.props.user.is_admin"
              >Ver historial</p
            >
          </Link>
        </p>

        <div class="globe-container flex-col">
          <Link
            :href="route('product-request.show', request)"
            v-for="request in requests"
            :key="request.id"
            class="globe hover:bg-gray-200 cursor-pointer"
          >
            <div class="globe-title !justify-between pb-2">
              <span class="text-gray-500"
                ><i class="fa-solid fa-user mr-1"></i>
                {{ request.user.name }}</span
              >
            </div>
            <div class="flex justify-between items-center">
              <span>
                {{ request.products.length }} producto(s) - (click para
                ver)</span
              >
            </div>
          </Link>
          <p
            v-if="!requests.length"
            class="text-center text-xs text-gray-500 col-span-full"
          >
            No hay solicitudes aún
          </p>
        </div>
      </div>

      <div class="mt-20">
        <div class="flex items-center justify-between">
          <p class="text-gray-700 text-left ml-3  font-semibold">
            Inventario Actual
          </p>
          <div class="flex justify-center">
            <Link :href="route('cart.remove-products')">
              <ThirthButton>Remover mercancía</ThirthButton>
            </Link>
          </div>
        </div>

        <div class="globe-container flex-col">
          <div
            v-for="cart_product_id in filteredTableData"
            :key="cart_product_id"
            class="globe grid grid-cols-2"
          >
          <figure v-if="products.find(product => product.id == cart_product_id )?.media.length > 0" class="justify-center pt-2">
            <img :src="products.find(product => product.id == cart_product_id )?.media[0]?.original_url" alt="Imagen del producto" class="rounded-lg h-32 mx-auto">
          </figure>
            <div>
              <div class="globe-title !font-semibold pb-2">
                {{
                  products.find((product) => product.id == cart_product_id)?.name
                }}
              </div>
              <div class="flex justify-center items-center">
                <p class="font-bold"
                  >{{ cart_products[0].products[cart_product_id] }}
                  {{
                    products.find((product) => product.id == cart_product_id).unit?.name
                  }}</p
                >
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script>
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
