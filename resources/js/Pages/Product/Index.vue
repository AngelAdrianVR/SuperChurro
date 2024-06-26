<template>
  <AppLayout title="Administración de poductos">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
        Administración de poductos
      </h2>
    </template>

    <div class="flex justify-end">
      <Link :href="route('products.create')">
      <PrimaryButton class="mr-7 my-5">Agregar producto</PrimaryButton>
      </Link>
    </div>

    <div class="globe-container flex-col">
      <div v-for="product in products.data" :key="product.id"
        class="globe grid grid-cols-2 hover:bg-gray-200 cursor-pointer relative z-0 text-sm">
        <Link :href="route('products.edit', product.id)">
        <div class="globe-title !justify-between pb-2">
          <p class="text-gray-700 font-bold">
            {{ product.name }}</p>
        </div>
        <div class="flex flex-col">
          <span>Stock mínimo: {{ product.low_stock }} </span>
          <span>Unidad de medida: {{ product.unit?.name }} </span>
          <span>Precio actual: ${{ product.price?.price }} </span>
          <span>Precio a empleados: ${{ product.employee_price?.price }} </span>
        </div>
        </Link>
        <Link :href="route('products.edit', product.id)">
        <figure v-if="product.media[0]?.original_url" class="justify-center pt-2">
          <img :src="product.media[0]?.original_url" alt="Imagen del producto"
            class="rounded-lg h-32 mx-auto object-contain">
        </figure>
        </Link>
        <button class="absolute bottom-1 right-2 z-10" @click="deleteConfirm = true; itemToDelete = product;">
          <i class="fa-regular fa-trash-can text-red-500"></i>
        </button>
      </div>
    </div>

    <ConfirmationModal :show="deleteConfirm" @close="deleteConfirm = false">
      <template #title>
        <div>¿Deseas continuar?</div>
      </template>
      <template #content>
        <div>
          Estás a punto de eliminar un producto. Una vez realizado ya no se podrá
          recuperar.
        </div>
      </template>
      <template #footer>
        <div class="flex justify-end">
          <button @click="this.delete()"
            class="px-2 py-1 font-semibold border rounded border-red-500 text-red-500 hover:bg-red-500 hover:text-white transition duration-200 mr-2">Eliminar</button>
          <button
            class="px-2 py-1 font-semibold border rounded border-gray-500 text-gray-500 hover:bg-gray-100 transition duration-200"
            @click="deleteConfirm = false">
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
import { deleteItem } from "@/dbService.js";

export default {
  data() {
    const form = useForm({

    });
    return {
      form,
      deleteConfirm: false,
      itemToDelete: {},
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
    products: Object,
  },
  methods: {
    update() {
      this.form.put(route('products.update'));
    },

    delete() {
      this.$inertia.delete(this.route("products.destroy", this.itemToDelete), {
        onSuccess: () => {
          // eliminar de indexedDB
          deleteItem('products', this.itemToDelete.id);

          this.deleteConfirm = false;

          this.$notify({
            title: 'Correcto',
            message: '',
            type: 'success',
          });
        }
      });
    },

  },
};
</script>
