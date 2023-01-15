<template>
  <AppLayout title="Solicitudes">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Solicitudes de Empleados
      </h2>
    </template>

    <div class="my-4 border-b border-gray-300">
      <Tabs :tabs="tabs" />
    </div>

    <div v-if="work_permits.data.length" class="globe-container">
      <div v-for="work_permit in work_permits.data" :key="work_permit.id" class="globe relative">
        <div class="globe-title !justify-between">
          <p>Fecha requerida: {{work_permit.date}}</p>
          <button class="absolute bottom-1 right-2" @click="delete_confirm = true; item_to_delete = work_permit;">
          <i v-if="work_permit.status == 1" class="fa-solid fa-trash text-red-600"></i>
          </button>
        </div>
        <div class="flex flex-col mb-2">
          <p ><strong> Tipo de permiso: </strong>{{permission_type_name[work_permit.permission_type_id - 1]}}</p>
          <p v-if="work_permit.permission_type_id == 1 || work_permit.permission_type_id == 2 "><strong>Tiempo requerido: </strong>{{work_permit.time_requested}} hr(s)</p>
           <p><strong>Notas: </strong>{{ work_permit.description }} </p>
            <span v-if="work_permit.status == 1" class="text-orange-500 font-bold mt-2"><i class="fa-solid fa-hourglass-start mr-2"></i>Revisando...</span>  
            <span v-if="work_permit.status == 2" class="text-green-600 font-bold mt-2"><i class="fa-solid fa-check mr-2"></i>Aprobado</span>  
            <span v-if="work_permit.status == 3" class="text-red-600 font-bold mt-2"><i class="fa-solid fa-xmark mr-2"></i>Rechazado</span>  
        </div>
        <div v-if="work_permit.status == 1" class="flex justify-center items-center mt-1 mb-3 space-x-2">
          <PrimaryButton @click="$inertia.put(route('work-permit.accept',work_permit.id))" class="bg-green-600">Aprobar</PrimaryButton>
          <PrimaryButton @click="$inertia.put(route('work-permit.reject',work_permit.id))" class="!bg-red-600">Rechazar</PrimaryButton>
        </div>
        <div class="absolute bottom-0 left-2 text-xs text-gray-400">Creado el: {{ work_permit.created_at }}</div>
      </div>
    </div>

    <div v-else class="text-center">    
          <p>No hay información para mostrar.</p>
    </div>

  </AppLayout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { Link } from "@inertiajs/inertia-vue3";
import ConfirmationModal from "@/Components/ConfirmationModal.vue";
import Tabs from "@/Components/Tabs.vue";
export default {
  data() {
    return {
      permission_type_name: [
        'Llegada tarde',
        'Salida temprano',
        'Día de vacaciones',
        'Permiso sin goce',
      ],
      tabs: [
        {
          label: "Permisos",
          url: "admin-requests.permits",
        },
        {
          label: "Préstamos",
          url: "admin-requests.loans",
        },
      ],
    };
  },
  components: {
    AppLayout,
    SecondaryButton,
    Link,
    ConfirmationModal,
    Tabs,
    PrimaryButton,
  },
  props: {
    work_permits: Object,
  },
  methods: {},
};
</script>
