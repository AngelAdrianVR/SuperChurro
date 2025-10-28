<template>
  <AppLayout title="Solicitudes">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Permisos
      </h2>
    </template>

    <!-- Contenedor principal con padding estándar -->
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">

      <!-- Cuadrícula (Grid) responsiva para las tarjetas -->
      <div v-if="work_permits.data.length" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

        <!-- Tarjeta de Permiso -->
        <div v-for="work_permit in work_permits.data" :key="work_permit.id"
          class="bg-white rounded-lg shadow-lg overflow-hidden flex flex-col justify-between">

          <!-- Contenido principal de la tarjeta -->
          <div class="p-6">
            <div class="mb-4">
              <p class="text-lg font-semibold text-gray-900">{{ work_permit.user.name }}</p>
              <p class="text-sm text-gray-500">Fecha solicitada: {{ work_permit.date }}</p>
            </div>

            <div class="space-y-2 text-sm">
              <p><strong>Tipo:</strong> {{ permission_type_name[work_permit.permission_type_id - 1] }}</p>
              <p v-if="work_permit.permission_type_id == 1 || work_permit.permission_type_id == 2">
                <strong>Tiempo:</strong> {{ work_permit.time_requested }} minutos
              </p>
              <p v-if="work_permit.description" class="text-gray-700 bg-gray-50 p-2 rounded-md">
                <strong>Notas:</strong> {{ work_permit.description }}
              </p>
            </div>

            <!-- Badge de Estado -->
            <div class="mt-4">
              <span v-if="work_permit.status == 1"
                class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-orange-100 text-orange-600">
                <i class="fa-solid fa-hourglass-start mr-2"></i>Revisando...
              </span>
              <span v-if="work_permit.status == 2"
                class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-600">
                <i class="fa-solid fa-check mr-2"></i>Aprobado
              </span>
              <span v-if="work_permit.status == 3"
                class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-600">
                <i class="fa-solid fa-xmark mr-2"></i>Rechazado
              </span>
            </div>
          </div>

          <!-- Pie de la tarjeta (Acciones y Timestamp) -->
          <div>
            <!-- Botones de Acción -->
            <div v-if="work_permit.status == 1" class="flex justify-center items-center p-6 pt-0 space-x-2">
              <PrimaryButton @click="$inertia.put(route('work-permit.accept', work_permit.id))" class="bg-green-400 w-full justify-center">Aprobar</PrimaryButton>
              <PrimaryButton @click="$inertia.put(route('work-permit.reject', work_permit.id))" class="!bg-red-400 w-full justify-center">Rechazar</PrimaryButton>
            </div>
            <!-- Timestamp -->
            <div class="px-6 pb-4 text-xs text-gray-400 text-right">
              Solicitud creada el: {{ work_permit.created_at }}
            </div>
          </div>
        </div>
      </div>

      <!-- Mensaje si no hay datos -->
      <div v-else class="text-center text-gray-500 py-12">
        <p>No hay información para mostrar.</p>
      </div>

      <!-- Paginación -->
      <Pagination class="py-5" :pagination="work_permits" />
    </div>

  </AppLayout>
</template>

<script>
// El script se mantiene idéntico
import AppLayout from "@/Layouts/AppLayout.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import ConfirmationModal from "@/Components/ConfirmationModal.vue";
import Pagination from "@/Components/Pagination.vue";
import { Link } from "@inertiajs/inertia-vue3";
export default {
  data() {
    return {
      permission_type_name: [
        'Llegada tarde',
        'Salida temprano',
        'Día de vacaciones',
        'Permiso sin goce',
      ],
    };
  },
  components: {
    AppLayout,
    SecondaryButton,
    ConfirmationModal,
    PrimaryButton,
    Pagination,
    Link
  },
  props: {
    work_permits: Object,
  },
  methods: {},
};
</script>
