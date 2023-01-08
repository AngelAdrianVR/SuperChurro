<template>
  <AppLayout title="Préstamos">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Préstamos
      </h2>
    </template>

      <div class="mt-2 bg-sky-100 border-t-4 border-sky-500 rounded-b text-sky-900 px-4 py-3 shadow-md" role="alert">
  <div class="flex">
    <div class="py-1"><svg class="fill-current h-6 w-6 text-sky-500 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"/></svg></div>
    <div>
      <p class="font-bold">ATENCIÓN</p>
      <p class="text-sm">Los préstamos se pagan vía nómina y se liquidan en un plazo de 2 semanas.
Si ya tienes un préstamo activo, no podrás solicitar otro.</p>
    </div>
  </div>
</div>

    <div class="flex justify-end">
      <Link :href="route('loans.create')">
      <SecondaryButton class="mr-7 my-5">Solicitar Préstamo</SecondaryButton>
      </Link>
    </div>

    <div class="globe-container">
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
