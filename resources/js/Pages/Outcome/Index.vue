<template>
  <LoadingIndicator v-if="loading" />
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
          value-format="MM YYYY"
        />
      </div>
      <Link :href="route('outcomes.create')">
        <PrimaryButton class="mb-5 !rounded-md"><i class="fa-solid fa-plus mr-2"></i> Nuevo</PrimaryButton>
      </Link>
    </div>

      <p v-if="month" class="font-bold text-sm mx-5">Total de egresos: $</p>

      <div class="text-center font-bold mb-4">
        
        <label v-if="!total_outcome">Egresos totales: ${{ total_outcomes_money }} </label>
        <label v-else>Egresos totales: ${{ total_outcome }} </label>
      </div>


      <div v-if="!loading" class="mx-auto">
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
import LoadingIndicator from "@/Components/MyComponents/LoadingIndicator.vue";
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
      loading: false,
    }
  },
  components: {
    AppLayout,
    SecondaryButton,
    PrimaryButton,
    Pagination,
    OutcomesTable,
    LoadingIndicator,
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
        this.loading = true;
        const response = await axios.post(route('outcomes.filter'),{year: this.date.split(' ')[1], month: this.date.split(' ')[0]});
        if(response.status == 200){
         this.filtered_outcomes = response.data.outcomes;
         this.total_outcome = response.data.total_outcomes_money;
        }
      } catch (error) {
        console.log(error);
        this.$notify({
            title: "Algo salió mal",
            message: "No se pudo recuperar el historial de egresos. Intenta más tarde",
            type: "error",
          });
      } finally {
        this.loading = false;
      }
    }
  },
  mounted() {
    this.filtered_outcomes = this.outcomes; 
  }
};
</script>
