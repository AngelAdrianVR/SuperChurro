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

    <div v-if="shift_1_sales.length">
      <div
        class="mx-3 text-xs grid grid-cols-2 lg:grid-cols-4 gap-1 bg-white shadow-md rounded-md px-2 py-1">
        <h1 class="col-span-full text-center text-sm font-bold">Ventas T/M</h1>
        <p v-for="sale in shift_1_sales" :key="sale.id">
          {{ sale.product.name }} x{{ sale.quantity }}
          <i class="fa-solid fa-arrow-right-long text-green-500"></i>
          ${{ sale.price * sale.quantity }}
        </p>
        <strong class="col-span-full text-right">Total: ${{ totalSale().shift_1 }}</strong>
      </div>
  
      <div
        class="mt-3 mx-3 text-xs grid grid-cols-2 lg:grid-cols-4 gap-1 bg-white shadow-md rounded-md px-2 py-1">
        <h1 class="col-span-full text-center text-sm font-bold">Ventas T/V</h1>
        <p v-for="sale in shift_2_sales" :key="sale.id">
          {{ sale.product.name }} x{{ sale.quantity }}
          <i class="fa-solid fa-arrow-right-long text-green-500"></i>
          ${{ sale.price * sale.quantity }}
        </p>
        <strong class="col-span-full text-right">Total: ${{ totalSale().shift_2 }}</strong>
      </div>

      <div
        class="mt-3 mx-3 text-xs lg:grid lg:grid-cols-2 gap-1 bg-white shadow-md rounded-md px-2 py-1">
        <h1 class="col-span-full text-center text-sm font-bold">Ventas a empleados / cortesías</h1>
        <p v-for="sale in sales_to_employees" :key="sale.id">
          <span class="bg-sky-200"><i class="fa-solid fa-user mr-1"></i> {{ sale.user.name }}:</span>
          {{ sale.product.name }} x{{ sale.quantity }}
          <i class="fa-solid fa-arrow-right-long text-green-500"></i>
          ${{ sale.price * sale.quantity }}
          {{ sale.notes ? '(Cortesías: ' + sale.notes + ')' : ''}}
        </p>
        <p class="font-bold col-span-full text-right">Total: ${{ totalSale().to_employees }}</p>
      </div>
      
      <div class="flex flex-col items-end mt-3">
        <p class="mx-3 font-bold text-green-600">Total: ${{ totalSale().shift_1 + totalSale().shift_2 + totalSale().to_employees }}</p>
        <p class="mx-3 font-bold text-green-600">Comisión: ${{ totalSale().commissions }}</p>
      </div>
    </div>
    <p v-else class="mt-6 text-sm text-gray-500 text-center">No hay ventas para mostrar</p>

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
      shift_1_sales: [],
      shift_2_sales: [],
      sales_to_employees: [],
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
    churro_price: Number,
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
        this.shift_1_sales = response.data.shift_1_sales;
        this.shift_2_sales = response.data.shift_2_sales;
        this.sales_to_employees = response.data.sales_to_employees;
      } catch (error) {
        console.log(error);
      }
    },
    totalSale() {
      let shift_1 = 0, shift_2 = 0, to_employees = 0, commissions;
      this.shift_1_sales.forEach(sale => shift_1 += (sale.quantity * sale.price));
      this.shift_2_sales.forEach(sale => shift_2 += (sale.quantity * sale.price));
      this.sales_to_employees.forEach(sale => to_employees += (sale.quantity * sale.price));
      
      // this.shift_1_sales[0]: churro price at the moment of sale
      const churros_sold = ((shift_1 + shift_2 + to_employees) / (this.shift_1_sales[0].price)) + 5;
      commissions = Math.floor(churros_sold/100) * 10;

      return {shift_1: shift_1, shift_2: shift_2, to_employees: to_employees, commissions: commissions};
    }
  },
};
</script>
