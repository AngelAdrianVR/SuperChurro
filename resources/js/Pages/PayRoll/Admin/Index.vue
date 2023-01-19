<template>
  <AppLayout title="Administración de Nóminas">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Administración de Nóminas
      </h2>
    </template>
    <div class="globe-container">
      <div v-for="payroll in payrolls.data" :key="payroll.id" @click="payroll_selected = payroll"
        class="globe hover:bg-gray-100 cursor-pointer"
        :class="{ 'border-4 border-sky-500 !bg-sky-100': payroll_selected.id === payroll.id }">
        <div class="globe-title pb-2">
          Semana {{ payroll.week }}: {{ payroll.start_date }} al {{ payroll.end_date }}
        </div>
        <div v-if="!payroll.is_active" class="text-sm">
          {{ payroll.users.length }} empleado(s) en nómina
        </div>
        <p v-else class="text-gray-500 text-sm text-center">Nómina en curso</p>
      </div>
    </div>

    <div class="mt-5 text-bold text-lg text-gray-700">
      <div class="flex justify-between items-center">
        <p class="my-2 ml-5">Asistencias de empleados</p>
        <Link :href="route('payroll-admin.show', payroll_selected.id)">
          <SecondaryButton class="mr-7 mt-4" :disabled="payroll_selected.is_active"><i class="fa-solid fa-print mr-1"></i> Imprimir nóminas</SecondaryButton>
        </Link>
      </div>
      <PayRollTable v-for="(payroll, index) in payroll_selected.users" :key="index" :payroll="payroll" />
    </div>

  </AppLayout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Link } from "@inertiajs/inertia-vue3";
import PayRollTable from "@/Components/PayRollTable.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";

export default {
  data() {
    return {
      payroll_selected: this.payrolls.data[0],
    }
  },
  components: {
    AppLayout,
    PayRollTable,
    Link,
    SecondaryButton,
  },
  props: {
    payrolls: Object,
  },
  methods: {

  },
};
</script>
