<template>
  <AppLayout title="Cocina">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Cocina</h2>
    </template>

    <div class="flex justify-end">
      <Link :href="route('warehouses.create')"
        ><SecondaryButton class="mt-5 mr-2"
          >Registrar Entrada/Salida</SecondaryButton
        ></Link
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
          <div class="globe hover:bg-gray-200 cursor-pointer">
            <div class="globe-title !justify-start pb-2">
              Bolsa para churros
            </div>
            <div class="flex justify-between items-center">
              <span>150 piezas.</span>
            </div>
          </div>

          <div class="globe hover:bg-gray-200 cursor-pointer">
            <div class="globe-title !justify-start pb-2">
              Botanas
            </div>
            <div class="flex justify-between items-center">
              <span>15 piezas.</span>
            </div>
          </div>
          <div class="globe hover:bg-gray-200 cursor-pointer">
            <div class="globe-title !justify-start pb-2">
              Tostitos
            </div>

            <div class="flex justify-between items-center">
              <span>10 piezas.</span>
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
  props: {},
  methods: {},
};
</script>
