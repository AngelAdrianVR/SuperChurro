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

      <div class="pb-2 px-4 flex space-x-2">
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

    

    <div v-if="true">
      <div class="globe-container flex-col">
        <Link :href="route('outcomes.show', outcome)" v-for="outcome in filtered_outcomes" :key="outcome.id"
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
      </div>
    </div>

  </AppLayout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { Link, useForm } from "@inertiajs/inertia-vue3";
import axios from 'axios';


export default {
  data() {
    const form = useForm({
      quantity: null,
      
    });
    return {
      form,
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
    Link,
  },
  props: {
    outcomes: Object,
    total_outcomes_money: String
  },

  methods: {
   async applyFilter(){
      try {
        const response = await axios.post(route('outcomes.filter'),{year: this.selected_year, month: this.selected_month});
        if(response.status == 200){
         this.filtered_outcomes = response.data.outcomes;
         this.total_outcome = response.data.total_outcomes_money;
        }
      } catch (error) {
        console.log(error);
      }
    }
  },
  mounted() {
    this.filtered_outcomes = this.outcomes; 
  }
};
</script>
