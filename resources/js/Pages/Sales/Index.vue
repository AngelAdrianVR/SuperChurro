<template>
  <AppLayout title="Historial de ventas">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
        Historial de ventas
      </h2>
    </template>

    <div class="mx-3 my-4 lg:w-1/3 lg:mx-auto">
      <label class="text-gray-500 text-sm">Selecciona la fecha para ver las ventas</label>
      <Datepicker v-model="date" inline auto-apply :month-change-on-scroll="false" model-type="yyyy-MM-dd"></Datepicker>
    </div>

    <div v-if="shift_1_sales.length || shift_2_sales.length">
      <div class="mx-3 text-xs grid grid-cols-2 lg:grid-cols-4 gap-1 bg-primary-gray shadow-md rounded-md px-2 py-1">
        <h1 class="col-span-full text-center text-sm font-bold">Venta mensual acumulada</h1>
        <p>
          Ventas: ${{ numberFormat(totalMonthSale().month_sales + totalMonthSale().to_employees) }} <br>
          <span>registrado en caja: ${{ numberFormat(month_stored_cash) }}</span> <br>
          <span v-html="monthSaleDiff()"></span>
        </p>
      </div>

      <div class="mt-3 mx-3 text-xs grid grid-cols-2 lg:grid-cols-4 gap-1 bg-primary-gray shadow-md rounded-md px-2 py-1">
        <h1 class="col-span-full text-center text-sm font-bold">Empleados activos este día</h1>
        <p v-for="(employee, index) in employees" :key="index">
          <i class="fa-solid fa-user text-gray-500"></i>
          {{ employee.name }}
        </p>
      </div>

      <div class="mt-3 mx-3 text-xs grid grid-cols-2 lg:grid-cols-4 gap-1 bg-primary-gray shadow-md rounded-md px-2 py-1">
        <h1 class="col-span-full text-center text-sm font-bold">Ventas T/M</h1>
        <p v-for="sale in shift_1_sales" :key="sale.id">
          {{ sale.product.name }} x{{ sale.quantity }}
          <i class="fa-solid fa-arrow-right-long text-[#8cbe71]"></i>
          ${{ sale.price * sale.quantity }}
          <i @click="editSale(sale)" class="fa-solid fa-pencil text-blue-400 text-xs cursor-pointer ml-1"></i>
        </p>
        <strong class="col-span-full text-right">Total: ${{ totalSale().shift_1 }}</strong>
      </div>

      <div class="mt-3 mx-3 text-xs grid grid-cols-2 lg:grid-cols-4 gap-1 bg-primary-gray shadow-md rounded-md px-2 py-1">
        <h1 class="col-span-full text-center text-sm font-bold">Ventas T/V</h1>
        <p v-for="sale in shift_2_sales" :key="sale.id">
          {{ sale.product.name }} x{{ sale.quantity }}
          <i class="fa-solid fa-arrow-right-long text-[#8cbe71]"></i>
          ${{ sale.price * sale.quantity }}
          <i @click="editSale(sale)" class="fa-solid fa-pencil text-blue-400 text-xs cursor-pointer ml-1"></i>
        </p>
        <strong class="col-span-full text-right">Total: ${{ totalSale().shift_2 }}</strong>
      </div>

      <div class="mt-3 mx-3 text-xs lg:grid lg:grid-cols-2 gap-1 bg-primary-gray shadow-md rounded-md px-2 py-1">
        <h1 class="col-span-full text-center text-sm font-bold">Ventas a empleados / cortesías</h1>
        <p v-for="sale in sales_to_employees" :key="sale.id">
          <span class="bg-sky-200"><i class="fa-solid fa-user mr-1"></i> {{ sale.user?.name }}:</span>
          {{ sale.product.name }} x{{ sale.quantity }}
          <i class="fa-solid fa-arrow-right-long text-[#8cbe71]"></i>
          ${{ sale.price * sale.quantity }}
          {{ sale.notes ? '(Cortesías: ' + sale.notes + ')' : '' }}
        </p>
        <p class="font-bold col-span-full text-right">Total: ${{ totalSale().to_employees }}</p>
      </div>

      <div class="flex justify-between mt-3">
        <div v-if="!stored_cash.length" class="relative z-0 w-1/2 group mx-4">
          <input v-model="cash" type="text" name="floating_cash" autocomplete="off" required class="
                block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-400 appearance-none dark:text-gray-700 dark:border-gray-600 dark:focus:border-stone-500 focus:outline-none focus:ring-0 focus:border-stone-600 peer
              " placeholder=" " />
          <label for="floating_cash" class="
                absolute
                text-sm text-gray-500
                dark:text-gray-700
                duration-300
                transform
                -translate-y-6
                scale-75
                top-3
                -z-10
                origin-[0]
                peer-focus:left-0
                peer-focus:text-stone-600
                peer-focus:dark:text-stone-500
                peer-placeholder-shown:scale-100
                peer-placeholder-shown:translate-y-0
                peer-focus:scale-75 peer-focus:-translate-y-6
              ">Cantidad total en caja</label>
          <SecondaryButton @click="storeCash" class="ml-3 my-2" :disabled="!cash">Guardar</SecondaryButton>
        </div>
        <div v-if="edit_stored_cash" class="relative z-0 w-1/2 group mx-4">
          <input v-model="cash" type="text" name="floating_cash" autocomplete="off" required class="
                block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-400 appearance-none dark:text-gray-700 dark:border-gray-600 dark:focus:border-stone-500 focus:outline-none focus:ring-0 focus:border-stone-600 peer
              " placeholder=" " />
          <label for="floating_cash" class="
                absolute
                text-sm text-gray-500
                dark:text-gray-700
                duration-300
                transform
                -translate-y-6
                scale-75
                top-3
                -z-10
                origin-[0]
                peer-focus:left-0
                peer-focus:text-stone-600
                peer-focus:dark:text-stone-500
                peer-placeholder-shown:scale-100
                peer-placeholder-shown:translate-y-0
                peer-focus:scale-75 peer-focus:-translate-y-6
              ">Cantidad total en caja</label>
          <SecondaryButton @click="updateCash" class="ml-3 my-2" :disabled="!cash">Actualizar</SecondaryButton>
        </div>
        <div class="flex flex-col items-end">
          <p class="mx-3 font-bold text-green-600">Total: ${{
            totalSale().shift_1 + totalSale().shift_2 +
            totalSale().to_employees
          }}</p>
          <div v-if="stored_cash.length" class="flex justify-between items-center cursor-pointer pl-2">
            <i @click="edit_stored_cash = true" class="fa-solid fa-pencil text-blue-600"></i>
            <p class="mx-3 font-bold text-green-600">registrado en caja: ${{ stored_cash[0].cash }}</p>
          </div>
          <p v-if="stored_cash.length" v-html="saleDiff()"></p>
          <p class="mx-3 font-bold text-green-600">Comisión: ${{ totalSale().commissions }}</p>
        </div>
      </div>
    </div>
    <p v-else class="mt-6 text-sm text-gray-500 text-center">No hay ventas para mostrar</p>

    <DialogModal :show="show_edit_sale_modal" @close="show_edit_sale_modal = false">
      <template #title>
        Editar venta <span class="text-sky-600 font-bold">{{ edit_sale.product.name }}</span>
      </template>
      <template #content>
          <div class="relative z-0 mb-6 w-full group">
            <input v-model="form.quantity" type="number" name="floating_time_requested" autocomplete="off" required class="
                block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-400 appearance-none dark:text-gray-700 dark:border-gray-600 dark:focus:border-stone-500 focus:outline-none focus:ring-0 focus:border-stone-600 peer
              " placeholder=" " />
            <label for="floating_name" class="
                absolute
                text-sm text-gray-500
                dark:text-gray-700
                duration-300
                transform
                -translate-y-6
                scale-75
                top-3
                -z-10
                origin-[0]
                peer-focus:left-0
                peer-focus:text-stone-600
                peer-focus:dark:text-stone-500
                peer-placeholder-shown:scale-100
                peer-placeholder-shown:translate-y-0
                peer-focus:scale-75 peer-focus:-translate-y-6
              ">Cantidad *</label>
          </div>
      </template>
      <template #footer>
        <SecondaryButton @click="show_edit_sale_modal = false">Cancelar</SecondaryButton>
        <PrimaryButton @click="updateSale" class="ml-2" :disabled="form.processing">Guardar</PrimaryButton>
      </template>
    </DialogModal>
  </AppLayout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import DialogModal from "@/Components/DialogModal.vue";
