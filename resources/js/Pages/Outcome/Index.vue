<template>
  <AppLayout title="Historial de Egresos">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Egresos
      </h2>
    </template>

    <div class="flex justify-end">
      <Link :href="route('outcomes.create')">
      <SecondaryButton class="mr-7 my-5">Agregar Egreso</SecondaryButton>
      </Link>
    </div>

    <div>
      <div class="globe-container flex-col">
        <Link :href="route('outcomes.show', outcome)" v-for="outcome in outcomes" :key="outcome.id"
          class="globe hover:bg-gray-200 cursor-pointer">
        <div class="globe-title !justify-between pb-2">
          <span class="text-gray-500"><i class="fa-solid fa-user mr-1"></i> {{ outcome[0].user.name }}</span>
        </div>
        <div class="flex justify-between items-center">
          <span> {{ outcome.length }} Concepto(s) - (click para ver)</span>
        </div>
        <div class="-mb-3 mt-3 text-right">
          <span class="text-xs text-gray-600">{{ outcome[0].created_at.split('T')[0] }}</span>
        </div>
        </Link>
        <!-- <p v-if="!outcomes.length" class="text-center text-xs text-gray-500 col-span-full">
          No hay requistros de egresos.
        </p> -->
      </div>
    </div>

   
  </AppLayout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { Link, useForm } from "@inertiajs/inertia-vue3";


export default {
  data() {
    const form = useForm({
      quantity: null,
    });
    return {
      form,
    }
  },
  components: {
    AppLayout,
    SecondaryButton,
    PrimaryButton,
    Link,
  },
  props: {
    outcomes: Object,
  },

  methods: {
    
  },
};
</script>
