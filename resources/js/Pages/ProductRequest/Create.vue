<template>
  <AppLayout title="Solicitar mercancía">
    <template #header>
      <div class="flex items-center mt-2">
        <Back />
        <h2 class="font-semibold text-xl text-gray-800 text-center ml-5 lg:ml-28">
          Solicitud de mercancía
        </h2>
      </div>
    </template>

    <div class="max-w-lg md:mx-auto mt-5 rounded-lg px-5 pt-4 pb-5 border border-gray3 bg-transparent mx-4">
      <div class="flex justify-end mb-3">
        <SecondaryButton @click="updateWarehouseProducts" :disabled="updating" class="!h-6 !flex !items-center !justify-center space-x-2 !text-black">
          <span>Sincronizar mercancia de cocina</span>
          <i class="fa-solid fa-arrows-rotate"></i>
        </SecondaryButton>
      </div>
      <p v-if="validation_message" class="text-red-400 text-xs mb-2" v-html="validation_message"></p>
      <form @submit.prevent="store">
        <div>
          <ProductInput :products="products" v-for="(item, index) in form.items" :key="item.id" :id="item.id"
            @deleteItem="deleteItem(index)" @syncItem="syncItems(index, $event)" class="mb-1" />
        </div>
        <p v-if="!form.items.length" class="text-sm text-gray-600">
          Click al botón de "+" para empezar a agregar productos
        </p>
        <div class="mt-2 mb-6 text-left">
          <button class="text-primary text-sm" type="button" @click="addNewItem">
            <i class="fa-solid fa-plus"></i>
            Agregar producto
          </button>
        </div>
        <PrimaryButton :disabled="form.processing">Solicitar</PrimaryButton>
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
        const available_quantity = this.warehouse_stock[product.product_id];
        if (available_quantity < product.quantity) {

          this.validation_message += `- Sólo hay disponible <strong>${available_quantity}</strong> unidades del producto <strong>` +
            this.products.find(item => item.id == product.product_id).name + '</strong> en cocina</br>';

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
