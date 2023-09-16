<template>
  <AppLayout title="Administración de Nóminas">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
        Administración de Nóminas
      </h2>
    </template>
    aqui va
    <div class="globe-container">
      <div v-for="payroll in payrolls.data" :key="payroll.id" @click="payroll_selected = payroll"
        class="globe hover:bg-gray-100 cursor-pointer"
        :class="{ 'border-4 border-[#883339] !bg-amber-700/10': payroll_selected.id === payroll.id }">
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
        <Link v-if="!payroll_selected.is_active" :href="route('payroll-admin.show-all', payroll_selected.id)">
        <ThirthButton class="mr-7 mt-4"><i class="fa-solid fa-print mr-1"></i> Imprimir nóminas</ThirthButton>
        </Link>
        <ThirthButton @click="show_confirmation = true" v-else class="mr-7 mt-4">Cerrar nómina</ThirthButton>
      </div>
      <PayRollTable v-for="(payroll, index) in payroll_selected.users" :key="index" :payroll="payroll"
        @extraTime="createExtraTime($event)" />
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
        Tiempo extra para <span class="text-sky-600 font-bold">{{ add_extra_time_info.payroll_user.user.name }}</span> |
        dia: {{ week_days[add_extra_time_info.day] }}
      </template>
      <template #content>
        <div class="relative z-0 mb-6 w-full group">
          <div class="grid grid-cols-2 gap-2">
            <input v-model="form.hours" type="number" name="floating_hour" autocomplete="off" required class="
                  block
                  py-2.5
                  px-0
                  w-full
                  text-sm text-gray-900
                  bg-transparent
                  border-0 border-b-2 border-gray-300
                  appearance-none
                  dark:text-gray-700 dark:border-gray-600 dark:focus:border-stone-500
                  block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-[#BF532A]
                  peer
                " placeholder=" " />
            <label for="floating_hour" class="
                  absolute
                  text-sm text-gray-500
                  dark:text-gray-700
                  duration-300
                  transform
                  -translate-y-6
                  scale-75
                  top-3
                  -z-10
                  origin-[0]
                  peer-focus:left-0
                  peer-focus:text-stone-600
                  peer-focus:dark:text-stone-500
                  peer-placeholder-shown:scale-100
                  peer-placeholder-shown:translate-y-0
                  peer-focus:scale-75 peer-focus:-translate-y-6
                ">Horas *</label>
            <input v-model="form.minutes" type="number" name="floating_minutes" autocomplete="off" required class="
                block
                py-2.5
                px-0
                w-full
                text-sm text-gray-900
                bg-transparent
                border-0 border-b-2 border-gray-300
                appearance-none
                dark:text-gray-700 dark:border-gray-600 dark:focus:border-stone-500
                block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-[#BF532A]
                peer
              " placeholder=" " />
            <label for="floating_minutes" class="
                absolute
                right-0
                text-sm text-gray-500
                dark:text-gray-700
                duration-300
                transform
                -translate-y-6
                scale-75
                top-3
                -z-10
                origin-[0]
                peer-focus:right-0
                peer-focus:text-stone-600
                peer-focus:dark:text-stone-500
                peer-placeholder-shown:scale-100
                peer-placeholder-shown:translate-y-0
                peer-focus:scale-75 peer-focus:-translate-y-6
              ">Minutos *</label>
          </div>
        </div>
        <div class="relative z-0 mb-6 w-full group">
          <input v-model="form.pay" type="number" name="floating_description" autocomplete="off" class="
                block
                py-2.5
                px-0
                w-full
                text-sm text-gray-900
                bg-transparent
                border-0 border-b-2 border-gray-300
                appearance-none
                dark:text-gray-700 dark:border-gray-600 dark:focus:border-stone-500
                block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-[#BF532A]
                peer
              " placeholder=" " />
          <label for="floating_description" class="
                absolute
                text-sm text-gray-500
                dark:text-gray-700
                duration-300
                transform
                -translate-y-6
                scale-75
                top-3
                -z-10
                origin-[0]
                peer-focus:left-0
                peer-focus:text-stone-600
                peer-focus:dark:text-stone-500
                peer-placeholder-shown:scale-100
                peer-placeholder-shown:translate-y-0
                peer-focus:scale-75 peer-focus:-translate-y-6
              ">Pago ($)*</label>
          <!-- <InputError :message="$page.props?.errors.desciption" /> -->
        </div>
      </template>
      <template #footer>
        <SecondaryButton @click="show_dialog = false">Cancelar</SecondaryButton>
        <PrimaryButton @click="storeExtraTime" class="ml-2" :disabled="form.processing">Guardar</PrimaryButton>
      </template>
    </DialogModal>

  </AppLayout>
</template>

<script>

import AppLayout from "@/Layouts/AppLayout.vue";
import { Link, useForm } from "@inertiajs/inertia-vue3";
import PayRollTable from "@/Components/PayRollTable.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import ThirthButton from "@/Components/ThirthButton.vue";
import ConfirmationModal from "@/Components/ConfirmationModal.vue";
import DialogModal from "@/Components/DialogModal.vue";
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
    }
  },
  components: {
    AppLayout,
    PayRollTable,
    Link,
    SecondaryButton,
    ConfirmationModal,
    DialogModal,
    PrimaryButton,
    ThirthButton
  },
  props: {
    payrolls: Object,
  },
  methods: {
    createExtraTime(payroll_user_info) {
      this.add_extra_time_info = payroll_user_info;
      this.show_dialog = true;
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
