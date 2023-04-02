<template>
  <AppLayout title="Mostrar Egreso">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Detalles de egreso
      </h2>
    </template>

    <div class="flex justify-start">
      <Link :href="route('outcomes.index')" class="flex items-center mt-2 text-slate-700">
        <i
          class="fas fa-long-arrow-alt-left text-lg active:bg-gray-300 bg-opacity-100 rounded-full w-7 h-7 pl-1 ml-2"
        ></i>
        <span class="ml-1 cursor-default">Atrás</span>
      </Link>
    </div>

    <div
      class="max-w-2xl md:mx-auto mt-5 shadow-md shadow-gray-500/70 rounded-lg px-5 pt-4 pb-5 bg-white mx-4"
    >
      <h1 class="text-sky-500 font-bold mb-2">Productos comprados</h1>
      <ul>
        <li
          v-for="outcome in outcomes"
          :key="outcome.id"
          class="text-sm list-disc ml-2"
        >
          {{ outcome.concept }}
          <i class="fa-solid fa-arrow-right mx-3 text-green-600"></i>
          ${{ outcome.cost }} X
          {{ outcome.quantity }} = ${{ outcome.quantity * outcome.cost}}    
        </li>
      </ul>
<br>
      Total= ${{getTotal()}}
    </div>
  </AppLayout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Link } from "@inertiajs/inertia-vue3";

export default {
  data() {
    return {
      outcomes_reversed: null,
    };
  },
  components: {
    AppLayout,
    Link,
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

  },
};
</script>
