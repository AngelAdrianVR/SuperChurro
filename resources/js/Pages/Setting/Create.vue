<template>
  <AppLayout title="Nueva Configuracion">
    <template #header>
      <div class="flex items-center mt-2">
        <Back />
        <h2 class="font-semibold text-xl text-gray-800 text-center ml-5 lg:ml-28">
          Nueva configuración
        </h2>
      </div>
    </template>

    <div
      class="
        max-w-2xl
        md:mx-auto
        mt-5
        rounded-lg
        px-5
        py-8
        bg-transparent
        border border-gray3
        mx-4
      "
    >
      <form @submit.prevent="store">
        <div class="relative z-0 mb-6 w-full group">

        <div class="mb-3 w-full">
          <InputLabel value="Nombre *" class="ml-3 mb-1 text-sm" />
          <input v-model="form.key" type="text" autocomplete="off" required class="input"
          placeholder="Escribe el nombre del colaborador" />
          <InputError :message="$page.props?.errors.key" />
        </div>

        <div class="mb-3 w-full">
          <InputLabel value="Valor *" class="ml-3 mb-1 text-sm" />
          <input v-model="form.value" type="text" autocomplete="off" required class="input"
          placeholder="Escribe el nombre del colaborador" />
          <InputError :message="$page.props?.errors.value" />
        </div>

        <div class="flex justify-center lg:justify-end">
          <PrimaryButton :disabled="form.processing">Agregar</PrimaryButton>
        </div>
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
    InputError,
    InputLabel,
    Back,
    Link
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
