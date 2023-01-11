<template>
  <AppLayout title="Carrito">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Carrito</h2>
    </template>

    <div class="flex justify-between">
      <Link :href="route('sells-to-employees.create')"
        ><SecondaryButton class="mt-5 mr-2"
          >Venta a empleado</SecondaryButton
        ></Link
      >
      <Link :href="route('product-request.create')"
        ><SecondaryButton class="mt-5 ml-2"
          >Solicitar mercancía</SecondaryButton
        ></Link
      >
    </div>

    <div class="flex justify-center">
      <Link :href="route('sales.create')"
        ><SecondaryButton class="mt-2">Hacer corte</SecondaryButton></Link
      >
    </div>

    <div>
      <p class="text-sky-500 text-left ml-3 my-3 font-semibold">
        Empleados en carrito
      </p>
      <div class="flex justify-between">
        <p class="mx-3">
          <i class="fa-solid fa-user text-gray-500"></i> Fulanito de tal
        </p>
        <p class="mx-3">
          <i class="fa-solid fa-user text-gray-500"></i> Fulanito de tal
        </p>
      </div>
    </div>

    <div>
      <p class="text-sky-500 text-left ml-3 my-3 font-semibold">
        Solicitudes de mercancía (Hoy)
      </p>

        <div class="globe-container flex-col">
          <div class="globe hover:bg-gray-200 cursor-pointer">
            <div class="globe-title pb-2">
              A las 5:55 por: nombre del empleado que solicitó.
            </div>
            <div class="flex justify-between items-center">
              <span>ver todos los productos..</span>
            </div>
          </div>

          <div class="globe hover:bg-gray-200 cursor-pointer">
            <div class="globe-title pb-2">
              A las 5:55 por: nombre del empleado que solicitó.
            </div>
            <div class="flex justify-between items-center">
              <span>ver todos los productos..</span>
            </div>
          </div> 
        </div>
    </div>

    <div>
      <p class="text-sky-500 text-left ml-3 my-3 font-semibold">
        Inventario Actual
      </p>

        <div class="globe-container flex-col">
          <div v-for="cart_product in cart_products[0]" :key="cart_product" class="globe hover:bg-gray-200 cursor-pointer">
            <div class="globe-title pb-2">
              {{ cart_product[4] }}
            </div>
            <div class="flex justify-between items-center">
              <span>{{ cart_product[2] }}</span>
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
    cart_products: Object,
  },
  methods: {},
};
</script>
