<template>
  <AppLayout title="Venta a empleado / cortesias">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
        Venta a empleado / cortesias
      </h2>
    </template>

    <div class="flex justify-start">
      <Link :href="route('carts.index')" class="flex items-center mt-2 text-secondary">
        <i
          class="fa-solid fa-angle-left text-lg hover:bg-gray-300 bg-opacity-100 rounded-full w-7 h-7 pl-1 ml-5"
        ></i>
        <span class="ml-1 cursor-default">Atrás</span>
      </Link>
    </div>

    <div
      class="max-w-2xl md:mx-auto mt-5 shadow-md shadow-gray-500/70 rounded-lg px-4 pt-5 pb-4 bg-primary-gray mx-4"
    >
      <form @submit.prevent="submit">
        <div>
          <div class="flex items-center mb-4">
            <div class="flex items-center mr-3">
              <input
                v-model="form.is_sell_to_employee"
                id="sell-option-1"
                type="radio"
                name="sell_type"
                value="1"
                class="h-4 w-4 border-gray-400 focus:ring-2 focus:ring-blue-300 bg-transparent"
                aria-labelledby="sell-option-1"
                aria-describedby="sell-option-1"
                checked=""
              />
              <label
                for="sell-option-1"
                class="text-sm font-medium text-gray-900 ml-2 block"
              >
                Venta a empleado
              </label>
            </div>
            <div class="flex items-center">
              <input
                v-model="form.is_sell_to_employee"
                id="sell-option-2"
                type="radio"
                name="sell_type"
                value="0"
                class="h-4 w-4 border-gray-400 focus:ring-2 focus:ring-blue-300 bg-transparent"
                aria-labelledby="sell-option-2"
                aria-describedby="sell-option-2"
              />
              <label
                for="sell-option-2"
                class="text-sm font-medium text-gray-900 ml-2 block"
              >
                Cortesías
              </label>
            </div>
          </div>
        </div>
        <div>
          <ProductInput
            :products="products"
            show_price
            v-for="(item, index) in form.items"
            :key="item.id"
            :id="item.id"
            @deleteItem="deleteItem(index)"
            @syncItem="syncItems(index, $event)"
            class="mb-5"
          />
        </div>
        <p v-if="!form.items.length" class="text-sm text-gray-600">
          Click al botón de "+" para empezar a agregar productos
        </p>
        <div class="my-2 text-center">
          <button type="button" @click="addNewItem">
            <i class="fa-solid fa-circle-plus text-2xl text-[#ABD196]"></i>
          </button>
        </div>
        <div v-if="form.is_sell_to_employee == 0" class="relative z-0 mb-6 w-full group">
          <textarea
            v-model="form.notes"
            rows="1"
            type="text"
            name="floating_description"
            autocomplete="off"
            class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-gray-700 dark:border-gray-600 dark:focus:border-stone-500 focus:outline-none focus:ring-0 focus:border-stone-600 peer"
            placeholder=" "
          />
          <label
            for="floating_description"
            class="absolute text-sm text-gray-500 dark:text-gray-700 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-stone-600 peer-focus:dark:text-stone-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
            >Notas o comentarios (para quién(es) son las cortesías)</label
          >
        </div>

        <PrimaryButton :disabled="form.processing">Solicitar</PrimaryButton>
      </form>
    </div>
  </AppLayout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import ProductInput from "@/Components/ProductInput.vue";
import InputError from "@/Components/InputError.vue";
import { Link, useForm } from "@inertiajs/inertia-vue3";
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
      is_sell_to_employee: 1,
      notes: null,
    });
    return {
      next_item_id: 2,
      form,
    };
  },
  components: {
    AppLayout,
    Link,
    PrimaryButton,
    InputError,
    ProductInput,
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
    submit() {
      this.form.post(route("sales-to-employees.store"));
    },
  },
};
</script>
