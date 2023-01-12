<template>
  <AppLayout title="Venta a empleado">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Venta a empleado
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
        px-4
        pt-5
        pb-4
        bg-white
        mx-4
      ">
      <form @submit.prevent="submit">
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
        }
      ],
    })
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
      this.form.post(route('sells-to-employees.store'));
    },
  },
};
</script>