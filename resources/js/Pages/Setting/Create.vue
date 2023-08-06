<template>
  <AppLayout title="Nueva Configuracion">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Nueva Configuración
      </h2>
    </template>

    <div class="flex justify-start">
      <Link
        :href="route('settings.index')"
        class="flex items-center mt-2 text-secondary"
      >
        <i
          class="
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
          "
        ></i>
        <span class="ml-1 cursor-default">Atrás</span>
      </Link>
    </div>


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
        <div class="relative z-0 mb-6 w-full group">
          <input
            v-model="form.key"
            type="text"
            name="floating_key"
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
              dark:text-gray-700 dark:border-gray-600 dark:focus:border-stone-500
              focus:outline-none focus:ring-0 focus:border-stone-600
              peer
            "
            placeholder=" "
          />
          <label
            for="key"
            class="
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
            "
            >Nombre de la configuración*</label
          >
          <InputError :message="$page.props?.errors.key" />
        </div>
        <div class="relative z-0 mb-6 w-full group">
          <input
            v-model="form.value"
            type="text"
            name="floating_value"
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
              dark:text-gray-700 dark:border-gray-600 dark:focus:border-stone-500
              focus:outline-none focus:ring-0 focus:border-stone-600
              peer
            "
            placeholder=" "
          />
          <label
            for="floating_description"
            class="
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
            "
            >Valor*</label
          >
          <InputError :message="$page.props?.errors.key" />
        </div>
        <div class="flex justify-center lg:justify-end">
          <PrimaryButton :disabled="form.processing">Agregar</PrimaryButton>
        </div>
      </form>
    </div>

  </AppLayout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { Link, useForm } from "@inertiajs/inertia-vue3";
import InputError from "@/Components/InputError.vue";
export default {
  data() {
    const form = useForm({
      key: "",
      value: "",
    });
    return {
        form,
      }
  },
  components: {
    AppLayout,
    PrimaryButton,
    Link,
    InputError,
  },
  props: {
settings: Array,
  },
  methods: {
    store() {
      this.form.post(this.route("settings.store"));
    },
},
};
</script>
