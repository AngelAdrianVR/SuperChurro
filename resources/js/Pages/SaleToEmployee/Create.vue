<template>
  <AppLayout title="Venta a empleado">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Venta a empleado
      </h2>
    </template>

    <div class="flex justify-start">
      <Link
        :href="route('carts.index')"
        class="flex items-center mt-2 text-slate-700"
      >
        <i
          class="
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
          "
        ></i>
        <span class="ml-1 cursor-default">Atrás</span>
      </Link>
    </div>

    <!-- component -->
    <!-- This is an example component -->
    <div
      class="
        max-w-2xl
        md:mx-auto
        mt-5
        shadow-md shadow-gray-500/70
        rounded-lg
        px-5
        py-8
        bg-white
        mx-4
      "
    >
      <form @submit.prevent="store">
      <div class="flex justify-between">
      
      <select
          class="
            bg-gray-200
            w-52
            mb-3
            mr-4
            rounded-lg
            border border-gray-300
            text-gray-500
            focus:border-stone-500 focus:text-stone-500
          "
          required
          v-model="form.product_id"
        >
          <option disabled selected class="text-gray-600" value="">
            -- Seleccione el producto --
          </option>
          <option
            class="text-gray-500"
            v-for="product in products"
            :key="product.id"
            :value="product.id"
          >
            {{ product.name }}
          </option>
        </select>
        <div class="relative z-0 mb-2 w-full group">
          <input
            v-model="form.amount"
            type="number"
            step="0.1"
            name="floating_amount"
            autocomplete="off"
            required
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
            for="floating_amount"
            class="
              absolute
              text-sm text-gray-500
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
            >Cantidad*</label
          >
          <InputError :message="$page.props?.errors.amount" />
        </div>
        </div>
        
        <div class="flex justify-center lg:justify-end mb-4">
          <SecondaryButton :disabled="form.processing">+</SecondaryButton>
        </div>

        <div class="flex justify-center lg:justify-end">
          <PrimaryButton :disabled="form.processing">Solicitar</PrimaryButton>
        </div>
      </form>
    </div>
  </AppLayout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import InputError from "@/Components/InputError.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
export default {
  data() {
    const form = useForm({
      product_id: null,
      amount: null,
    });
    return {
      form,
    };
  },
  components: {
    AppLayout,
    Link,
    useForm,
    PrimaryButton,
    InputError,
    SecondaryButton,
  },
  props: {
    products: Array,
  },
  methods: {
    store() {
      this.form.post(this.route("product-request.store"));
    },
  },
};
</script>