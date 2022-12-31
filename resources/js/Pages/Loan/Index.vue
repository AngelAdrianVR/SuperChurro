<template>
  <AppLayout title="Préstamos">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Préstamos
      </h2>
    </template>

    <div class="flex justify-end">
      <Link :href="route('loans.create')">
      <SecondaryButton class="mr-7 my-5">Solicitar Préstamo</SecondaryButton>
      </Link>
    </div>

    <div class="globe-container">
      <div v-for="loan in loans.data" :key="loan.id" class="globe relative">
        <div class="globe-title !justify-between">
          <p>Solicitado el: {{loan.created_at}}</p>
          <button @click="delete_confirm = true; item_to_delete = loan;">
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
            <div v-if="loan.payed_at" class="absolute bottom-0 right-2 text-xs text-gray-400">pagado el: {{ loan.payed_at }}</div>
      </div>
    </div>

    <ConfirmationModal :show="delete_confirm" @close="delete_confirm = false">
    <template #title>
      <div>¿Deseas continuar?</div>
    </template>
    <template #content>
      <div>
        Estás a punto de eliminar una solicitud de préstamo. Una vez realizado ya no se podrá
        recuperar y la solicitud quedará cancelada.
      </div>
    </template>
    <template #footer>
      <div class="flex justify-end">
        <button @click="this.delete()" class="px-2 py-1 font-semibold border rounded border-red-500 text-red-500 hover:bg-red-500 hover:text-white transition duration-200 mr-2">Eliminar</button>
        <button class="px-2 py-1 font-semibold border rounded border-gray-500 text-gray-500 hover:bg-gray-100 transition duration-200" @click="delete_confirm = false">
          Cancelar
        </button>
      </div>
    </template>
  </ConfirmationModal>
  </AppLayout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import { Link } from "@inertiajs/inertia-vue3";
import ConfirmationModal from "@/Components/ConfirmationModal.vue";
export default {
  data() {
    return {
      delete_confirm: false,
      item_to_delete: {},
    };
  },
  components: {
    AppLayout,
    ConfirmationModal,
    SecondaryButton,
    Link,
  },
  props: {
    loans: Object,
  },
  methods: {
       delete() {
      this.$inertia.delete(
        this.route("loans.destroy", this.item_to_delete)
      );
      this.delete_confirm = false;
  },
  },
};
</script>
