<template>
  <AppLayout title="Historial de ventas">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Historial de ventas
      </h2>
    </template>
    <div class="mx-3 my-4 lg:w-1/3 lg:mx-auto">
      <label class="text-gray-500 text-sm">Selecciona la fecha para ver las ventas</label>
      <Datepicker v-model="date" inline auto-apply :month-change-on-scroll="false" model-type="yyyy-MM-dd"></Datepicker>
    </div>

    <div v-for="sale in sales" :key="sale.id">
      {{ sale }}
    </div>
    <p v-if="!sales.length" class="mt-6 text-sm text-gray-500 text-center">No hay ventas para mostrar</p>

  </AppLayout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import { Link } from "@inertiajs/inertia-vue3";
import Datepicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'

export default {
  data() {
    return {
      date: null,
      sales: []
    }
  },
  components: {
    AppLayout,
    SecondaryButton,
    Link,
    Datepicker
  },
  props: {
    products: Array,
  },
  watch: {
    date(newDate, oldDate) {
      this.getSales(newDate);
    },
  },
  methods: {
    async getSales(date) {
      try {
        const response = await axios.post(route("sales.get-sales-by-date"), {
          date: date,
        });
        this.sales = response.data.sales;
      } catch (error) {
        console.log(error);
      }
    }
  },
};
</script>
