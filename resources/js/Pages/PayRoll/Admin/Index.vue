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
        <p class="text-sm ml-2 uppercase">
          {{ currentMonth.toLocaleDateString('es-ES', { month: 'long', year: 'numeric' }) }}
        </p>
        <i @click="changeMonth(1)" class="fa-solid fa-angle-right text-primary text-xs ml-5 cursor-pointer p-1"></i>
      </header>
      <div v-if="payrolls.data.length">
        <div class="contenedor text-sm pb-10">
          <div class="flex justify-center">
            <div v-for="payroll in payrolls.data" :key="payroll.id" @click="payrollSelected = payroll"
              class="globe w-80 border-2 border-gray3 hover:bg-gray-100 cursor-pointer mx-2"
              :class="{ '!border-primary': payrollSelected.id === payroll.id }">
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
        <div class="mt-10 text-bold text-lg text-gray-700">
          <div class="flex justify-between items-center">
            <p class="ml-5 text-sm font-bold">Asistencias de empleados</p>
            <PrimaryButton @click="prepareUsersModal" class="mr-7">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-4 h-4 mr-1">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0 .229 2.523a1.125 1.125 0 0 1-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0 0 21 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 0 0-1.913-.247M6.34 18H5.25A2.25 2.25 0 0 1 3 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 0 1 1.913-.247m10.5 0a48.536 48.536 0 0 0-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5Zm-3 0h.008v.008H15V10.5Z" />
              </svg>
              Imprimir nóminas
            </PrimaryButton>
          </div>
          <PayRollTable v-for="(payroll, index) in payrollSelected.users" :key="index" :payroll="payroll"
            @extraTime="createExtraTime($event)" />

          <div v-if="localUsersWithNoAttendance.length && payrollSelected.is_active">
            <h2 class="font-bold text-sm mb-1 mx-3">Usuarios sin asistencias esta semana</h2>
            <div v-for="(user, index) in localUsersWithNoAttendance" :key="user.id"
              class="rounded-lg mb-2 py-3 border-y border-x border-gray3">
              <div class="py-1 flex flex-wrap items-center bg-[#EDEDED]">
                <div class="relative w-full px-4 max-w-full flex-grow flex-1 flex justify-between">
                  <h3 class="w-full flex items-center justify-between font-semibold text-base text-[#373737]">
                    <p class="w-2/3 truncate">
                      <i class="fa-regular fa-circle-user mr-1"></i>
                      <span>{{ user.name }}</span>
                    </p>
                    <PrimaryButton @click="generatePayrollUser(index)">Registrar</PrimaryButton>
                  </h3>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div v-else class="my-10 px-12">
        <p class="text-center text-gray1">No hay nominas en el periodo seleccionado para mostrar</p>
      </div>
    </div>

    <ConfirmationModal :show="showConfirmation" @close="showConfirmation = false">
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
            @click="showConfirmation = false">
            Cancelar
          </button>
        </div>
      </template>
    </ConfirmationModal>
    <DialogModal :show="showDialog" @close="showDialog = false">
      <template #title>
        <h1 class="font-bold text-center"> Agregar tiempo extra </h1>
        <i @click="showDialog = false"
          class="absolute right-3 top-2 fa-regular fa-circle-xmark text-xl cursor-pointer"></i>
        <p class="text-gray-600 font-bold text-sm mt-3"><i class="fa-regular fa-circle-user mr-3"></i>{{
          addExtraTimeInfo.payroll_user.user.name }}</p>
        <p class="text-gray-600 font-bold text-sm mt-2"><i class="fa-solid fa-calendar-days mr-3"></i>{{
          weekDays[addExtraTimeInfo.day] }}</p>

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
        <CancelButton class="!rounded-full" @click="showDialog = false">Cancelar</CancelButton>
        <PrimaryButton @click="storeExtraTime" class="ml-2" :disabled="form.processing">Guardar</PrimaryButton>
      </template>
    </DialogModal>
    <DialogModal :show="showUserSelectorModal" @close="showUserSelectorModal = false">
      <template #title>
        <h1 class="text-sm font-bold">Selecciona las nominas que quieres ver</h1>
      </template>
      <template #content>
        <div class="lg:grid grid-cols-2 gap-x-3 gap-y-1">
          <label v-for="(item, index) in payrollSelected.users" :key="index" class="flex items-center">
            <input type="checkbox" v-model="usersSelected" :value="item.user.id"
              class="rounded border-gray-400 text-primary shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50" />
            <span class="ml-2 text-sm">{{ item.user.name }}</span>
          </label>
        </div>
      </template>
      <template #footer>
        <CancelButton class="!rounded-full" @click="showUserSelectorModal = false">Cancelar</CancelButton>
        <PrimaryButton @click="printPayrolls" class="ml-2" :disabled="form.processing">Aplicar</PrimaryButton>
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
      payrollSelected: this.payrolls.data[0],
      showConfirmation: false,
      showDialog: false,
      showUserSelectorModal: false,
      addExtraTimeInfo: null,
      form,
      weekDays: ['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
      usersSelected: [],
      localUsersWithNoAttendance: [],
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
    printPayrolls() {
      const url = route('payroll-admin.show-receipt', {
        ids: JSON.stringify(this.usersSelected),
        payroll_id: this.payrollSelected.id,
      });

      window.open(url, '_blank');
    },
    changeMonth(offset) {
      const newMonth = new Date(this.currentMonth.getFullYear(), this.currentMonth.getMonth() + offset, 1);
      this.currentMonth = newMonth;

      this.fetchPayrollsByDate();
    },
    createExtraTime(payroll_user_info) {
      this.addExtraTimeInfo = payroll_user_info;
      this.showDialog = true;
    },
    prepareUsersModal() {
      // seleccionar a todos los usuarios por defecto
      this.usersSelected = this.payrollSelected.users.map(item => {
        return item.user.id;
      });
      this.showUserSelectorModal = true;
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
          this.localUsersWithNoAttendance = response.data.usersWithNoAttendance;
          this.payrollSelected = this.payrolls.data[0];
        }
      } catch (error) {
        console.log(error);
      } finally {
        this.loading = false;
      }
    },
    async generatePayrollUser(index) {
      try {
        this.loading = true;
        const response = await axios.get(route('users.generate-payroll', this.localUsersWithNoAttendance[index].id));

        if (response.status === 200) {
          this.payrollSelected = response.data.payroll;
          this.payrolls.data[0] = response.data.payroll;
          this.localUsersWithNoAttendance.splice(index, 1);
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
          payroll_user_id: this.addExtraTimeInfo.payroll_user.payroll_user_id,
          week_day: this.addExtraTimeInfo.day,
          time: this.form.hours * 60 + this.form.minutes,
          pay: this.form.pay
        });

        // pendent load in real time extra time stored
        // this.payrolls.data[0].users.find(
        //   user => user.payroll_user_id == this.addExtraTimeInfo.payroll_user.payroll_user_id
        // )?.extras = [];
        this.showDialog = false;
      } catch (error) {
        console.log(error);
      }
    }
  },
  mounted() {
    this.localUsersWithNoAttendance = this.usersWithNoAttendance;
  }
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
