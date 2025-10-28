<template>
  <AppLayout title="Solicitud de préstamo">
    <template #header>
      <div class="flex items-center mt-2">
        <Back />
        <h2 class="font-semibold text-xl text-gray-800 dar:text-gray-200 text-center ml-5 lg:ml-28">
          Solicitud de préstamo
        </h2>
      </div>
    </template>

    <!-- Modernized: Contenedor principal estilo "card" -->
    <div class="max-w-2xl md:mx-auto mt-10 mb-10 p-6 sm:p-8 bg-white dar:bg-gray-800 shadow-xl rounded-lg mx-4">
      
      <h3 class="text-lg font-medium text-gray-900 dar:text-gray-100 mb-2">Nueva Solicitud</h3>
      <p class="text-sm text-gray-600 dar:text-gray-400 mb-6">
        Completa los campos para solicitar un nuevo préstamo.
      </p>

      <!-- Modernized: Se añadió espaciado vertical (space-y-6) al formulario -->
      <form @submit.prevent="store" class="space-y-6">
        
        <div>
          <!-- Modernized: Se movió la etiqueta para que sea un componente estándar -->
          <InputLabel for="amount" value="Cantidad solicitada *" class="mb-1 text-sm" />
          <!-- Modernized: Clases añadidas para un input moderno y consistente -->
          <input 
            v-model="form.amount" 
            id="amount"
            type="number" 
            autocomplete="off" 
            class="input w-full dar:bg-gray-700 dar:border-gray-600 dar:text-gray-200"
            placeholder="$1,000.00" 
          />
          <InputError :message="$page.props?.errors.amount" class="mt-1" />
        </div>

        <div>
          <InputLabel for="description" value="Notas o comentarios (Opcional)" class="mb-1 text-sm" />
          <!-- Modernized: Clases añadidas para un textarea moderno -->
          <textarea 
            v-model="form.description"
            id="description"
            rows="3" 
            type="text" 
            autocomplete="off" 
            placeholder="Escribe aquí el motivo o detalles adicionales..." 
            class="textarea w-full dar:bg-gray-700 dar:border-gray-600 dar:text-gray-200"
          />
        </div>

        <!-- Modernized: Contenedor del botón alineado a la derecha -->
        <div class="flex justify-end pt-4">
          <PrimaryButton :disabled="form.processing">
            <span v-if="form.processing">Enviando...</span>
            <span v-else>Solicitar Préstamo</span>
          </PrimaryButton>
        </div>
      </form>
    </div>
  </AppLayout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
// PayRollTable no se usaba, así que lo eliminé para limpiar.
// import PayRollTable from "@/Components/PayRollTable.vue"; 
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import Back from "@/Components/Back.vue";
import { Link, useForm } from "@inertiajs/inertia-vue3";

export default {
  data() {
    const form = useForm({
      amount: null,
      description: "",
      remaining: 0, // Este campo parece innecesario en el formulario de *creación*
    });
    return {
      form,
    };
  },
  components: {
    AppLayout,
    // PayRollTable,
    PrimaryButton,
    InputError,
    InputLabel,
    Back,
    Link,
  },
  props: {},
  methods: {
    store() {
      this.form.post(this.route("loans.store"));
    },
  },
};
</script>
