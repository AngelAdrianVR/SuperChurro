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

    <div v-if="loans.data.length" class="globe-container">
      <div v-for="loan in loans.data" :key="loan.id" class="globe relative">
        <div class="globe-title !justify-between">
          <p>Solicitado el: {{loan.created_at}}</p>
          <button class="absolute bottom-1 right-2" @click="delete_confirm = true; item_to_delete = loan;">
          <i v-if="loan.status == 1" class="fa-solid fa-trash text-red-600"></i>
          </button>
        </div>
          <p>Cantidad Solicitada: ${{loan.amount}}</p>
        <div class="flex flex-col">
           <p>Notas: {{ loan.description }} </p>
            <span v-if="loan.status == 1" class="text-orange-500 font-bold mt-2"><i class="fa-solid fa-hourglass-start mr-2"></i>Revisando...</span>  
            <span v-if="loan.status == 2" class="text-green-600 font-bold mt-2"><i class="fa-solid fa-check mr-2"></i>Aprobado</span>  
            <span v-if="loan.status == 3" class="text-red-600 font-bold mt-2"><i class="fa-solid fa-xmark mr-2"></i>Rechazado</span>  
            <span v-if="loan.status == 4" class="text-blue-600 font-bold mt-2"><i class="fa-solid fa-piggy-bank mr-2"></i>Abonando</span>  
            <span v-if="loan.status == 5" class="text-indigo-600 font-bold mt-2"><i class="fa-solid fa-handshake mr-2"></i>Pagado</span>  
        </div>
        <div v-if="loan.status == 1" class="flex justify-center items-center mt-1 mb-3 space-x-2">
          <PrimaryButton @click="$inertia.put(route('loan.accept',loan.id))" class="bg-green-600">Aprobar</PrimaryButton>
          <PrimaryButton @click="$inertia.put(route('loan.reject',loan.id))" class="!bg-red-600">Rechazar</PrimaryButton>
        </div>
            <div v-if="loan.payed_at" class="absolute bottom-0 right-2 text-xs text-gray-400">pagado el: {{ loan.payed_at }}</div>
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
      }
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
    loans: Object,
  },
  methods: {
    
},
};
</script>
