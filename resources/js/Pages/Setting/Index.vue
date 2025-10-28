<template>
  <AppLayout title="Configuraciones">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 dar:text-gray-200 leading-tight">
        Configuraciones de administrador
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        
        <!-- Botón de Nueva Configuración -->
        <div class="flex justify-end mb-6 px-4 sm:px-0">
          <Link :href="route('settings.create')">
            <PrimaryButton>Nueva configuración</PrimaryButton>
          </Link>
        </div>

        <!-- Tarjeta de Configuraciones -->
        <div class="bg-white dar:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
          <div class="p-6 sm:px-8 bg-white dar:bg-gray-800 border-b border-gray-200 dar:border-gray-700">
            <h3 class="text-lg font-medium text-gray-900 dar:text-gray-100">
              Configuraciones generales
            </h3>
          </div>

          <!-- Lista de Configuraciones -->
          <div class="flex flex-col divide-y divide-gray-200 dar:divide-gray-700">
            <div
              v-for="setting in settings"
              :key="setting.id"
              class="px-6 sm:px-8 py-4 flex flex-col sm:flex-row justify-between items-start sm:items-center space-y-2 sm:space-y-0"
            >
              <p class="font-medium text-gray-900 dar:text-gray-100 w-full sm:w-1/3">
                {{ setting.key }}
              </p>
              
              <!-- El input mantiene el tipo 'number' como en el original -->
              <input 
                type="number" 
                class="block w-full sm:w-1/2 border-gray-300 dar:border-gray-700 dar:bg-gray-900 dar:text-gray-300 focus:border-indigo-500 dar:focus:border-indigo-600 focus:ring-indigo-500 dar:focus:ring-indigo-600 rounded-md shadow-sm" 
                :value="setting.value" 
                :aria-label="`Valor de ${setting.key}`"
              />
            </div>
            
            <!-- Mensaje si no hay configuraciones -->
            <div v-if="!settings || settings.length === 0" class="px-6 sm:px-8 py-6 text-center text-gray-500 dar:text-gray-400">
              No se encontraron configuraciones.
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
import { Link } from "@inertiajs/inertia-vue3";
import ConfirmationModal from "@/Components/ConfirmationModal.vue"; // Se mantiene la importación por si se usa en AppLayout

export default {
  data() {
    return {};
  },
  components: {
    AppLayout,
    PrimaryButton,
    ConfirmationModal,
    Link,
  },
  props: {
    settings: Array,
  },
  methods: {},
};
</script>
