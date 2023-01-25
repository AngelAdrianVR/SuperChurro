<template>
  <AppLayout title="Administración de poductos">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Administración de poductos
      </h2>
    </template>

    <div class="flex justify-end">
      <Link :href="route('products.create')">
      <SecondaryButton class="mr-7 my-5">Nuevo producto</SecondaryButton>
      </Link>
    </div>

    <div class="globe-container flex-col">
      <div v-for="product in products.data" :key="product.id"
        class="globe hover:bg-gray-200 cursor-pointer relative z-0">
        <Link :href="route('products.show', product.id)">
        <div class="globe-title !justify-between pb-2">
          <span class="text-gray-500"><i class="fa-solid fa-box mr-1"></i>
            {{ product.name }}</span>
        </div>
        <div class="flex flex-col">
          <span><i class="fa-solid fa-circle-dot mr-1 text-xs"></i> Stock mínimo: {{ product.low_stock }} </span>
          <span><i class="fa-solid fa-circle-dot mr-1 text-xs"></i> Unidad de medida: {{ product.unit.name }} </span>
          <span><i class="fa-solid fa-circle-dot mr-1 text-xs"></i> Precio actual: ${{ product.price.price }} </span>
          <span><i class="fa-solid fa-circle-dot mr-1 text-xs"></i> Precio a empleados: ${{ product.employee_price.price }} </span>
        </div>
        </Link>
        <!-- <button class="absolute bottom-1 right-2 z-10" @click="delete_confirm = true; item_to_delete = product;">
          <i class="fa-solid fa-trash text-red-600"></i>
        </button> -->
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
    products: Object,
  },
  methods: {
    update() {
      this.form.put(route('products.update'));
    },

    delete() {
      this.$inertia.delete(
        this.route("products.destroy", this.item_to_delete)
      );
      this.delete_confirm = false;
    },

  },
};
</script>
