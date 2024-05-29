<template>
<LoadingIndicator v-if="loading" />
  <AppLayout title="Historial de ventas">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
        Ventas
      </h2>
    </template>

    <div class="mx-3 my-4 lg:w-1/3 lg:mx-auto">
      <label class="text-gray-500 text-sm">Selecciona la fecha para ver las ventas</label>
      <Datepicker v-model="date" inline auto-apply :month-change-on-scroll="false" model-type="yyyy-MM-dd"></Datepicker>
    </div>

    <div v-if="shift_1_sales.length || shift_2_sales.length">
      <div class="mx-3 text-xs grid grid-cols-2 lg:grid-cols-4 gap-1 bg-transparent rounded-md px-2 py-1">
        <h1 class="col-span-full text-left text-sm font-bold">Venta mensual acumulada</h1>
        <p class="ml-4">
          Ventas: ${{ numberFormat(totalMonthSale().month_sales + totalMonthSale().to_employees) }} <br>
          <span>registrado en caja: ${{ numberFormat(month_stored_cash) }}</span> <br>
          <span v-html="monthSaleDiff()"></span>
        </p>
      </div>

      <div class="border-b border-gray3 border-dashed mx-2 my-3"></div>

      <!------------------------------ Empleados de ese día -------------------------- -->
      <div class="mt-3 mx-3 text-xs grid grid-cols-2 lg:grid-cols-4 gap-1 bg-transparent rounded-md px-2 py-1">
        <h1 class="col-span-full text-center text-sm font-bold mb-4">Empleados activos este día </h1>
        <div v-for="(employee, index) in employees" :key="index">
          <div class="rounded-md border border-gray3 flex items-center py-2 px-3">
            <i class="fa-regular fa-user-circle text-gray-500 text-lg mr-2"></i>
            <p>{{ employee.name }}</p>
          </div>
        </div>
      </div>
      <!-- ---------------------------------------------------------------------------- -->

      <div class="border-b border-gray3 border-dashed mx-2 my-3"></div>

      <!-- ----------------- Ventas T/M --------------------------------- -->
      <div class="mt-3 mx-3 text-xs rounded-md px-2 py-1">
        <h1 class="col-span-full text-left text-sm font-bold mb-4">Ventas turno matutino</h1>

        <SaleTable :shiftSales="shift_1_sales" />

        <div class="flex justify-end">
          <p class="font-bold bg-[#F2FEA8] px-4 py-2 mt-4">Total: ${{ (totalSale().shift_1).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",") }}</p>
        </div>
      </div>
      <!-- ----------------------------------------------------------------- -->

      <div class="border-b border-gray3 border-dashed mx-2 my-3"></div>

      <!-- ----------------- Ventas T/V --------------------------------- -->
      <div class="mt-3 mx-3 text-xs rounded-md px-2 py-1">
        <h1 class="col-span-full text-center text-sm font-bold mb-4">Ventas turno vespertino</h1>

        <SaleTable :shiftSales="shift_2_sales" />

        <div class="flex justify-end">
          <p class="font-bold bg-[#F2FEA8] px-4 py-2 mt-4">Total: ${{ (totalSale().shift_2).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",") }}</p>
        </div>
      </div>
      <!-- ----------------------------------------------------------------- -->

      <div class="border-b border-gray3 border-dashed mx-2 my-3"></div>

      <!-- Ventas a empleados y cortesías ---------------------------- -->
      <div class="mt-3 mx-3 text-xs lg:grid lg:grid-cols-2 gap-2 bg-transparent rounded-md px-2 py-1">
        <h1 class="col-span-full text-left text-sm font-bold mb-4">Ventas a empleados / cortesías</h1>

        <div class="border border-gray3 rounded-md px-3 py-2" v-for="sale in sales_to_employees" :key="sale.id">
          <div class="flex items-center mb-3">
            <i class="fa-regular fa-user-circle text-gray-500 text-lg mr-2"></i>
            <p class="text-sm">{{ sale.user?.name }}</p>
          </div>
          <div class="grid grid-cols-6 gap-1">
            <p class="font-bold col-span-2">Producto</p>
            <p class="font-bold">Tipo</p>
            <p class="font-bold">Canidad</p>
            <p class="font-bold">Total</p>
            <p class="font-bold">Motivo</p>

            <p class="col-span-2">{{ sale.product.name }}</p>
            <p>{{ sale.price == 0 ? 'C' : 'VE' }}</p>
            <p>{{ sale.quantity }}</p>
            <p>${{ (sale.price * sale.quantity)?.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",") }}</p>
            <p>{{ sale.price == 0 ? sale.notes : '' }}</p>
            
          </div>
        </div>
        <div class="flex justify-end self-end">
          <p class="font-bold bg-[#F2FEA8] px-4 py-2 mt-4">Total: ${{ (totalSale().to_employees).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",") }}</p>
        </div>
      </div>
      <!-- -------------------------------------------------------------------- -->


      <!-- Venta total del día ------------------- -->
      <div class="flex justify-end my-3 mx-4">

        <div v-if="!stored_cash.length" class="mb-3 w-full">
          <InputLabel value="Cantidad total en caja *" class="ml-3 mb-1 text-sm" />
          <input v-model="cash" type="number" autocomplete="off" required class="input"
           placeholder="$00.0" />
           <PrimaryButton @click="storeCash" class="ml-3 my-2" :disabled="!cash">Guardar</PrimaryButton>
        </div>

        <div v-if="edit_stored_cash" class="mb-3 w-full">
          <InputLabel value="Cantidad total en caja *" class="ml-3 mb-1 text-sm" />
          <input v-model="cash" type="number" autocomplete="off" required class="input"
           placeholder="$00.0" />
           <CancelButton @click="edit_stored_cash = false" class="ml-3 my-2 !rounded-full">Cancelar</CancelButton>
           <PrimaryButton @click="updateCash" class="ml-3 my-2" :disabled="!cash">Actualizar</PrimaryButton>
        </div>

        <div class="flex flex-col items-end text-sm">
          <p class="mx-3 font-bold text-gray-700 mr-6">Total del sistema: ${{
            (totalSale().shift_1 + totalSale().shift_2 + totalSale().to_employees)?.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",")}}
          </p>
          <div v-if="stored_cash.length && !edit_stored_cash" class="flex justify-between items-center cursor-pointer pl-2">
            <p class="mx-3 font-bold text-gray-700">Registrado en caja: ${{ (stored_cash[0].cash)?.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",") }}</p>
            <i v-if="!edit_stored_cash" @click="edit_stored_cash = true" class="fa-solid fa-pencil text-primary text-xs"></i>
          </div>
          <p v-if="stored_cash.length" v-html="saleDiff()"></p>
          <p class="mx-3 font-bold text-gray-700 mr-6 text-sm">Comisión: ${{ totalSale().commissions }}</p>
        </div>
      </div>
    </div>
    <p v-else class="mt-6 text-sm text-gray-500 text-center">No hay ventas para mostrar</p>

  </AppLayout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import CancelButton from "@/Components/CancelButton.vue";
