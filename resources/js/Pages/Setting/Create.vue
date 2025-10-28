<template>
  <AppLayout title="Nueva Configuración">
    <template #header>
      <div class="flex items-center mt-2 relative">
        <Back class="absolute left-0" />
        <h2 class="font-semibold text-xl text-gray-800 dar:text-gray-200 leading-tight text-center w-full">
          Nueva configuración
        </h2>
      </div>
    </template>

    <div class="py-12">
      <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dar:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6 sm:p-8">
          <form @submit.prevent="store" class="space-y-6">
            
            <!-- Campo Nombre (Key) -->
            <div>
              <InputLabel for="key" value="Nombre *" class="dar:text-gray-300" />
              <input 
                id="key"
                v-model="form.key" 
                type="text" 
                autocomplete="off" 
                required 
                class="mt-1 block w-full border-gray-300 dar:border-gray-700 dar:bg-gray-900 dar:text-gray-300 focus:border-indigo-500 dar:focus:border-indigo-600 focus:ring-indigo-500 dar:focus:ring-indigo-600 rounded-md shadow-sm"
                placeholder="Escribe el nombre de la configuración" 
              />
              <InputError :message="$page.props?.errors.key" class="mt-2" />
            </div>

            <!-- Campo Valor (Value) -->
            <div>
              <InputLabel for="value" value="Valor *" class="dar:text-gray-300" />
              <input 
                id="value"
                v-model="form.value" 
                type="text" 
                autocomplete="off" 
                required 
                class="mt-1 block w-full border-gray-300 dar:border-gray-700 dar:bg-gray-900 dar:text-gray-300 focus:border-indigo-500 dar:focus:border-indigo-600 focus:ring-indigo-500 dar:focus:ring-indigo-600 rounded-md shadow-sm"
                placeholder="Escribe el valor de la configuración" 
              />
              <InputError :message="$page.props?.errors.value" class="mt-2" />
            </div>

            <!-- Botón de Enviar -->
            <div class="flex justify-end pt-4">
              <PrimaryButton :disabled="form.processing">
                Agregar
              </PrimaryButton>
            </div>
          </form>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import Back from "@/Components/Back.vue";
import { Link, useForm } from "@inertiajs/inertia-vue3";

export default {
  data() {
    const form = useForm({
      key: "",
      value: "",
    });
    return {
      form,
    };
  },
  components: {
    AppLayout,
    PrimaryButton,
    InputError,
    InputLabel,
    Back,
    Link,
  },
  props: {
    // No se usa 'settings' en este componente, pero se mantiene por si acaso
    settings: Array,
  },
  methods: {
    store() {
      this.form.post(this.route("settings.store"));
    },
  },
};
</script>
