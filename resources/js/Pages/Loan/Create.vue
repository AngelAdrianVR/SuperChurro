<template>
  <AppLayout title="Solicitud de préstamo">
    <template #header>
      <div class="flex items-center mt-2">
          <Back />
          <h2 class="font-semibold text-xl text-gray-800 text-center ml-5 lg:ml-28">
            Solicitud de préstamo
          </h2>
      </div>
    </template>

    <div
      class="max-w-2xl md:mx-auto mt-5 rounded-lg px-5 py-8 bg-transparent border border-gray3 mx-4"
    >
      <form @submit.prevent="store">

        <div class="mb-3 w-full">
          <InputLabel value="Cantidad solicitada *" class="ml-3 mb-1 text-sm" />
          <input v-model="form.amount" type="number" autocomplete="off" class="input"
           placeholder="$00.00" />
          <InputError :message="$page.props?.errors.amount" />
        </div>

        <div class="my-2 w-full">
          <InputLabel value="Notas o comentarios" class="ml-3 mb-1 text-sm" />
          <textarea
            v-model="form.description"
            rows="2"
            type="text"
            autocomplete="off"
            placeholder="Escribe la descripción"
            class="textarea"
          />
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
import PayRollTable from "@/Components/PayRollTable.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import Back from "@/Components/Back.vue";
import { Link, useForm } from "@inertiajs/inertia-vue3";
export default {
  data() {
    const form = useForm({
      amount: null,
      description: "",
      remaining: 0,
    });
    return {
      form,
    };
  },
  components: {
    AppLayout,
    PayRollTable,
    PrimaryButton,
    InputError,
    InputLabel,
    Back,
    Link,
  },
  props: {},
  methods: {
    store() {
      this.form.post(this.route("loans.store"));
    },
  },
};
</script>
