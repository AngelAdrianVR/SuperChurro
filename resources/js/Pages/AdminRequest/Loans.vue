<template>
  <AppLayout title="Solicitudes">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
        Préstamos
      </h2>
    </template>

    <div v-if="loans.data.length" class="globe-container">
      <div v-for="loan in loans.data" :key="loan.id" class="globe relative">
        <div class="globe-title !justify-center">
          <i class="fa-regular fa-circle-user mr-2"></i><p class="text-sm">{{loan.user.name}}</p>
          <button class="absolute bottom-1 right-2" @click="delete_confirm = true; item_to_delete = loan;">
          <i v-if="loan.status == 1" class="fa-solid fa-trash text-red-600"></i>
          </button>
        </div>
          <p><strong>Cantidad Solicitada: </strong> ${{loan.amount}}</p>
        <div class="flex flex-col">
           <p><strong> Notas: </strong>{{ loan.description }} </p>
           <p><strong>Saldo restante: </strong>${{ loan.remaining }} </p>
            <span v-if="loan.remaining == loan.amount && !loan.authorized_at" class="text-orange-500 font-bold mt-2"><i class="fa-solid fa-hourglass-start mr-2"></i>Revisando...</span>  
            <span v-else-if="(loan.amount <= loan.remaining) && loan.authorized_at && loan.remaining != 0" class="text-green-500 font-bold mt-2"><i class="fa-solid fa-check mr-2"></i>Aprobado</span>  
            <span v-else-if="loan.remaining == 0 && !loan.authorized_at" class="text-red-500 font-bold mt-2"><i class="fa-solid fa-xmark mr-2"></i>Rechazado</span>  
            <span v-else-if="loan.remaining == 0 && loan.authorized_at" class="text-indigo-500 font-bold mt-2"><i class="fa-solid fa-handshake mr-2"></i>Pagado</span>  
        </div>
        <p class="text-xs text-gray-500 mt-3">Solicitado el: {{loan.created_at}}</p>
        <div v-if="loan.remaining == loan.amount && !loan.authorized_at" class="flex justify-center items-center mt-1 mb-3 space-x-2">
          <PrimaryButton @click="$inertia.put(route('loan.accept',loan.id))" class="bg-green-400">Aprobar</PrimaryButton>
          <PrimaryButton @click="$inertia.put(route('loan.reject',loan.id))" class="!bg-red-400">Rechazar</PrimaryButton>
        </div>
            <!-- <div v-if="loan.payed_at" class="absolute bottom-0 right-2 text-xs text-gray-400">pagado el: {{ loan.payed_at }}</div> -->
      </div>
    </div>

    <div v-else class="text-center">    
          <p>No hay información para mostrar</p>
    </div>

    <Pagination class="py-5" :pagination="loans" />

  </AppLayout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import ConfirmationModal from "@/Components/ConfirmationModal.vue";
import Pagination from "@/Components/Pagination.vue";
import { Link } from "@inertiajs/inertia-vue3";
export default {
  data() {
    return {
      }
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
    loans: Object,
  },
  methods: {
    
},
};
</script>
