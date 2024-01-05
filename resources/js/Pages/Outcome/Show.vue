<template>
  <AppLayout title="Mostrar Egreso">
    <template #header>
      <div class="flex items-center mb-12">
        <Back />
        <h2 class="font-semibold text-xl text-gray-800 text-center ml-5 lg:ml-28">
          Detalles de egresos
        </h2>
      </div>
    </template>

    <HideableLabel class="absolute right-0 top-40 z-50" iconClass="fa-solid fa-info">
      <p>
        Para editar el concepto da click sobre él.
      </p>
    </HideableLabel>

    <OutcomesCard v-for="(outcomes, category) in groupedOutcomes" :key="category" :outcomes="outcomes" />

      <p class="text-right mx-4 font-bold text-sm mt-5 mb-5">Total= ${{getTotal().toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",")}} </p>
    
  </AppLayout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import OutcomesCard from "@/Components/MyComponents/Outcome/OutcomesCard.vue";
import HideableLabel from "@/Components/MyComponents/HideableLabel.vue";
import Back from "@/Components/Back.vue";

export default {
  data() {
    
    return {
      groupedOutcomes: {}, // Objeto para almacenar los resultados agrupados
    };
  },
  components: {
    AppLayout,
    OutcomesCard,
    HideableLabel,
    Back
  },
  props: {
    outcomes: Array,
  },
  methods: {
    getTotal() {
        let total = 0;
        this.outcomes.forEach(outcome => {
           total += outcome.quantity * outcome.cost;
        });
        return total;
    },
    groupOutcomesByCategory() {
      // Agrupar los registros por categoría
      this.groupedOutcomes = this.outcomes.reduce((result, outcome) => {
        const category = outcome.category;

        if (!result[category]) {
          result[category] = [];
        }

        result[category].push(outcome);

        return result;
      }, {});
    },
  },
  mounted() {
    this.groupOutcomesByCategory();
  },
};
</script>
