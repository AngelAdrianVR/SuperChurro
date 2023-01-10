<template>
  <AppLayout title="Permutas">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Permutas
      </h2>
    </template>

    <div class="flex items-center justify-between ml-4">
      <div class="relative z-0 mb-6 w-1/2 mt-7">
        <input
          v-model="form.date"
          type="date"
          name="floating_date"
          autocomplete="off"
          class="
            block
            py-2.5
            px-0
            w-full
            text-sm text-gray-900
            bg-transparent
            border-0 border-b-2 border-gray-300
            appearance-none
            dark:text-white dark:border-gray-600 dark:focus:border-stone-500
            focus:outline-none focus:ring-0 focus:border-stone-600
            peer
          "
          placeholder=" "
        />
        <label
          for="floating_date"
          class="
            absolute
            text-gray-500
            dark:text-gray-400
            duration-300
            transform
            -translate-y-6
            scale-75
            top-3
            -z-10
            origin-[0]
            peer-focus:left-0
            peer-focus:text-stone-600
            peer-focus:dark:text-stone-500
            peer-placeholder-shown:scale-100
            peer-placeholder-shown:translate-y-0
            peer-focus:scale-75 peer-focus:-translate-y-6
          "
          >Fecha de permuta</label
        >
      </div>

      <SecondaryButton @click="store" class="mr-7 mt-4"
        >Publicar</SecondaryButton
      >
    </div>

    <div v-if="barters.data.length" class="globe-container">
      <div v-for="barter in barters.data" :key="barter.id" class="globe relative">
        <div class="globe-title !justify-between">
          <div class="flex flex-col text-left">
            <p>
              Permuta para el {{ barter.date }} -
              {{ $page.props.user.employee_properties?.shifts }}
            </p>
            <small class="text-gray-500"
              >Publicado el {{ barter.created_at }}</small
            >
          </div>
          <button class="absolute bottom-1 right-2"
            @click="
              delete_confirm = true;
              item_to_delete = barter;
            "
          >
            <i
              v-if="barter.status == 1"
              class="fa-solid fa-trash text-red-600"
            ></i>
          </button>
        </div>
        <div class="text-center font-bold">
          <span v-if="barter.status == 1" class="text-orange-600 mt-2 text-xs">
            <i class="fa-solid fa-hourglass-start mr-2"></i>Esperando
            interesada(a).
          </span>
          <span v-if="barter.status == 2" class="text-green-600 mt-2 text-xs">
            <i class="fa-solid fa-check mr-2"></i>Aceptada por:
            {{ barter.receptor?.name }}.
          </span>
          <span v-if="barter.status == 3" class="text-red-600 mt-2 text-xs">
            <i class="fa-solid fa-xmark mr-2"></i>Expiró.
          </span>
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
          Estás a punto de eliminar una publicación de permuta. Una vez realizado
          ya no se podrá recuperar y la permuta quedará cancelada.
        </div>
      </template>
      <template #footer>
        <div class="flex justify-end">
          <button
            @click="this.delete()"
            class="
              px-2
              py-1
              font-semibold
              border
              rounded
              border-red-500
              text-red-500
              hover:bg-red-500 hover:text-white
              transition
              duration-200
              mr-2
            "
          >
            Eliminar
          </button>
          <button
            class="
              px-2
              py-1
              font-semibold
              border
              rounded
              border-gray-500
              text-gray-500
              hover:bg-gray-100
              transition
              duration-200
            "
            @click="delete_confirm = false"
          >
            Cancelar
          </button>
        </div>
      </template>
    </ConfirmationModal>
  </AppLayout>
</template>
  
<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import PayRollTable from "@/Components/PayRollTable.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
import ConfirmationModal from "@/Components/ConfirmationModal.vue";
export default {
  data() {
    const form = useForm({
      date: null,
    });
    return {
      form,
      delete_confirm: false,
      item_to_delete: {},
    };
  },
  components: {
    AppLayout,
    PayRollTable,
    SecondaryButton,
    Link,
    useForm,
    ConfirmationModal,
  },
  props: {
    barters: Object,
  },
  methods: {
    store() {
      this.form.post(this.route("barters.store"));
    },
    delete() {
      this.$inertia.delete(this.route("barters.destroy", this.item_to_delete));
      this.delete_confirm = false;
    },
  },
};
</script>
  