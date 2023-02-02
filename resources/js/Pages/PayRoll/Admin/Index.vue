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
        <Link v-if="!payroll_selected.is_active" :href="route('payroll-admin.show', payroll_selected.id)">
        <SecondaryButton class="mr-7 mt-4"><i class="fa-solid fa-print mr-1"></i> Imprimir nóminas</SecondaryButton>
        </Link>
        <SecondaryButton @click="show_confirmation = true" v-else class="mr-7 mt-4">Cerrar nómina</SecondaryButton>
      </div>
      <PayRollTable v-for="(payroll, index) in payroll_selected.users" :key="index" :payroll="payroll" />
    </div>

    <ConfirmationModal :show="show_confirmation" @close="show_confirmation = false">
      <template #title>
        <div>¿Deseas continuar?</div>
      </template>
      <template #content>
        <div>
          Estás a punto de cerrar la nómina. Asegúrate de que sea sábado por la noche y que no hay
          empleados sin haber registrado salida.
        </div>
      </template>
      <template #footer>
        <div class="flex justify-end">
          <Link :href="route('payroll-admin.close')">
          <button
            class="px-2 py-1 font-semibold border rounded border-red-500 text-red-500 hover:bg-red-500 hover:text-white transition duration-200 mr-2">Continuar</button>
          </Link>
          <button
            class="px-2 py-1 font-semibold border rounded border-gray-500 text-gray-500 hover:bg-gray-100 transition duration-200"
            @click="show_confirmation = false">
            Cancelar
          </button>
        </div>
      </template>
    </ConfirmationModal>

  </AppLayout>
</template>

<script>

import AppLayout from "@/Layouts/AppLayout.vue";
import { Link } from "@inertiajs/inertia-vue3";
import PayRollTable from "@/Components/PayRollTable.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import ConfirmationModal from "@/Components/ConfirmationModal.vue";

export default {
  data() {
    return {
      payroll_selected: this.payrolls.data[0],
      show_confirmation: false,
    }
  },
  components: {
    AppLayout,
    PayRollTable,
    Link,
    SecondaryButton,
    ConfirmationModal,
  },
  props: {
    payrolls: Object,
  },
  methods: {

  },
};
</script>
