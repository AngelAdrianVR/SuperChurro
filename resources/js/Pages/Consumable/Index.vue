<template>
  <AppLayout title="Administración de consumibles">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
        Administración de consumibles
      </h2>
    </template>

    <div class="flex justify-end">
      <Link :href="route('consumables.create')">
      <PrimaryButton class="mr-7 my-5">Agregar consumible</PrimaryButton>
      </Link>
    </div>

    <div class="globe-container flex-col">
      <div v-for="consumable in consumables.data" :key="consumable.id"
        class="globe grid grid-cols-2 hover:bg-gray-200 cursor-pointer relative z-0 text-sm">
        <Link :href="route('consumables.edit', consumable.id)">
        <div class="globe-title !justify-between pb-2">
          <p class="text-gray-700 font-bold">
            {{ consumable.name }}</p>
        </div>
        <div class="flex flex-col">
          <!-- <span>Stock mínimo: {{ consumable.low_stock }} </span> -->
          <span>Unidad de medida: {{ consumable.unit?.name }} </span>
        </div>
        </Link>
        <Link :href="route('consumables.edit', consumable.id)">
        <figure v-if="consumable.media[0]?.original_url" class="justify-center pt-2">
          <img :src="consumable.media[0]?.original_url" alt="Imagen del consumible"
            class="rounded-lg h-32 mx-auto object-contain">
        </figure>
        </Link>
        <button class="absolute bottom-1 right-2 z-10" @click="delete_confirm = true; item_to_delete = consumable;">
          <i class="fa-regular fa-trash-can text-red-500"></i>
        </button>
      </div>
    </div>

    <ConfirmationModal :show="delete_confirm" @close="delete_confirm = false">
      <template #title>
        <div>¿Deseas continuar?</div>
      </template>
      <template #content>
        <div>
          Estás a punto de eliminar un consumible. Una vez realizado ya no se podrá
          recuperar.
        </div>
      </template>
      <template #footer>
        <div class="flex justify-end">
          <button @click="this.delete()"
            class="px-2 py-1 font-semibold border rounded border-red-500 text-red-500 hover:bg-red-500 hover:text-white transition duration-200 mr-2">Eliminar</button>
          <button
            class="px-2 py-1 font-semibold border rounded border-gray-500 text-gray-500 hover:bg-gray-100 transition duration-200"
            @click="delete_confirm = false">
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
import ConfirmationModal from "@/Components/ConfirmationModal.vue";
import { Link, useForm } from "@inertiajs/inertia-vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputError from "@/Components/InputError.vue";

export default {
  data() {
    const form = useForm({

    });
    return {
      form,
      delete_confirm: false,
      item_to_delete: {},
    }
  },
  components: {
    AppLayout,
    SecondaryButton,
    Link,
    ConfirmationModal,
    PrimaryButton,
    InputError,
  },
  props: {
    consumables: Object,
  },
  methods: {
    delete() {
      this.$inertia.delete(this.route("consumables.destroy", this.item_to_delete), {
        onSuccess: () => {
          this.$notify({
            title: "Eliminado",
            message: "",
            type: "success",
          });
        }
      });
      this.delete_confirm = false;
    },

  },
};
</script>
