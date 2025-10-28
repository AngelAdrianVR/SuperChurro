<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue"; // Añadido InputLabel
import Back from "@/Components/Back.vue";
import { Link, useForm } from "@inertiajs/inertia-vue3";

const form = useForm({
  name: null,
  description: null,
  amount: null,
});

const store = () => {
  form.post(route("bonuses.store"));
};
</script>

<template>
  <AppLayout title="Crear nuevo bono">
    <template #header>
      <div class="flex items-center mt-2">
        <Back />
        <h2 class="font-semibold text-xl text-gray-800 dar:text-gray-200 text-center ml-5 lg:ml-28">
          Crear nuevo bono
        </h2>
      </div>
    </template>

    <!-- Contenedor principal modernizado con sombra y fondo -->
    <div class="max-w-2xl md:mx-auto mt-6 mx-4">
      <div class="bg-white dar:bg-gray-800 shadow-xl rounded-lg p-6">
        <form @submit.prevent="store">
          
          <div class="flex flex-col md:flex-row items-center gap-4">
            <!-- Campo de Nombre -->
            <div class="w-full group">
              <InputLabel for="name" value="Nombre *" class="mb-2" />
              <input 
                id="name"
                v-model="form.name" 
                type="text" 
                autocomplete="off" 
                class="block w-full border-gray-300 dar:border-gray-700 dar:bg-gray-900 dar:text-gray-300 focus:border-indigo-500 dar:focus:border-indigo-600 focus:ring-indigo-500 dar:focus:ring-indigo-600 rounded-md shadow-sm"
                placeholder="Escribe el nombre del bono" 
              />
              <InputError :message="$page.props?.errors.name" class="mt-2" />
            </div>

            <!-- Campo de Cantidad -->
            <div class="w-full md:w-1/3 group">
              <InputLabel for="amount" value="Cantidad *" class="mb-2" />
              <input 
                id="amount"
                v-model="form.amount" 
                type="number" 
                autocomplete="off" 
                min="0" 
                placeholder="$00.00" 
                class="block w-full border-gray-300 dar:border-gray-700 dar:bg-gray-900 dar:text-gray-300 focus:border-indigo-500 dar:focus:border-indigo-600 focus:ring-indigo-500 dar:focus:ring-indigo-600 rounded-md shadow-sm" 
              />
              <InputError :message="$page.props?.errors.amount" class="mt-2" />
            </div>
          </div>

          <!-- Campo de Descripción -->
          <div class="mt-4 w-full">
            <InputLabel for="description" value="Descripción" class="mb-2" />
            <textarea 
              id="description"
              v-model="form.description" 
              rows="3" 
              type="text" 
              autocomplete="off" 
              placeholder="Escribe la descripción"
              class="block w-full border-gray-300 dar:border-gray-700 dar:bg-gray-900 dar:text-gray-300 focus:border-indigo-500 dar:focus:border-indigo-600 focus:ring-indigo-500 dar:focus:ring-indigo-600 rounded-md shadow-sm"
            />
            <InputError :message="$page.props?.errors.description" class="mt-2" />
          </div>

          <!-- Botón de Guardar -->
          <div class="flex justify-start mt-6">
            <PrimaryButton :disabled="form.processing">Guardar</PrimaryButton>
          </div>
        </form>
      </div>
    </div>
  </AppLayout>
</template>
