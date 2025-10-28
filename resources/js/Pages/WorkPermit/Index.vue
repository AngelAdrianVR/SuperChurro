<template>
  <AppLayout title="Permisos">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 dar:text-gray-200 leading-tight">
        Mis Permisos
      </h2>
    </template>

    <!-- Modernized: Contenedor principal con padding y ancho máximo -->
    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        <!-- Contenedor del botón -->
        <div class="flex justify-end mb-6 px-4 sm:px-0">
          <Link :href="route('work-permits.create')">
            <PrimaryButton>Solicitar Permiso</PrimaryButton>
          </Link>
        </div>

        <!-- Modernized: Rejilla (Grid) de tarjetas para las solicitudes -->
        <div v-if="work_permits.data.length" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
          
          <!-- Modernized: Tarjeta de Permiso -->
          <div v-for="work_permit in work_permits.data" :key="work_permit.id" class="bg-white dar:bg-gray-800 shadow-lg rounded-lg overflow-hidden transition-shadow duration-300 hover:shadow-xl flex flex-col">
            
            <!-- Cabecera de la Tarjeta -->
            <div class="flex justify-between items-center p-4 border-b border-gray-200 dar:border-gray-700">
              <div>
                <p class="text-sm text-gray-500 dar:text-gray-400">Fecha Requerida</p>
                <p class="font-medium text-gray-900 dar:text-white">{{ work_permit.date }}</p>
              </div>
              
              <!-- Botón de eliminar (sólo si status == 1) -->
              <button 
                v-if="work_permit.status == 1" 
                @click="delete_confirm = true; item_to_delete = work_permit;" 
                class="text-gray-400 dar:text-gray-500 hover:text-red-500 dar:hover:text-red-400 transition duration-150"
                title="Cancelar Solicitud"
              >
                <i class="fa-solid fa-trash"></i>
              </button>
            </div>
            
            <!-- Cuerpo de la Tarjeta (con flex-grow para empujar el footer) -->
            <div class="p-5 space-y-4 flex-grow">
              <div>
                <p class="text-sm text-gray-500 dar:text-gray-400">Tipo de permiso</p>
                <p class="text-lg font-semibold text-gray-800 dar:text-gray-200">{{ permission_type_name[work_permit.permission_type_id - 1] }}</p>
              </div>

              <div v-if="work_permit.permission_type_id == 1 || work_permit.permission_type_id == 2">
                <p class="text-sm text-gray-500 dar:text-gray-400">Tiempo requerido</p>
                <p class="text-gray-700 dar:text-gray-300">{{ work_permit.time_requested }} minutos</p>
              </div>

              <div v-if="work_permit.description">
                <p class="text-sm text-gray-500 dar:text-gray-400">Notas</p>
                <p class="text-sm text-gray-700 dar:text-gray-300 italic">"{{ work_permit.description }}"</p>
              </div>

              <!-- Modernized: Insignias (Badges) de Estado -->
              <div class="pt-2">
                <span v-if="work_permit.status == 1" 
                      class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800 dar:bg-yellow-900 dar:text-yellow-200">
                  <i class="fa-solid fa-hourglass-start mr-2"></i>Revisando...
                </span>
                <span v-if="work_permit.status == 2" 
                      class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium bg-green-100 text-green-800 dar:bg-green-900 dar:text-green-200">
                  <i class="fa-solid fa-check mr-2"></i>Aprobado
                </span>
                <span v-if="work_permit.status == 3" 
                      class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium bg-red-100 text-red-800 dar:bg-red-900 dar:text-red-200">
                  <i class="fa-solid fa-xmark mr-2"></i>Rechazado
                </span>
              </div>
            </div>

            <!-- Footer de la Tarjeta -->
            <div class="p-4 bg-gray-50 dar:bg-gray-900/50 border-t border-gray-100 dar:border-gray-700">
              <p class="text-xs text-gray-500 dar:text-gray-400">Solicitado el: {{ work_permit.created_at }}</p>
            </div>
          </div>
        </div>

        <!-- Modernized: Estado vacío -->
        <div v-else class="text-center text-gray-500 dar:text-gray-400 py-16">
          <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
            <path vector-effect="non-scaling-stroke" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
          </svg>
          <h3 class="mt-2 text-sm font-medium text-gray-900 dar:text-white">No hay permisos</h3>
          <p class="mt-1 text-sm text-gray-500 dar:text-gray-400">Aún no has solicitado ningún permiso.</p>
        </div>

      </div>
    </div>

    <!-- Modal de Confirmación (Estilos de botones internos modernizados) -->
    <ConfirmationModal :show="delete_confirm" @close="delete_confirm = false">
      <template #title>
        <span class="dar:text-white">¿Deseas continuar?</span>
      </template>
      <template #content>
        <p class="dar:text-gray-300">
          Estás a punto de eliminar una solicitud de permiso. Una vez realizado ya no se podrá
          recuperar y la solicitud quedará cancelada.
        </p>
      </template>
      <template #footer>
        <div class="flex justify-end space-x-3">
          <!-- Modernized: Botón de cancelar -->
          <button @click="delete_confirm = false"
                  class="inline-flex justify-center rounded-md border border-gray-300 dar:border-gray-600 bg-white dar:bg-gray-700 px-4 py-2 text-base font-medium text-gray-700 dar:text-gray-300 shadow-sm hover:bg-gray-50 dar:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:text-sm">
            Cancelar
          </button>
          <!-- Modernized: Botón de eliminar (destructivo) -->
          <button @click="this.delete()" 
                  class="inline-flex justify-center rounded-md border border-transparent bg-red-600 px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 sm:text-sm">
            Eliminar
          </button>
        </div>
      </template>
    </ConfirmationModal>
  </AppLayout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import ConfirmationModal from "@/Components/ConfirmationModal.vue";
import { Link } from "@inertiajs/inertia-vue3";

export default {
  data() {
    return {
      delete_confirm: false,
      item_to_delete: {},
      permission_type_name: [
        'Llegada tarde',
        'Salida temprano',
        'Día de vacaciones',
        'Permiso sin goce',
      ],
    }
  },
  components: {
    AppLayout,
    PrimaryButton,
    ConfirmationModal,
    Link
  },
  props: {
    work_permits: Object,
  },
  methods: {
    delete() {
      this.$inertia.delete(
        this.route("work-permits.destroy", this.item_to_delete), {
          onFinish: () => {
            this.delete_confirm = false; // Asegurarse de cerrar el modal
          }
        }
      );
    },
  },
};
</script>

