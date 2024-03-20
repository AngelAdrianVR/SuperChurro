<template>
  <div class="grid grid-cols-3 text-sm">
    <div class="flex space-x-2" v-for="(sale, index) in totalsByDate" :key="sale">
      <p class="font-bold">{{ formatDate(index) }}:</p>
      <p>${{ sale.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",") }}</p>
    </div>
  </div>
</template>

<script>
import { format } from "date-fns";
import { es } from "date-fns/locale";

export default {
  data() {
    return {};
  },
  components: {},
  props: {
    totalsByDate: Array,
  },
  methods: {
    formatDate(date) {
      const parsedDate = new Date(date);
      return format(parsedDate, "dd 'de' MMM, Y", { locale: es }); // Formato personalizado
    },
  },
};
</script>
