<template>
  <LoadingIndicator v-if="loading" />
  <AppLayout title="Administración de Nóminas">
    <div class="mx-1 lg:mx-10">
      <h2 class="font-bold text-lg mt-8">
        Administración de Nóminas
      </h2>
      <header class="flex justify-center items-center mt-6 mb-10">
        <i @click="changeMonth(-1)" class="fa-solid fa-angle-left text-primary text-xs mr-5 cursor-pointer p-1"></i>
        <i class="fa-solid fa-calendar-days text-primary text-sm mr-2"></i>
        <p class="text-[#cccccc]">|</p>
        <p class="text-sm ml-2 uppercase">{{ currentMonth.toLocaleDateString('es-ES', {
          month: 'long', year: 'numeric'
        })
        }}</p>
        <i @click="changeMonth(1)" class="fa-solid fa-angle-right text-primary text-xs ml-5 cursor-pointer p-1"></i>
      </header>
      <div v-if="payrolls.data.length">
        <div class="contenedor text-sm pb-10">
          <div class="flex justify-center">
            <div v-for="payroll in payrolls.data" :key="payroll.id" @click="payroll_selected = payroll"
              class="globe w-80 border-2 border-gray3 hover:bg-gray-100 cursor-pointer mx-2"
              :class="{ '!border-primary': payroll_selected.id === payroll.id }">
              <div class="globe-title pb-2">
                Semana {{ payroll.week }}: {{ payroll.start_date }} al {{ payroll.end_date }}
              </div>
              <div v-if="!payroll.is_active" class="text-xs">
                {{ payroll.users.length }} empleado(s) en nómina
              </div>
              <p v-else class="text-gray-500 text-center text-xs">Nómina en curso</p>
            </div>
          </div>
        </div>

        <div class="mt-5 text-bold text-lg text-gray-700">
          <div class="flex justify-between items-center my-4">
            <p class="ml-5 text-sm font-bold">Asistencias de empleados</p>
            <a v-if="!payroll_selected.is_active" target="_blank" :href="route('payroll-admin.show-all', payroll_selected.id)">
              <PrimaryButton class="mr-7"><i class="fa-solid fa-print mr-1"></i> Imprimir nóminas</PrimaryButton>
            </a>
            <!-- <PrimaryButton @click="show_confirmation = true" v-else class="mr-7">Cerrar nómina</PrimaryButton> -->
          </div>
          <PayRollTable v-for="(payroll, index) in payroll_selected.users" :key="index" :payroll="payroll"
            @extraTime="createExtraTime($event)" />
        </div>
      </div>
      <div v-else class="my-10 px-12">
        <p class="text-center text-gray1">No hay nominas en el periodo seleccionado para mostrar</p>
      </div>
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
    <DialogModal :show="show_dialog" @close="show_dialog = false">
      <template #title>
        <h1 class="font-bold text-center"> Agregar tiempo extra </h1>
        <i @click="show_dialog = false"
          class="absolute right-3 top-2 fa-regular fa-circle-xmark text-xl cursor-pointer"></i>
        <p class="text-gray-600 font-bold text-sm mt-3"><i class="fa-regular fa-circle-user mr-3"></i>{{
          add_extra_time_info.payroll_user.user.name }}</p>
        <p class="text-gray-600 font-bold text-sm mt-2"><i class="fa-solid fa-calendar-days mr-3"></i>{{
          week_days[add_extra_time_info.day] }}</p>

      </template>
      <template #content>
        <div class="relative z-0 mb-6 w-full group">
          <div class="flex items-center space-x-1">
            <div>
              <InputLabel value="Horas *" class="ml-3 mb-1 text-sm" />
              <input v-model="form.hours" type="number" autocomplete="off" class="input" placeholder="0" required />
            </div>

            <div>
              <InputLabel value="Minutos *" class="ml-3 mb-1 text-sm" />
              <input v-model="form.minutes" type="number" autocomplete="off" class="input" placeholder="0" required />
            </div>

            <div>
              <InputLabel value="Remuneración *" class="ml-3 mb-1 text-sm" />
              <input v-model="form.pay" type="number" autocomplete="off" class="input" placeholder="$00.0" required />
            </div>
          </div>
        </div>
      </template>
      <template #footer>
        <CancelButton class="!rounded-full" @click="show_dialog = false">Cancelar</CancelButton>
        <PrimaryButton @click="storeExtraTime" class="ml-2" :disabled="form.processing">Guardar</PrimaryButton>
      </template>
    </DialogModal>
  </AppLayout>