import { Link, useForm } from "@inertiajs/inertia-vue3";
import Datepicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css';

export default {
  data() {
    const form = useForm({
      quantity: null,
    });
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
      form,
    }
  },
  components: {
    AppLayout,
    SecondaryButton,
    PrimaryButton,
    Link,
    Datepicker,
    DialogModal,
  },
  props: {
    products: Array,
    churro_price: Number,
  },
  watch: {
    date(newDate, oldDate) {
      this.getSales(newDate);
      this.getMonthSale(newDate);
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
        this.employees = response.data.employees;
        this.sales_to_employees = response.data.sales_to_employees;
        this.stored_cash = response.data.stored_cash;
        this.showing_monthly_sales = false;
      } catch (error) {
        console.log(error);
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

      // this.shift_1_sales[0]: churro price at the moment of sale
      const churros_sold = ((shift_1 + shift_2 + to_employees) / (this.shift_1_sales[0].price)) + 5;
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
        ? '<span class="text-green-600 font-bold">Diferencia + $' + diff + '</span>'
        : '<span class="text-red-600">Diferencia $' + diff + '</span>';
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
      return number.toString().replace(exp, rep);
    }, 
    editSale(sale) {
      this.edit_sale = sale;
      this.form.quantity = sale.quantity;
      this.show_edit_sale_modal = true;
    },
    updateSale() {
      this.form.put(route('sales.update', this.edit_sale.id), {
        onSuccess: () => {
          this.show_edit_sale_modal = false;
          let sale = this.shift_1_sales.find(item => this.edit_sale.id === item.id);
          if (!sale)
            sale = this.shift_2_sales.find(item => this.edit_sale.id === item.id);
          
          sale.quantity = this.form.quantity;
        },
      });
    }
  },
};
</script>
