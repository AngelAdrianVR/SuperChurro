<template>
  <AppLayout title="Crear aviso">
    <template #header>
      <div class="flex items-center mt-2">
          <Back />
          <h2 class="font-semibold text-xl text-gray-800 text-center ml-5 lg:ml-28">
            Crear aviso
          </h2>
      </div>
    </template>

    <div
      class="max-w-2xl md:mx-auto mt-5 rounded-lg px-5 py-8 bg-transparent border border-gray3 mx-4"
    >
      <form @submit.prevent="store">

        <div class="mb-3 w-full">
          <InputLabel value="Título de aviso *" class="ml-3 mb-1 text-sm" />
          <input v-model="form.title" type="text" autocomplete="off" class="input"
           placeholder="Escribe el título del aviso" required />
          <InputError :message="$page.props?.errors.title" />
        </div>

        <div class="my-2 w-full">
          <InputLabel value="Contenido del aviso" class="ml-3 mb-1 text-sm" />
          <textarea
            v-model="form.content"
            required
            rows="3"
            type="text"
            autocomplete="off"
            placeholder="Escribe el aviso"
            class="textarea"
          />
        </div>

        <div class="flex justify-center lg:justify-end">
          <PrimaryButton>Publicar aviso</PrimaryButton>
        </div>
      </form>
    </div>
  </AppLayout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import Back from "@/Components/Back.vue";
import { Link, useForm } from "@inertiajs/inertia-vue3";

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
    PrimaryButton,
    InputError,
    InputLabel,
    Back,
    Link
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
