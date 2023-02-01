<template>
  <AppLayout title="Remover productos">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Remover producto(s)
      </h2>
    </template>

    <div class="flex justify-start">
      <Link :href="route('carts.index')" class="flex items-center mt-2 text-slate-700">
      <i class="
            fas
            fa-long-arrow-alt-left
            text-lg
            active:bg-gray-300
            bg-opacity-100
            rounded-full
            w-7
            h-7
            pl-1
            ml-2
          "></i>
      <span class="ml-1 cursor-default">Atrás</span>
      </Link>
    </div>

    <div class="
        max-w-2xl
        md:mx-auto
        mt-5
        shadow-md shadow-gray-500/70
        rounded-lg
        px-5
        pt-4
        pb-5
        bg-white
        mx-4
      ">
      <p v-if="validation_message" class="text-red-400 text-xs mb-2" v-html="validation_message"></p>
      <form @submit.prevent="store">
        <InputLabel value="Concepto" />
        <select class="
            mb-3
            mr-2
            rounded-lg
            border
            text-gray-500
            focus:border-stone-500 focus:text-stone-500
          " v-model="form.concept">
          <option disabled selected class="text-gray-500" value="">
            -- Selecciona concepto --
          </option>
          <option v-for="(concept, index) in concepts" :key="index" class="text-gray-500" :value="concept">
            {{ concept }}
          </option>
        </select>
        <div>
          <ProductInput :products="products" v-for="(item, index) in form.items" :key="item.id" :id="item.id"
            @deleteItem="deleteItem(index)" @syncItem="syncItems(index, $event)" class="mb-5" />
        </div>
        <p v-if="!form.items.length" class="text-sm text-gray-600"> Click al botón de "+" para empezar a agregar
          productos </p>
        <div class="my-2 text-center">
          <button type="button" @click="addNewItem">
            <i class="fa-solid fa-circle-plus text-2xl text-blue-400"></i>
          </button>
        </div>
        <PrimaryButton :disabled="form.processing">Remover de carrito</PrimaryButton>
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
import InputLabel from "@/Components/InputLabel.vue";
import { Link, useForm } from "@inertiajs/inertia-vue3";

export default {
  data() {
    const form = useForm({
      items: [
        {
          id: 1,
          product_id: null,
          quantity: null,
        }
      ],
      concept: "",
    })
    return {
      validation_message: "",
      next_item_id: 2,
      form,
      concepts: [
        'Producto en mal estado',
        'Devolución a cocina'
      ],
    };
  },
  components: {
    AppLayout,
    Link,
    PrimaryButton,
    InputError,
    SecondaryButton,
    ProductInput,
    InputLabel,
  },
  props: {
    products: Array,
    cart_stock: Object,
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
        this.form.post(this.route("cart.store-removed-products"));
      }
    },
    quantityValidated() {
      this.validation_message = "";
      this.form.items.forEach(product => {
        const available_quantity = this.cart_stock[product.product_id];
        if (available_quantity < product.quantity) {
          this.validation_message += `- Sólo hay disponible <strong>${available_quantity}</strong> unidades del producto <strong>` +
            this.products.find(item => item.id == product.product_id).name + '</strong> en carrito</br>';
        }
      });
    },
  },
};
</script>