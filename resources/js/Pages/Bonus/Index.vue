<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import ThirthButton from "@/Components/ThirthButton.vue"; // Mantenido como ThirthButton
import { Link } from "@inertiajs/inertia-vue3";

defineProps({
  bonuses: Array,
});
</script>

<template>
  <AppLayout title="Bonos">
    <template #header>
      <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 dar:text-gray-200 leading-tight">
          Bonos
        </h2>
        <Link :href="route('bonuses.create')">
          <PrimaryButton>Crear bono</PrimaryButton>
        </Link>
      </div>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Contenedor de Grid Moderno -->
        <div v-if="bonuses.length" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
          
          <!-- Tarjeta de Bono Modernizada -->
          <div v-for="bonus in bonuses" :key="bonus.id" class="bg-white dar:bg-gray-800 shadow-xl rounded-lg overflow-hidden flex flex-col">
            
            <!-- Contenido Principal de la Tarjeta -->
            <div class="p-6 flex-grow">
              <div class="flex justify-between items-start mb-4">
                <!-- Título -->
                <h3 class="font-semibold text-lg text-gray-900 dar:text-gray-100">
                  {{ bonus.name }}
                </h3>
                
                <!-- Badge de Estado Modernizado -->
                <span v-if="bonus.is_active" class="px-3 py-1 text-xs font-medium text-green-800 bg-green-100 dar:bg-green-900 dar:text-green-300 rounded-full">
                  Activo
                </span>
                <span v-else class="px-3 py-1 text-xs font-medium text-red-800 bg-red-100 dar:bg-red-900 dar:text-red-300 rounded-full">
                  Inactivo
                </span>
              </div>

              <!-- Detalles del Bono -->
              <div class="space-y-2 text-sm text-gray-700 dar:text-gray-400">
                <p>
                  Cantidad: <strong class="ml-2 text-gray-900 dar:text-gray-200">${{ bonus.amount }}</strong>
                </p>
                <p v-if="bonus.description">
                  Descripción: <strong class="ml-2 text-gray-900 dar:text-gray-200">{{ bonus.description }}</strong>
                </p>
              </div>
            </div>

            <!-- Pie de la Tarjeta con Acciones -->
            <div class="bg-gray-50 dar:bg-gray-700/50 px-6 py-4 flex justify-between items-center mt-4">
              <PrimaryButton @click="$inertia.get(route('bonuses.edit', bonus.id))">
                Editar
              </PrimaryButton>
              
              <ThirthButton
                v-if="bonus.is_active"
                @click="$inertia.put(route('bonuses.toggle-status', bonus))"
              >
                Marcar como inactivo
              </ThirthButton>
              
              <ThirthButton
                v-else
                @click="$inertia.put(route('bonuses.toggle-status', bonus))"
              >
                Marcar como activo
              </ThirthButton>
            </div>
          </div>
        </div>

        <!-- Mensaje de "No hay información" -->
        <div v-else class="text-center bg-white dar:bg-gray-800 shadow-xl rounded-lg p-12">
          <p class="text-gray-500 dar:text-gray-400">No hay información para mostrar</p>
        </div>
      </div>
    </div>
  </AppLayout>
</template>
