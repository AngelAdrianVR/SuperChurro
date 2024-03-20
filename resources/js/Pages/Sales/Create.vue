<template>
  <AppLayout title="Corte">
    <template #header>
      <div class="flex items-center mt-2">
        <Back />
        <h2 class="font-semibold text-xl text-gray-800 text-center ml-5 lg:ml-28">
          Hacer corte
        </h2>
      </div>
    </template>

    <div class="mt-2 bg-amber-100 border-t-4 border-[teal-500] rounded-b text-amber-900 px-4 py-3 shadow-md"
      role="alert">
      <div class="flex">
        <div class="py-1"><svg class="fill-current h-6 w-6 text-amber-500 mr-4" xmlns="http://www.w3.org/2000/svg"
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

    <div class="
        max-w-2xl
        md:mx-auto
        mt-5
        rounded-lg
        px-5
        py-8
        bg-transparent
        mx-4
        border border-gray3
      ">
      <form @submit.prevent="store">
        <InputErrors v-if="form.hasErrors" :errors="form.errors" class="mb-3" />
        <div class="grid grid-cols-2 gap-2">
          <div v-for="product in products" :key="product.id" class="mb-1 w-full">
            <InputLabel :value="product.name" class="ml-3 mb-1 text-sm" />
            <input v-model="form.product[product.id]" type="number" min="0"
              autocomplete="off" required class="input" placeholder="Anota el sobrante" />
          </div>
        </div>

        <div class="my-2 w-full">
          <InputLabel value="Comentarios u observaciones" class="ml-3 mb-1 text-sm" />
          <textarea
            v-model="form.notes"
            rows="2"
            type="text"
            autocomplete="off"
            class="textarea"
          />
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
import InputLabel from "@/Components/InputLabel.vue";
import Back from "@/Components/Back.vue";
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
    PrimaryButton,
    InputErrors,
    SecondaryButton,
    InputLabel,
    Back,
    Link,
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