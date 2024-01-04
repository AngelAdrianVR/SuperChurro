<template>
  <AppLayout title="Historial de Egresos">
    <template #header>
      <div class="flex items-center mt-2">
        <h2 class="font-semibold text-xl text-gray-800 text-center ml-5 lg:ml-28">
          Egresos
        </h2>
      </div>
    </template>

    <div class="flex justify-between mx-5">
      <div class="block">
        <el-date-picker
        @change="applyFilter"
          v-model="date"
          type="month"
          placeholder="Selecciona el mes"
          format="MMM YYYY"
          value-format="MMM YYYY"
        />
      </div>
      {{date?.split(' ')[0]}}
      <Link :href="route('outcomes.create')">
        <PrimaryButton class="mb-5 !rounded-md"><i class="fa-solid fa-plus mr-2"></i> Nuevo</PrimaryButton>
      </Link>
    </div>

      <p v-if="month" class="font-bold text-sm mx-5">Total de egresos: $</p>

      <div class="pb-2 px-4 flex space-x-2 mt-9">
        <select v-model="selected_year" class="select " name="year">
          <option value="" selected disabled>-- Selecciona el año --</option>
          <option v-for="year in years" :key="year" :value="year">{{ year }}</option>
        </select>

        <select v-model="selected_month" class="select " name="year">
          <option value="" selected disabled>-- Selecciona el mes --</option>
          <option v-for="(month, index) in months" :key="month" :value="index + 1">{{ month }}</option>
        </select>

      <PrimaryButton @click="applyFilter">Aplicar filtro</PrimaryButton>

      </div>

      <div class="text-center font-bold mb-4">
        
        <label v-if="!total_outcome">Egresos totales: ${{ total_outcomes_money }} </label>
        <label v-else>Egresos totales: ${{ total_outcome }} </label>
      </div>

      <div class="mx-auto">
        <OutcomesTable class="w-[95%]" :outcomes="filtered_outcomes" />
      </div>

    <!-- <Pagination :pagination="filtered_outcomes" /> -->
  </AppLayout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import Pagination from "@/Components/Pagination.vue";
import OutcomesTable from "@/Components/MyComponents/Outcome/OutcomesTable.vue";
import Back from "@/Components/Back.vue";
import { Link, useForm } from "@inertiajs/inertia-vue3";
import axios from 'axios';


export default {
  data() {
    const form = useForm({
      quantity: null,
      
    });
    return {
      form,
      date: null,
      selected_year: '',
      selected_month: '',
      filtered_outcomes: [],
      total_outcome: null,
      years: [
        '2023',
        '2024',
        '2025',
        '2026',
        '2027',
        '2028',
        '2029',
        '2030',
      ],
      months: [
        'Enero',
        'Febrero',
        'Marzo',
        'Abril',
        'Mayo',
        'Junio',
        'Julio',
        'Agosto',
        'Septiembre',
        'Octubre',
        'Noviembre',
        'Diciembre',
      ],
    }
  },
  components: {
    AppLayout,
    SecondaryButton,
    PrimaryButton,
    Pagination,
    OutcomesTable,
    Back,
    Link
  },
  props: {
    outcomes: Object,
    total_outcomes_money: String
  },

  methods: {
     calculateTotal(outcomeItems) {
      // Calcular el total multiplicando quantity por cost y sumándolos
      return outcomeItems.reduce((total, item) => {
        return total + item.quantity * item.cost;
      }, 0);
    },
   async applyFilter(){
      
      try {
        const response = await axios.post(route('outcomes.filter'),{year: this.date.split(' ')[1], month: this.date.split(' ')[0]});
        if(response.status == 200){
         this.filtered_outcomes = response.data.outcomes;
         this.total_outcome = response.data.total_outcomes_money;
        }
      } catch (error) {
        console.log(error);
      }
      // try {
      //   const response = await axios.post(route('outcomes.filter'),{year: this.selected_year, month: this.selected_month});
      //   if(response.status == 200){
      //    this.filtered_outcomes = response.data.outcomes;
      //    this.total_outcome = response.data.total_outcomes_money;
      //   }
      // } catch (error) {
      //   console.log(error);
      // }
    }
  },
  mounted() {
    this.filtered_outcomes = this.outcomes; 
  }
};
</script>
