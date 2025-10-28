<template>
  <AppLayout title="Administración de poductos">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 dar:text-gray-200 leading-tight text-center">
        Administración de poductos
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        
        <!-- Botón de Agregar Producto -->
        <div class="flex justify-end mb-6 px-4 sm:px-0">
          <Link :href="route('products.create')">
            <PrimaryButton>
              <i class="fa-solid fa-plus mr-2"></i> Agregar producto
            </PrimaryButton>
          </Link>
        </div>

        <!-- Tarjeta de Lista de Productos -->
        <div class="bg-white dar:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
          <div class="flex flex-col divide-y divide-gray-200 dar:divide-gray-700">
            
            <!-- Item de Producto -->
            <div 
              v-for="product in products.data" 
              :key="product.id"
              class="p-4 sm:p-6 grid grid-cols-1 md:grid-cols-4 gap-6 relative group"
            >
              <!-- Imagen del Producto -->
              <Link :href="route('products.edit', product.id)" class="md:col-span-1">
                <figure class="h-32 w-full rounded-lg bg-gray-50 dar:bg-gray-700 p-1">
                  <img 
                    v-if="product.media[0]?.original_url"
                    :src="product.media[0]?.original_url" 
                    alt="Imagen del producto"
                    class="h-full w-full rounded-md object-contain"
                  >
                  <!-- Placeholder si no hay imagen -->
                  <div v-else class="h-full w-full flex items-center justify-center text-gray-400 dar:text-gray-500">
                    <i class="fa-solid fa-image text-4xl"></i>
                  </div>
                </figure>
              </Link>
              
              <!-- Información del Producto -->
              <div class="md:col-span-3">
                <Link :href="route('products.edit', product.id)">
                  <p class="text-lg font-medium text-indigo-600 dar:text-indigo-400 truncate">
                    {{ product.name }}
                  </p>
                </Link>
                <div class="mt-2 space-y-1 text-sm text-gray-600 dar:text-gray-400">
                  <span>Stock mínimo: <span class="font-medium text-gray-800 dar:text-gray-200">{{ product.low_stock }}</span></span>
                  <span class="sm:ml-4">Unidad: <span class="font-medium text-gray-800 dar:text-gray-200">{{ product.unit?.name }}</span></span>
                  <div class="flex flex-col sm:flex-row sm:space-x-4">
                    <span>Precio: <span class="font-medium text-gray-800 dar:text-gray-200">${{ product.price?.price }}</span></span>
                    <span>Precio empleados: <span class="font-medium text-gray-800 dar:text-gray-200">${{ product.employee_price?.price }}</span></span>
                  </div>
                </div>
              </div>

              <!-- Botón de Eliminar -->
              <button 
                class="absolute top-4 right-4 z-10 p-2 rounded-full text-gray-400 dar:text-gray-500 hover:text-red-500 hover:bg-red-100 dar:hover:bg-red-900 dar:hover:text-red-400 transition duration-150 ease-in-out" 
                @click="deleteConfirm = true; itemToDelete = product;"
                aria-label="Eliminar producto"
              >
                <i class="fa-regular fa-trash-can"></i>
              </button>
            </div>

            <!-- Estado Vacío -->
            <div v-if="products.data.length === 0" class="px-6 sm:px-8 py-10 text-center text-gray-500 dar:text-gray-400">
              No se encontraron productos.
            </div>
          </div>
        </div>

      </div>
    </div>

    <!-- Modal de Confirmación -->
    <ConfirmationModal :show="deleteConfirm" @close="deleteConfirm = false">
      <template #title>
        ¿Deseas continuar?
      </template>
      <template #content>
        Estás a punto de eliminar un producto. Una vez realizado ya no se podrá recuperar.
      </template>
      <template #footer>
        <div class="flex justify-end">
          <SecondaryButton @click="deleteConfirm = false">
            Cancelar
          </SecondaryButton>
          <button 
            @click="this.delete()"
            class="ml-3 inline-flex justify-center rounded-md border border-transparent bg-red-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dar:focus:ring-offset-gray-800"
            :disabled="form.processing"
          >
            Eliminar
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
import InputError from "@/Components/InputError.vue"; // Aunque no se usa en el template, se mantiene por si el modal lo necesita
import { deleteItem } from "@/dbService.js";

export default {
  data() {
    const form = useForm({}); // Formulario vacío para `form.processing`
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
    // update() no se usa en el template, se podría quitar
    // update() {
    //   this.form.put(route('products.update'));
    // },

    delete() {
      // Usar 'form' para deshabilitar el botón mientras se procesa
      this.form.delete(this.route("products.destroy", this.itemToDelete), {
        onSuccess: () => {
          // eliminar de indexedDB
          deleteItem('products', this.itemToDelete.id);

          this.deleteConfirm = false;

          this.$notify({
            title: 'Correcto',
            message: 'Producto eliminado',
            type: 'success',
          });
        },
        onError: () => {
          this.$notify({
            title: 'Error',
            message: 'No se pudo eliminar el producto',
            type: 'error',
          });
          this.deleteConfirm = false;
        }
      });
    },
  },
};
</script>

