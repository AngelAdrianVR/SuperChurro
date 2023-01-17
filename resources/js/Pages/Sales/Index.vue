<template>
  <AppLayout title="Historial de ventas">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Historial de ventas
      </h2>
    </template>

  <template>

  <p class="mt-4 mb-2 text-center font-bold"> Enero 2023</p>
  <div>

  </div>
   
  </template>

  </AppLayout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import { Link } from "@inertiajs/inertia-vue3";
import ConfirmationModal from "@/Components/ConfirmationModal.vue";
export default {
  data() {
    return {
      calendar: [
          { 
            'year':[this.years],
            'mes':[this.months],
            'days':[]
          },
      ],

      years:[
        '2023',
        '2024',
        '2025',
        '2026',
        '2027',
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
        ]

      }
  },
  components: {
    AppLayout,
    SecondaryButton,
    Link,
    ConfirmationModal,
  },
  props: {
    sales: Array,
    years: Array,
    months: Array,
  }, 
  methods: {
    
},
};
</script>
