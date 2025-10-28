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

    <HideableLabel class="absolute right-0 top-40 z-20" iconClass="fa-solid fa-info">
      <p>
        Para editar el concepto da click sobre él.
      </p>
    </HideableLabel>

    <!-- Usamos la propiedad computada 'groupedOutcomes' -->
    <OutcomesCard v-for="(outcomes, category) in groupedOutcomes" :key="category" :outcomes="outcomes" />

      <!-- Usamos la propiedad computada 'formattedTotal' -->
      <p class="text-right mx-4 font-bold text-sm mt-5 mb-5">Total= ${{ formattedTotal }} </p>
    
  </AppLayout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import OutcomesCard from "@/Components/MyComponents/Outcome/OutcomesCard.vue";
import HideableLabel from "@/Components/MyComponents/HideableLabel.vue";
import Back from "@/Components/Back.vue";

export default {
  // --- MEJORA: data() ya no es necesario ---
  // data() {
  //   return {
  //     groupedOutcomes: {}, // Movido a computed
  //   };
  // },
  components: {
    AppLayout,
    OutcomesCard,
    HideableLabel,
    Back
  },
  props: {
    outcomes: Array,
  },
  // --- MEJORA: Usar Propiedades Computadas ---
  computed: {
    /**
     * Agrupa los 'outcomes' por categoría.
     * Se recalcula automáticamente si 'this.outcomes' cambia.
     */
    groupedOutcomes() {
      // Agrupar los registros por categoría
      return this.outcomes.reduce((result, outcome) => {
        const category = outcome.category;

        if (!result[category]) {
          result[category] = [];
        }

        result[category].push(outcome);

        return result;
      }, {});
    },
    /**
     * Calcula el total numérico.
     */
    total() {
        let total = 0;
        this.outcomes.forEach(outcome => {
           total += outcome.quantity * outcome.cost;
        });
        return total;
    },
    /**
     * Formatea el total para mostrarlo en la UI.
     */
    formattedTotal() {
        return this.total.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }
  },
  // --- MEJORA: methods y mounted ya no son necesarios para esto ---
  // methods: {
  //   getTotal() { ... }, // Movido a computed
  //   groupOutcomesByCategory() { ... }, // Movido a computed
  // },
  // mounted() {
  //   this.groupOutcomesByCategory(); // Movido a computed
  // },
};
</script>
