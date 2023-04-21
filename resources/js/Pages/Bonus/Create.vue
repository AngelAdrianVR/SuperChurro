<template>
  <AppLayout title="Crear nuevo bono">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Crear nuevo bono
      </h2>
    </template>

    <div class="flex justify-start">
      <Link :href="route('bonuses.index')" class="flex items-center mt-2 text-slate-700">
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

    <!-- component -->
    <!-- This is an example component -->
    <div class="
          max-w-2xl
          md:mx-auto
          mt-5
          shadow-md shadow-gray-500/70
          rounded-lg
          px-5
          py-8
          bg-white
          mx-4
          my-2
        ">
      <form @submit.prevent="store">
        <div class="relative z-0 mb-6 w-full group">
          <input v-model="form.name" type="text" name="floating_name" autocomplete="off" required class="
                block
                py-2.5
                px-0
                w-full
                text-sm text-gray-900
                bg-transparent
                border-0 border-b-2 border-gray-300
                appearance-none
                dark:text-gray-700 dark:border-gray-600 dark:focus:border-stone-500
                focus:outline-none focus:ring-0 focus:border-stone-600
                peer
              " placeholder=" " />
          <label for="floating_name" class="
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
              ">Nombre*</label>
          <InputError :message="$page.props?.errors.name" />
        </div>
        <div class="relative z-0 mb-6 w-full group">
          <input v-model="form.description" type="text" name="floating_description" autocomplete="off" class="
                block
                py-2.5
                px-0
                w-full
                text-sm text-gray-900
                bg-transparent
                border-0 border-b-2 border-gray-300
                appearance-none
                dark:text-gray-700 dark:border-gray-600 dark:focus:border-stone-500
                focus:outline-none focus:ring-0 focus:border-stone-600
                peer
              " placeholder=" " />
          <label for="floating_description" class="
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
              ">Descripción*</label>
          <InputError :message="$page.props?.errors.desciption" />
        </div>
        <div class="relative z-0 mb-6 w-full group">
          <input v-model="form.amount" type="number" step="0.1" name="floating_amount" autocomplete="off" class="
                block
                py-2.5
                px-0
                w-full
                text-sm text-gray-900
                bg-transparent
                border-0 border-b-2 border-gray-300
                appearance-none
                dark:text-gray-700 dark:border-gray-600 dark:focus:border-stone-500
                focus:outline-none focus:ring-0 focus:border-stone-600
                peer
              " placeholder=" " />
          <label for="floating_amount" class="
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
              ">Cantidad*</label>
          <InputError :message="$page.props?.errors.description" />
        </div>
        <div class="flex justify-center lg:justify-end">
          <PrimaryButton :disabled="form.processing">Crear</PrimaryButton>
        </div>
      </form>
    </div>
  </AppLayout>
</template>
  
<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputError from "@/Components/InputError.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import { Link, useForm } from "@inertiajs/inertia-vue3";
export default {
  data() {
    const form = useForm({
      name: null,
      description: null,
      amount: null,
    });
    return {
      form,
    };
  },
  components: {
    AppLayout,
    Link,
    PrimaryButton,
    InputError,
    SecondaryButton,
  },
  props: {

  },
  methods: {
    store() {
      this.form.post(this.route("bonuses.store"));
    },
  },
};
</script>