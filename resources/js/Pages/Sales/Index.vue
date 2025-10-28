<template>
<LoadingIndicator v-if="loading" />
  <AppLayout title="Historial de ventas">
    <template #header>
      <!-- MODIFICADO: Header centrado y con soporte para modo oscuro -->
      <h2 class="font-semibold text-xl text-gray-900 dar:text-gray-100 leading-tight text-center">
        Ventas
      </h2>
    </template>

    <!-- MODIFICADO: Contenedor principal para centrar y limitar el ancho -->
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
      
      <!-- MODIFICADO: Tarjeta para el Datepicker -->
      <div class=" flex flex-col items-center
          mx-4 sm:mx-0 
          mb-8 
          lg:w-1/2 
          lg:mx-auto 
          bg-white 
          dar:bg-gray-800 
          shadow-xl 
          rounded-2xl 
          p-6
        ">
        <label class="block text-base font-medium text-gray-900 dar:text-gray-100 mb-4">
          Selecciona la fecha para ver las ventas
        </label>
        
        <!-- MODIFICADO: 
          - Se agregó la prop ':dar="true"' para el modo oscuro del calendario.
          - Se agregó 'teleport-center' para asegurar que los menús desplegables
            aparezcan correctamente centrados.
        -->
        <Datepicker 
          v-model="date" 
          inline 
          auto-apply 
          :month-change-on-scroll="false" 
          model-type="yyyy-MM-dd"
          :dar="true"
          teleport-center
        ></Datepicker>
      </div>

      <!-- MODIFICADO: 
        - Contenedor para todas las tarjetas de datos de ventas.
        - Se usa 'space-y-8' para reemplazar los divisores 'border-dashed'.
      -->
      <div v-if="shift_1_sales.length || shift_2_sales.length" class="space-y-8">
        
        <!-- MODIFICADO: Tarjeta para "Venta mensual acumulada" -->
        <div class="mx-4 sm:mx-0 bg-white dar:bg-gray-800 shadow-xl rounded-2xl p-6">
          <h1 class="text-lg font-semibold text-gray-900 dar:text-gray-100 mb-4">
            Venta mensual acumulada
          </h1>
          <div class="text-sm text-gray-600 dar:text-gray-400 space-y-1">
            <p>
              Ventas: 
              <span class="font-medium text-gray-900 dar:text-gray-200">
                ${{ numberFormat(totalMonthSale().month_sales + totalMonthSale().to_employees) }}
              </span>
            </p>
            <p>
              Registrado en caja: 
              <span class="font-medium text-gray-900 dar:text-gray-200">
                ${{ numberFormat(month_stored_cash) }}
              </span>
            </p>
            <p v-html="monthSaleDiff()"></p>
          </div>
        </div>
        
        <!-- MODIFICADO: Tarjeta para "Empleados activos" -->
        <div class="mx-4 sm:mx-0 bg-white dar:bg-gray-800 shadow-xl rounded-2xl p-6">
          <h1 class="text-lg font-semibold text-gray-900 dar:text-gray-100 mb-4 text-center">
            Empleados activos este día
          </h1>
          <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
            <div v-for="(employee, index) in employees" :key="index" 
                 class="flex items-center p-3 bg-gray-50 dar:bg-gray-700 rounded-lg">
              <i class="fa-regular fa-user-circle text-xl text-indigo-500 dar:text-indigo-400 mr-3"></i>
              <p class="text-sm font-medium text-gray-800 dar:text-gray-200">{{ employee.name }}</p>
            </div>
          </div>
        </div>

        <!-- MODIFICADO: Tarjeta para "Ventas turno matutino" -->
        <div class="mx-4 sm:mx-0 bg-white dar:bg-gray-800 shadow-xl rounded-2xl p-6 overflow-x-auto">
          <h1 class="text-lg font-semibold text-gray-900 dar:text-gray-100 mb-4">
            Ventas turno matutino
          </h1>
          <SaleTable :shiftSales="shift_1_sales" />
          <div class="flex justify-end mt-4">
            <!-- MODIFICADO: Estilo del total más moderno, usando verde -->
            <p class="
                font-bold 
                text-base 
                text-green-800 
                dar:text-green-100 
                bg-green-100 
                dar:bg-green-900 
                px-4 
                py-2 
                rounded-lg 
                inline-block
              ">
              Total: ${{ (totalSale().shift_1).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",") }}
            </p>
          </div>
        </div>

        <!-- MODIFICADO: Tarjeta para "Ventas turno vespertino" -->
        <div class="mx-4 sm:mx-0 bg-white dar:bg-gray-800 shadow-xl rounded-2xl p-6 overflow-x-auto">
          <h1 class="text-lg font-semibold text-gray-900 dar:text-gray-100 mb-4">
            Ventas turno vespertino
          </h1>
          <SaleTable :shiftSales="shift_2_sales" />
          <div class="flex justify-end mt-4">
            <p class="
                font-bold 
                text-base 
                text-green-800 
                dar:text-green-100 
                bg-green-100 
                dar:bg-green-900 
                px-4 
                py-2 
                rounded-lg 
                inline-block
              ">
              Total: ${{ (totalSale().shift_2).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",") }}
            </p>
          </div>
        </div>

        <!-- MODIFICADO: Tarjeta para "Ventas a empleados / cortesías" -->
        <div class="mx-4 sm:mx-0 bg-white dar:bg-gray-800 shadow-xl rounded-2xl p-6">
          <h1 class="text-lg font-semibold text-gray-900 dar:text-gray-100 mb-4">
            Ventas a empleados / cortesías
          </h1>
          <div class="grid lg:grid-cols-2 gap-4">
            <!-- MODIFICADO: Estilo de cada item de venta -->
            <div class="border border-gray-200 dar:border-gray-700 rounded-lg p-4" v-for="sale in sales_to_employees" :key="sale.id">
              <div class="flex items-center mb-4">
                <i class="fa-regular fa-user-circle text-xl text-indigo-500 dar:text-indigo-400 mr-3"></i>
                <p class="text-base font-medium text-gray-800 dar:text-gray-200">{{ sale.user?.name }}</p>
              </div>
              <div class="grid grid-cols-6 gap-2 text-xs text-gray-600 dar:text-gray-400">
                <p class="font-bold col-span-2 text-gray-800 dar:text-gray-200">Producto</p>
                <p class="font-bold text-gray-800 dar:text-gray-200">Tipo</p>
                <p class="font-bold text-gray-800 dar:text-gray-200">Cantidad</p>
                <p class="font-bold text-gray-800 dar:text-gray-200">Total</p>
                <p class="font-bold text-gray-800 dar:text-gray-200">Motivo</p>

                <p class="col-span-2">{{ sale.product.name }}</p>
                <p>{{ sale.price == 0 ? 'C' : 'VE' }}</p>
                <p>{{ sale.quantity }}</p>
                <p>${{ (sale.price * sale.quantity)?.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",") }}</p>
                <p>{{ sale.price == 0 ? sale.notes : '' }}</p>
              </div>
            </div>
          </div>
          <div class="flex justify-end mt-4 lg:col-span-2">
            <p class="
                font-bold 
                text-base 
                text-green-800 
                dar:text-green-100 
                bg-green-100 
                dar:bg-green-900 
                px-4 
                py-2 
                rounded-lg 
                inline-block
              ">
              Total: ${{ (totalSale().to_employees).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",") }}
            </p>
          </div>
        </div>

        <!-- MODIFICADO: Tarjeta para "Venta total del día" y "Caja" -->
        <div class="mx-4 sm:mx-0 bg-white dar:bg-gray-800 shadow-xl rounded-2xl p-6">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-start">
            
            <!-- Columna de inputs de caja -->
            <div class="space-y-4">
              <div v-if="!stored_cash.length" class="p-4 bg-gray-50 dar:bg-gray-700 rounded-lg">
                <InputLabel value="Cantidad total en caja *" class="text-sm font-medium text-gray-800 dar:text-gray-200 mb-2" />
                <input v-model="cash" type="number" autocomplete="off" required 
                       class="block w-full border-gray-300 dar:border-gray-600 dar:bg-gray-800 dar:text-gray-200 focus:border-indigo-500 dar:focus:border-indigo-400 focus:ring-indigo-500 dar:focus:ring-indigo-400 rounded-lg shadow-sm"
                       placeholder="$00.0" />
                <PrimaryButton @click="storeCash" class="mt-3" :disabled="!cash">Guardar</PrimaryButton>
              </div>

              <div v-if="edit_stored_cash" class="p-4 bg-gray-50 dar:bg-gray-700 rounded-lg">
                <InputLabel value="Actualizar cantidad total en caja *" class="text-sm font-medium text-gray-800 dar:text-gray-200 mb-2" />
                <input v-model="cash" type="number" autocomplete="off" required 
                       class="block w-full border-gray-300 dar:border-gray-600 dar:bg-gray-800 dar:text-gray-200 focus:border-indigo-500 dar:focus:border-indigo-400 focus:ring-indigo-500 dar:focus:ring-indigo-400 rounded-lg shadow-sm"
                       placeholder="$00.0" />
                <div class="flex space-x-2 mt-3">
                  <CancelButton @click="edit_stored_cash = false">Cancelar</CancelButton>
                  <PrimaryButton @click="updateCash" :disabled="!cash">Actualizar</PrimaryButton>
                </div>
              </div>
            </div>

            <!-- Columna de totales -->
            <div class="flex flex-col items-end text-base space-y-2 text-gray-800 dar:text-gray-200">
              <p class="font-semibold text-lg">
                Total del sistema: 
                <span class="font-bold text-xl text-gray-900 dar:text-white">
                  ${{ (totalSale().shift_1 + totalSale().shift_2 + totalSale().to_employees)?.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",")}}
                </span>
              </p>
              <div v-if="stored_cash.length && !edit_stored_cash" class="flex justify-between items-center group">
                <p class="font-semibold">
                  Registrado en caja: 
                  <span class="font-bold text-lg">
                    ${{ (stored_cash[0].cash)?.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",") }}
                  </span>
                </p>
                <i @click="edit_stored_cash = true" 
                   class="
                     fa-solid fa-pencil 
                     text-indigo-600 
                     dar:text-indigo-400 
                     hover:text-indigo-800 
                     dar:hover:text-indigo-300
                     ml-3 
                     cursor-pointer 
                     text-xs 
                     transition-opacity
                   "></i>
              </div>
              <p v-if="stored_cash.length" v-html="saleDiff()"></p>
              <p class="font-semibold">
                Comisión: 
                <span class="font-bold text-lg">
                  ${{ totalSale().commissions }}
                </span>
              </p>
            </div>
          </div>
        </div>
      </div>
      
      <!-- MODIFICADO: Mensaje de "No hay ventas" -->
      <p v-else-if="date" class="mt-10 text-center text-lg text-gray-500 dar:text-gray-400">
        No hay ventas para mostrar en esta fecha
      </p>
    </div>
  </AppLayout>
