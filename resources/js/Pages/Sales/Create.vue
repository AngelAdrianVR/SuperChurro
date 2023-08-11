<template>
  <AppLayout title="Corte">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
        Hacer corte
      </h2>
    </template>

    <div class="mt-2 bg-teal-100 border-t-4 border-[teal-500] rounded-b text-teal-900 px-4 py-3 shadow-md"
      role="alert">
      <div class="flex">
        <div class="py-1"><svg class="fill-current h-6 w-6 text-teal-500 mr-4" xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 20 20">
            <path
              d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z" />
          </svg></div>
        <div>
          <p class="font-bold">Atención</p>
          <p class="text-sm">Colocar el <strong>sobrante</strong> de productos en los siguientes campos:</p>
        </div>
      </div>
    </div>

    <div class="flex">
      <Link :href="route('carts.index')" class="flex items-center mt-2 text-secondary">
      <i class="
            fas
            fa-solid fa-angle-left
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
        py-8
        bg-primary-gray
        mx-4
      ">
      <form @submit.prevent="store">
        <InputErrors v-if="form.hasErrors" :errors="form.errors" class="mb-4" />
        <div class="grid grid-cols-2 gap-3">
          <div v-for="product in products" :key="product.id" class="relative z-0 mb-2 w-full group">
            <input v-model="form.product[product.id]" type="number" min="0" name="floating_churro_relleno"
              autocomplete="off" required class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-400 appearance-none dark:text-gray-700 dark:border-gray-600 dark:focus:border-stone-500 focus:outline-none focus:ring-0 focus:border-stone-600 peer
            " placeholder="" />
            <label for="floating_churro_relleno" class="
              absolute
              text-sm text-gray-500
              dark:text-gray-700
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
            ">{{ product.name }}</label>
          </div>
        </div>

        <div class="flex justify-center lg:justify-end mt-5">
          <PrimaryButton :disabled="form.processing">Hacer corte</PrimaryButton>
        </div>
      </form>
    </div>
  </AppLayout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import InputErrors from "@/Components/InputErrors.vue";
import { Link, useForm } from "@inertiajs/inertia-vue3";
export default {
  data() {
    const form = useForm({
      product: [],
    });
    return {
      form,
    };
  },
  components: {
    AppLayout,
    Link,
    PrimaryButton,
    InputErrors,
    SecondaryButton,
  },
  props: {
    products: Array,
  },
  methods: {
    store() {
      this.form.post(route("sales.store"));
    },
  },
};
</script>