import SaleTable from "@/Components/MyComponents/Sale/SaleTable.vue";
import LoadingIndicator from "@/Components/MyComponents/LoadingIndicator.vue";
import Datepicker from '@vuepic/vue-datepicker';
import InputLabel from "@/Components/InputLabel.vue";
import { Link } from "@inertiajs/inertia-vue3";
import '@vuepic/vue-datepicker/dist/main.css';

export default {
  data() {

    return {
      date: null,
      shift_1_sales: [],
      month_sales: [],
      shift_2_sales: [],
      sales_to_employees: [],
      stored_cash: null,
      month_stored_cash: null,
      cash: null,
      employees: [],
      edit_stored_cash: false,
      show_edit_sale_modal: false,
      edit_sale: null,
      loading: false,
    }
  },
  components: {
    AppLayout,
    PrimaryButton,
    CancelButton,
    Datepicker,
    InputLabel,
    LoadingIndicator,
    SaleTable,
    Link,
  },
  props: {
  },
  watch: {
    date(newDate, oldDate) {
      this.getSales(newDate);
      this.getMonthSale(newDate);
    },
  },
  methods: {
    async getSales(date) {
      this.loading = true;
      this.shift_1_sales = [];
      this.shift_2_sales = [];
      this.employees = null;
      this.sales_to_employees = null;
      this.stored_cash = null;
      try {
        const response = await axios.post(route("sales.get-sales-by-date"), {
          date: date,
        });
        if (response.status === 200) {

          if(response.data.shift_1_sales?.length > 0 || response.data.shift_2_sales?.length > 0) {

            this.shift_1_sales = response.data.shift_1_sales;
            this.shift_2_sales = response.data.shift_2_sales;
            this.employees = response.data.employees;
            this.sales_to_employees = response.data.sales_to_employees;
            this.stored_cash = response.data.stored_cash;
            this.showing_monthly_sales = false;

          } else {
            this.$notify({
            title: "Sin ventas",
            message: "No se encontraron ventas en este día",
            type: "warning",
          });
          }
        }

      } catch (error) {
        console.log(error);
        this.$notify({
            title: "Algo salió mal",
            message: "No se pudo cargar la venta. Intenta más tarde",
            type: "error",
          });
      } finally {
        this.loading = false;
      }
    },
    async getMonthSale(date) {
      try {
        const response = await axios.post(route("sales.get-month-sale"), {
          date: date,
        });
        this.month_sales = response.data.month_sales;
        this.month_sales_to_employees = response.data.month_sales_to_employees;
        this.month_stored_cash = response.data.month_stored_cash;
      } catch (error) {
        console.log(error);
      }
    },
    totalSale() {
      let shift_1 = 0, shift_2 = 0, to_employees = 0, commissions;
      this.shift_1_sales.forEach(sale => shift_1 += (sale.quantity * sale.price));
      this.shift_2_sales.forEach(sale => shift_2 += (sale.quantity * sale.price));
      this.sales_to_employees.forEach(sale => to_employees += (sale.quantity * sale.price));

      // reference_price: churro price at the moment of sale
      const reference_price = this.shift_1_sales[0]?.price ?? this.shift_2_sales[0]?.price  
      const churros_sold = ((shift_1 + shift_2 + to_employees) / (reference_price)) + 5;
      commissions = Math.floor(churros_sold / 100) * 10;

      return { shift_1: shift_1, shift_2: shift_2, to_employees: to_employees, commissions: commissions };
    },
    totalMonthSale() {
      let month_sales = 0, to_employees = 0, commissions;
      let churros_sold;
      this.month_sales.forEach(sale => month_sales += (sale.quantity * sale.price));
      this.sales_to_employees.forEach(sale => to_employees += (sale.quantity * sale.price));

      // this.shift_1_sales[0]: churro price at the moment of sale
      if (this.shift_1_sales.length) {
        churros_sold = ((month_sales + to_employees) / (this.shift_1_sales[0]?.price)) + 5;
      }
      else {
        churros_sold = ((month_sales + to_employees) / (this.shift_2_sales[0]?.price)) + 5;
      }

      commissions = Math.floor(churros_sold / 100) * 10;

      return { month_sales: month_sales, to_employees: to_employees, commissions: commissions };
    },
    saleDiff() {
      const total_sale = this.totalSale();
      const total = total_sale.shift_1
        + total_sale.shift_2
        + total_sale.to_employees;

      const diff = this.stored_cash[0].cash - total;

      return diff > 0
        ? '<span class="text-green-500 text-sm mr-6 font-bold">Diferencia + $' + diff + '</span>'
        : '<span class="text-red-500 text-sm mr-6">Diferencia $' + diff + '</span>';
    },
    monthSaleDiff() {
      const total_sale = this.totalMonthSale();
      const total = total_sale.month_sales
        + total_sale.to_employees;

      const diff = this.numberFormat(this.month_stored_cash - total);

      return diff > 0
        ? '<span class="text-green-600 font-bold">Diferencia + $' + diff + '</span>'
        : '<span class="text-red-600">Diferencia $' + diff + '</span>';
    },
    async storeCash() {
      try {
        const response = await axios.post(route("cash-register.store"), {
          cash: this.cash,
          date: this.date
        });
        this.getSales(this.date);
      } catch (error) {
        console.log(error);
      }
    },
    async updateCash() {
      try {
        const response = await axios.post(route("cash-register.update"), {
          cash: this.cash,
          date: this.date
        });
        this.getSales(this.date);
        this.edit_stored_cash = false;
      } catch (error) {
        console.log(error);
      }
    },
    numberFormat(number) {
      const exp = /(\d)(?=(\d{3})+(?!\d))/g;
      const rep = '$1,';
      return number?.toString().replace(exp, rep);
    }, 
    editSale(sale) {
      this.edit_sale = sale;
      this.form.quantity = sale.quantity;
      this.show_edit_sale_modal = true;
    },
  },
};
</script>
