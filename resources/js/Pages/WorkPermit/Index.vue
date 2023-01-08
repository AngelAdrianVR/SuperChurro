<template>
  <AppLayout title="Permisos">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Permisos
      </h2>
    </template>

    <div class="flex justify-end">
      <Link :href="route('work-permits.create')">
      <SecondaryButton class="mr-7 my-5">Solicitar Permiso</SecondaryButton>
      </Link>
    </div>

    <div class="globe-container">
      <div v-for="work_permit in work_permits.data" :key="work_permit.id" class="globe relative">
        <div class="globe-title !justify-between">
          <p>Fecha requerida: {{work_permit.date}}</p>
          <button class="absolute bottom-1 right-2" @click="delete_confirm = true; item_to_delete = work_permit;">
          <i v-if="work_permit.status == 1" class="fa-solid fa-trash text-red-600"></i>
          </button>
        </div>
        <div class="flex flex-col">
           <p>Notas: {{ work_permit.description }} </p>
            <span v-if="work_permit.status == 1" class="text-orange-500 font-bold mt-2"><i class="fa-solid fa-hourglass-start mr-2"></i>Revisando...</span>  
            <span v-if="work_permit.status == 2" class="text-green-600 font-bold mt-2"><i class="fa-solid fa-check mr-2"></i>Aprobado</span>  
            <span v-if="work_permit.status == 3" class="text-red-600 font-bold mt-2"><i class="fa-solid fa-xmark mr-2"></i>Rechazado</span>  
        </div>
        <div class="absolute bottom-0 left-2 text-xs text-gray-400">Creado el: {{ work_permit.created_at }}</div>
      </div>
    </div>

    <ConfirmationModal :show="delete_confirm" @close="delete_confirm = false">
    <template #title>
      <div>¿Deseas continuar?</div>
    </template>
    <template #content>
      <div>
        Estás a punto de eliminar una solicitud de permiso. Una vez realizado ya no se podrá
        recuperar y la oslicitud queda´ra cancelada.
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
      }
  },
  components: {
    AppLayout,
    SecondaryButton,
    Link,
    ConfirmationModal,
  },
  props: {
    work_permits: Object,
  },
  methods: {
       delete() {
      this.$inertia.delete(
        this.route("work-permits.destroy", this.item_to_delete)
      );
      this.delete_confirm = false;
  },
},
};
</script>
