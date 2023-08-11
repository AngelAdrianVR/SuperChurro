<template>
  <AppLayout title="Crear aviso">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Crear Aviso</h2>
    </template>

    <div class="flex justify-start">
      <Link
        :href="route('work-permits.index')"
        class="flex items-center mt-2 text-secondary"
      >
        <i
          class="fa-solid fa-angle-left text-lg hover:bg-gray-300 bg-opacity-100 rounded-full w-7 h-7 pl-1 ml-5"
        ></i>
        <span class="ml-1 cursor-default">Atrás</span>
      </Link>
    </div>

    <div
      class="max-w-2xl md:mx-auto mt-5 shadow-md shadow-gray-500/70 rounded-lg px-5 py-8 bg-white mx-4"
    >
      <form @submit.prevent="store">
        <div class="relative z-0 mb-6 w-full group">
          <input
            v-model="form.title"
            required
            type="text"
            name="floating_title"
            autocomplete="off"
            class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-400 appearance-none dark:text-gray-700 dark:border-gray-600 dark:focus:border-stone-500 peer"
            placeholder=" "
          />
          <label
            for="floating_title"
            class="absolute text-sm text-gray-500 dark:text-gray-700 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-stone-600 peer-focus:dark:text-stone-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
            >Título del aviso</label
          >
        </div>

        <div class="relative z-0 mb-6 w-full group">
          <textarea
            v-model="form.content"
            required
            rows="1"
            type="text"
            name="floating_content"
            autocomplete="off"
            class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-gray-700 dark:border-gray-600 dark:focus:border-stone-500 focus:outline-none focus:ring-0 focus:border-stone-600 peer"
            placeholder=" "
          />
          <label
            for="floating_content"
            class="absolute text-sm text-gray-500 dark:text-gray-700 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-stone-600 peer-focus:dark:text-stone-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
            >Contenido del aviso</label
          >
        </div>
        <div class="flex justify-center lg:justify-end">
          <PrimaryButton>Publicar Aviso</PrimaryButton>
        </div>
      </form>
    </div>
  </AppLayout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputError from "@/Components/InputError.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
export default {
  data() {
    const form = useForm({
      title: "",
      content: "",

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
  },
  props: {
    permission_types: Array,
  },
  methods: {
    store() {
      this.form.post(this.route("notices.store"));
    },
  },
};
</script>