</template>

<script>

import AppLayout from "@/Layouts/AppLayout.vue";
import PayRollTable from "@/Components/PayRollTable.vue";
import LoadingIndicator from "@/Components/MyComponents/LoadingIndicator.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import CancelButton from "@/Components/CancelButton.vue";
import ThirthButton from "@/Components/ThirthButton.vue";
import ConfirmationModal from "@/Components/ConfirmationModal.vue";
import DialogModal from "@/Components/DialogModal.vue";
import InputLabel from "@/Components/InputLabel.vue";
import { Link, useForm } from "@inertiajs/inertia-vue3";
import axios from "axios";

export default {
  data() {
    const form = useForm({
      time: null,
      pay: null
    });

    return {
      payroll_selected: this.payrolls.data[0],
      show_confirmation: false,
      show_dialog: false,
      add_extra_time_info: null,
      form,
      week_days: ['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
      userWithNoAttendance: '',
      loading: false,
      currentMonth: new Date(),
    }
  },
  components: {
    AppLayout,
    PayRollTable,
    CancelButton,
    ConfirmationModal,
    DialogModal,
    PrimaryButton,
    ThirthButton,
    InputLabel,
    Link,
    LoadingIndicator,
  },
  props: {
    payrolls: Object,
    usersWithNoAttendance: Array,
  },
  methods: {
    changeMonth(offset) {
      const newMonth = new Date(this.currentMonth.getFullYear(), this.currentMonth.getMonth() + offset, 1);
      this.currentMonth = newMonth;

      this.fetchPayrollsByDate();
    },
    createExtraTime(payroll_user_info) {
      this.add_extra_time_info = payroll_user_info;
      this.show_dialog = true;
    },
    async fetchPayrollsByDate() {
      try {
        this.loading = true;
        const year = this.currentMonth.getFullYear();
        const month = String(this.currentMonth.getMonth() + 1).padStart(2, '0'); // Meses van de 0 a 11
        const day = String(this.currentMonth.getDate()).padStart(2, '0');
        const date = `${year}-${month}-${day}`;

        const response = await axios.get(route('payroll.get-by-date', { date: date }));

        if (response.status === 200) {
          this.payrolls.data = response.data.items;
          this.userWithNoAttendance = '';
          this.payroll_selected = this.payrolls.data[0];
        }
      } catch (error) {
        console.log(error);
      } finally {
        this.loading = false;
      }
    },
    async generatePayrollUser() {
      try {
        this.loading = true;
        const response = await axios.get(route('users.generate-payroll', this.userWithNoAttendance));

        if (response.status === 200) {
          this.payrolls.data[0] = response.data.payroll;
          this.userWithNoAttendance = '';
          this.$notify({
            title: "Correcto",
            message: "Se ha registrado la asistencia del usuario seleccionado",
            type: "success",
          });
        }
      } catch (error) {
        console.log(error);
      } finally {
        this.loading = false;
      }
    },
    async storeExtraTime() {
      try {
        const response = await axios.post(route('payroll.store-extras'), {
          payroll_user_id: this.add_extra_time_info.payroll_user.payroll_user_id,
          week_day: this.add_extra_time_info.day,
          time: this.form.hours * 60 + this.form.minutes,
          pay: this.form.pay
        });

        // pendent load in real time extra time stored
        // this.payrolls.data[0].users.find(
        //   user => user.payroll_user_id == this.add_extra_time_info.payroll_user.payroll_user_id
        // )?.extras = [];
        this.show_dialog = false;
      } catch (error) {
        console.log(error);
      }
    }
  },
};
</script>

<style>
.contenedor {
  display: flex;
  overflow-x: scroll;
  /* Permite el desplazamiento horizontal */
  white-space: nowrap;
  /* Evita el salto de línea de las secciones */
}
</style>
