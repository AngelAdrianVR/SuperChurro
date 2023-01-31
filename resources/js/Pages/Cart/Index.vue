<template>
  <AppLayout title="Carrito">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Carrito</h2>
    </template>

    <div class="flex justify-center items-center">
      <Link :href="route('sales-to-employees.create')">
      <SecondaryButton class="mt-5 mr-2">Venta a empleado / Cortesías</SecondaryButton>
      </Link>
      <!-- <Link :href="route('product-request.create')">
      <SecondaryButton class="mt-5 ml-2">Solicitar mercancía</SecondaryButton>
      </Link> -->
    </div>

    <div class="flex justify-center">
      <Link :href="route('sales.create')">
      <SecondaryButton class="mt-2">Hacer corte</SecondaryButton>
      </Link>
      <Link :href="route('cart.remove-products')">
      <SecondaryButton class="mt-2 mx-2">Remover mercancía</SecondaryButton>
      </Link>
    </div>

    <div>
      <p class="text-sky-500 text-left ml-3 my-3 font-semibold">Empleados en carrito</p>
      <div class="grid grid-cols-2 lg:grid-cols-4">
        <p v-for="employee in employees" :key="employee.id" class="mx-3">
          <i class="fa-solid fa-user text-gray-500"></i>
          {{ employee.name }}
        </p>
        <p v-if="Array.isArray(employees)" class="text-gray-500 text-xs text-center col-span-full">No hay empleados en
          carrito</p>
      </div>
    </div>

    <div>
      <p class="text-sky-500 text-left ml-3 my-3 font-semibold">
        Solicitudes de mercancía (Hoy)
      </p>

      <div class="globe-container flex-col">
        <Link :href="route('product-request.show', request)" v-for="request in requests" :key="request.id"
          class="globe hover:bg-gray-200 cursor-pointer">
        <div class="globe-title !justify-between pb-2">
          <span class="text-gray-500"><i class="fa-solid fa-user mr-1"></i> {{ request.user.name }}</span>
          <small class="text-gray-400">{{ timeFormatter(request.created_at) }}</small>
        </div>
        <div class="flex justify-between items-center">
          <span> {{ request.products.length }} producto(s) - (click para ver)</span>
        </div>
        </Link>
        <p v-if="!requests.length" class="text-center text-xs text-gray-500 col-span-full">
          No hay solicitudes aún
        </p>
      </div>
    </div>

    <div>
      <p class="text-sky-500 text-left ml-3 my-3 font-semibold">Inventario Actual</p>

      <div class="globe-container flex-col">
        <div v-for="cart_product_id in Object.keys(cart_products[0].products)" :key="cart_product_id" class="globe">
          <div class="globe-title pb-2">
            {{ products.find((product) => product.id == cart_product_id).name }}
          </div>
          <div class="flex justify-between items-center">
            <span>{{ cart_products[0].products[cart_product_id] }}
              {{
  products.find((product) => product.id == cart_product_id).unit.name
              }}</span>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import { Link } from "@inertiajs/inertia-vue3";
import ConfirmationModal from "@/Components/ConfirmationModal.vue";
export default {
  data() {
    return {};
  },
  components: {
    AppLayout,
    SecondaryButton,
    Link,
    ConfirmationModal,
  },
  props: {
    products: Array,
    requests: Array,
    cart_products: Object,
    employees: Object,
  },
  methods: {
    timeFormatter(timestamp) {
      const date_n_time = timestamp.split("T");
      return " a las " + date_n_time[1].split(".")[0];
    },
  },
};
</script>
