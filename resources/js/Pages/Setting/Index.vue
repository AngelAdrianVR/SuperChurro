<template>
  <AppLayout title="Configuraciones">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Configuraciones de Administrador
      </h2>
    </template>

    <div class="globe-container">
      <div class="globe relative">
        <div class="globe-title">
            Configuraciones Generales
      </div>
      <div class="flex flex-col space-y-2">
        <div class="flex justify-between items-center">
            <p class="font-bold">Porcentaje de comision</p>
              <input type="number" class="rounded-lg w-1/2 h-7">
      </div>
        <div class="flex justify-between items-center">
            <p class="font-bold">porcentaje de descuento de venta a empleado</p>
              <input type="number" class="rounded-lg w-1/2 h-7">
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
    return {

      }
  },
  components: {
    AppLayout,
    SecondaryButton,
    Link,
    ConfirmationModal,
  },
  props: {

  },
  methods: {
    
},
};
</script>
