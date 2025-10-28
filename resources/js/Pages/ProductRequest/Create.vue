<template>
  <!-- 
    - Añadido un fondo gris claro (bg-gray-50) para consistencia.
  -->
  <AppLayout title="Solicitar mercancía" class="bg-gray-50">
    <template #header>
      <!-- 
        - Título centrado y más prominente.
      -->
      <div class="flex items-center mt-2 w-full">
        <Back />
        <h2 class="font-semibold text-2xl text-gray-900 text-center flex-1 mr-10">
          Solicitud de mercancía
        </h2>
      </div>
    </template>

    <!-- 
      - Contenedor principal: Convertido en "tarjeta" (bg-white, rounded-xl, shadow-lg).
      - Aumentado el padding (p-8) y max-w (max-w-xl) para un look más limpio.
    -->
    <div class="max-w-xl md:mx-auto mt-8 rounded-xl shadow-lg bg-white p-6 lg:p-8 mx-4">
      <div class="flex justify-end mb-4">
        <!-- 
          - Botón de Sincronizar: Estilo más suave y moderno.
        -->
        <SecondaryButton @click="updateWarehouseProducts" :disabled="updating"
          class="!py-1 !px-3 !text-xs !rounded-full !bg-gray-100 !text-gray-700 hover:!bg-gray-200 !font-semibold !flex !items-center space-x-2">
          <span>Sincronizar mercancia</span>
          <i class="fa-solid fa-arrows-rotate" :class="{ 'animate-spin': updating }"></i>
        </SecondaryButton>
      </div>
      <!-- 
        - Mensaje de Validación: Convertido en una alerta de error más clara.
      -->
      <div v-if="validation_message" class="mb-4 bg-red-50 border border-red-300 text-red-700 text-sm rounded-md p-3">
        <p v-html="validation_message"></p>
      </div>

      <form @submit.prevent="store">
        <!-- 
          - Añadido space-y-4 para separar cada ProductInput.
        -->
        <div class="space-y-4">
          <ProductInput :products="products" v-for="(item, index) in form.items" :key="item.id" :id="item.id"
            @deleteItem="deleteItem(index)" @syncItem="syncItems(index, $event)" />
        </div>
        <!-- 
          - Estado Vacío: Más centrado y con padding.
        -->
        <p v-if="!form.items.length" class="text-sm text-gray-500 text-center py-6 border-t border-b my-4">
          Click al botón de "+" para empezar a agregar productos
        </p>

        <!-- 
          - Botón "Agregar producto": Estilo de "enlace" más moderno.
        -->
        <div class="mt-4 mb-6 text-left">
          <button
            class="flex items-center space-x-2 text-sm font-medium text-indigo-600 hover:text-indigo-500 transition-colors"
            type="button" @click="addNewItem">
            <i class="fa-solid fa-plus bg-indigo-50 p-1 rounded-full text-indigo-600"></i>
            <span>Agregar producto</span>
          </button>
        </div>

        <!-- 
          - Botón Principal: Ancho completo y estilo moderno.
        -->
        <PrimaryButton :disabled="form.processing"
          class="w-full !rounded-lg !py-3 !text-base justify-center !bg-indigo-600 hover:!bg-indigo-700">
          Solicitar
        </PrimaryButton>
      </form>
    </div>
  </AppLayout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import ProductInput from "@/Components/ProductInput.vue";
import InputError from "@/Components/InputError.vue";
import Back from "@/Components/Back.vue";
import { Link, useForm } from "@inertiajs/inertia-vue3";
import axios from "axios";
export default {
  data() {
    const form = useForm({
      items: [
        {
          id: 1,
          product_id: null,
          quantity: null,
        },
      ],
    });
    return {
      validation_message: "",
      next_item_id: 2,
      form,
      updating: false,
      warehouse_stock: [],
    };
  },
  components: {
    AppLayout,
    PrimaryButton,
    InputError,
    SecondaryButton,
    ProductInput,
    Back,
    Link,
  },
  props: {
    products: Array,
  },
  methods: {
    addNewItem() {
      this.form.items.push({ id: this.next_item_id++, product_id: null, quantity: null });
    },
    deleteItem(index) {
      if (this.form.items.length > 1) {
        this.form.items.splice(index, 1);
      }
    },
    syncItems(index, product_obj) {
      this.form.items[index] = product_obj;
    },
    store() {
      this.quantityValidated();
      if (this.validation_message == "") {
        this.form.post(this.route("product-request.store"), {
          onSuccess: () => {
            this.$notify({
              title: 'Solicitud registrada',
              message: '',
              type: 'success',
            });
          }
        });
      }
    },
    quantityValidated() {
      this.validation_message = "";
      this.form.items.forEach((product) => {
        if (product.product_id && product.quantity) { // Asegurarse de que el producto y la cantidad existan
          const available_quantity = this.warehouse_stock[product.product_id];
          if (available_quantity !== undefined && available_quantity < product.quantity) { // Comprobar que no sea undefined
            const productName = this.products.find(item => item.id == product.product_id)?.name || 'Producto desconocido';
            this.validation_message += `- Sólo hay disponible <strong>${available_quantity}</strong> unidades del producto <strong>` +
              productName + '</strong> en cocina</br>';
          }
        }
      });
    },
    async updateWarehouseProducts() {
      await this.fetchWarehouseProducts();
      this.quantityValidated();
    },
    async fetchWarehouseProducts() {
      this.updating = true;
      try {
        const response = await axios.get(route('warehouses.get-products'));

        if (response.status === 200) {
          this.warehouse_stock = response.data.item;
        }
      } catch (error) {
        console.log(error);
      } finally {
        this.updating = false;
      }
    },
  },
  async mounted() {
    await this.fetchWarehouseProducts();
  }
};
</script>