</template>

<script>
// El script permanece sin cambios
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
      
      // MODIFICADO: Clases de color para la diferencia
      return diff > 0
        ? '<span class="text-green-600 dar:text-green-500 text-sm font-bold">Diferencia: +$' + diff.toFixed(2) + '</span>'
        : '<span class="text-red-600 dar:text-red-500 text-sm font-bold">Diferencia: $' + diff.toFixed(2) + '</span>';
    },
    monthSaleDiff() {
      const total_sale = this.totalMonthSale();
      const total = total_sale.month_sales
        + total_sale.to_employees;

      const diff = this.month_stored_cash - total;

      // MODIFICADO: Clases de color para la diferencia
      // CORREGIDO: Se eliminó .toFixed(2) de aquí, ya que numberFormat ya lo hace.
      return diff > 0
        ? '<span class="text-green-600 dar:text-green-500 font-bold">Diferencia: +$' + this.numberFormat(diff) + '</span>'
        : '<span class="text-red-600 dar:text-red-500 font-bold">Diferencia: $' + this.numberFormat(diff) + '</span>';
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
      if (number === null || number === undefined) return '0.00';
      const exp = /(\d)(?=(\d{3})+(?!\d))/g;
      const rep = '$1,';
      return number.toFixed(2).replace(exp, rep);
    }, 
    editSale(sale) {
      this.edit_sale = sale;
      this.form.quantity = sale.quantity;
      this.show_edit_sale_modal = true;
    },
  },
};
</script>

