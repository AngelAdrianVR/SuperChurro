<template>
  <AppLayout title="Avisos">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
        Avisos
      </h2>
    </template>

    <div class="flex justify-end">
      <Link :href="route('notices.create')">
      <SecondaryButton class="mr-7 my-5">Crear Aviso</SecondaryButton>
      </Link>
    </div>

    <div v-if="notices.length" class="globe-container">
      <div v-for="notice in notices" :key="notice.id" class="globe relative">
        <div class="globe-title !justify-between">
          <p>{{notice.title}}</p>
          <button class="absolute bottom-1 right-2" @click="delete_confirm = true; item_to_delete = notice;">
          <i class="fa-solid fa-trash text-red-600"></i>
          </button>
        </div>
        <div class="flex flex-col mb-2">
          <p>{{notice.content}}</p>
        </div>
      </div>
    </div>

    <div v-else class="text-center">    
          <p>No hay información para mostrar.</p>
    </div>

    

    <ConfirmationModal :show="delete_confirm" @close="delete_confirm = false">
    <template #title>
      <div>¿Deseas continuar?</div>
    </template>
    <template #content>
      <div>
        Estás a punto de eliminar el aviso.
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
    notices: Array,
  },
  methods: {
       delete() {
      this.$inertia.delete(
        this.route("notices.destroy", this.item_to_delete)
      );
      this.delete_confirm = false;
  },
},
};
</script>
