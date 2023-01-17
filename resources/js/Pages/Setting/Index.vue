<template>
  <AppLayout title="Configuraciones">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Configuraciones de Administrador
      </h2>
    </template>

    <div class="flex justify-end">
      <Link :href="route('settings.create')">
      <SecondaryButton class="mr-7 my-5">Nueva configuración</SecondaryButton>
      </Link>
    </div>


    <div class="globe-container !flex">
      <div class="globe relative">
        <div class="globe-title">
            Configuraciones Generales
      </div>
      <div class="flex flex-col space-y-2">
        <div v-for="setting in settings" :key="setting.id" class="flex justify-between items-center">
            <p class="font-bold">{{ setting.key }}</p>
              <input type="number" class="rounded-lg w-1/2 h-7" :value="setting.value">
      </div>
      </div>
      </div>
    </div>

  </AppLayout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import { Link } from "@inertiajs/inertia-vue3";
import ConfirmationModal from "@/Components/ConfirmationModal.vue";
export default {
  data() {
    return {

      }
  },
  components: {
    AppLayout,
    SecondaryButton,
    Link,
    ConfirmationModal,
  },
  props: {
settings: Array,
  },
  methods: {
    
},
};
</script>
