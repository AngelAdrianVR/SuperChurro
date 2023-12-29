<template>
    <AppLayout title="Editar bono">
      <template #header>
        <div class="flex items-center mt-2">
          <Back />
          <h2 class="font-semibold text-xl text-gray-800 text-center ml-5 lg:ml-28">
            Editar bono
          </h2>
      </div>
      </template>
    
      <div
        class="max-w-2xl md:mx-auto mt-5  rounded-lg px-5 py-4 bg-transparent border border-gray3 mx-4 my-2"
      >
        <form @submit.prevent="update">

          <div class="flex items-center space-x-2">
            <div class="mb-3 w-full group">
              <InputLabel value="Nombre *" class="ml-3 mb-1 text-sm" />
              <input v-model="form.name" type="text" autocomplete="off" class="input"
              placeholder="Escribe el nombre del bono" />
              <InputError :message="$page.props?.errors.name" />
            </div>

            <div class="mb-3 w-1/3 group">
              <InputLabel value="Cantidad *" class="ml-3 mb-1 text-sm" />
              <input v-model="form.amount" type="number" autocomplete="off" min="0" placeholder="$00,0" class="input" />
              <InputError :message="$page.props?.errors.amount" />
            </div>
          </div>

          <div class="my-2 w-full">
            <InputLabel value="Descripción" class="ml-3 mb-1 text-sm" />
            <textarea
              v-model="form.notes"
              rows="2"
              type="text"
              autocomplete="off"
              placeholder="Escribe la descripción"
              class="textarea"
            />
          </div>

          <div class="flex justify-start mt-4">
            <PrimaryButton :disabled="form.processing">Actualizar</PrimaryButton>
          </div>
        </form>
      </div>  
    </AppLayout>
  </template>
  
  <script>
  import AppLayout from "@/Layouts/AppLayout.vue";
  import PrimaryButton from "@/Components/PrimaryButton.vue";
  import InputError from "@/Components/InputError.vue";
  import Back from "@/Components/Back.vue";
  import InputLabel from "@/Components/InputLabel.vue";
  import { Link, useForm } from "@inertiajs/inertia-vue3";
  
  export default {
    data() {
      const form = useForm({
        name: this.bonus.name,
        description: this.bonus.description,
        amount: this.bonus.amount,
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
      Link,
    },
    props: {
      bonus: Object,
    },
    methods: {
      update() {
        this.form.put(this.route("bonuses.update", this.bonus.id));
      },
    },
  };
  </script>
  