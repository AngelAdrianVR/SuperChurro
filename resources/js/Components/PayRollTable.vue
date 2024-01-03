<template>
  <section class="relative py-2 bg-blueGray-50">
    <div class="w-full px-4">
      <div class="relative flex flex-col min-w-0 break-words w-full mb-6 rounded-lg 
  bg-transparent text-gray-700">
        <div class="rounded-t-lg mb-0 py-3 border-t border-x border-gray3">
          <div class="py-1 flex flex-wrap items-center bg-gray4">
            <div class="relative w-full px-4 max-w-full flex-grow flex-1 flex justify-between">
              <h3 class="font-semibold text-lg text-gray-700"><i class="fa-regular fa-circle-user mr-1"></i>
                {{ payroll?.user.name }}</h3>
            </div>
          </div>
        </div>
        <div class="block w-full overflow-x-auto ">
          <table @click="showOptions = false"
            class="items-center w-full bg-transparent border-collapse border-b border-gray3">
            <thead>
              <tr class="border-b border-x border-gray3">
                <th class="px-6 align-middle py-3 text-sm uppercase whitespace-nowrap text-left font-bold">
                  Día</th>
                <th class="px-6 align-middle py-3 text-sm uppercase whitespace-nowrap text-left font-bold">
                  Entrada</th>
                <th class="px-6 align-middle py-3 text-sm uppercase whitespace-nowrap text-left font-bold">
                  Salida</th>
                <th class="px-6 align-middle py-3 text-sm uppercase whitespace-nowrap text-left font-bold">
                  T. extra</th>
                <th class="px-6 align-middle py-3 text-sm uppercase whitespace-nowrap text-left font-bold">
                  H. totales</th>
                <th v-if="$page.props.user.is_admin && payroll.is_active"
                  class="px-6 align-middle py-3 text-sm uppercase whitespace-nowrap text-left font-bold">
                </th>
              </tr>
            </thead>
            <tbody>
              <tr class="border-x border-gray3" v-for="(attendance, index) in payroll?.week_attendance.payroll"
                :key="index">
                <th class="border-t-0 px-6 align-middle text-sm whitespace-nowrap p-2 text-left flex items-center">
                  <span class="ml-3 font-bold text-gray-700"> {{ attendance.day }} </span>
                </th>
                <td class="border-t-0 px-6 align-middle text-sm whitespace-nowrap p-2">
                  <input v-if="dayInEdition === index" v-model="form.payroll[index].in" type="text"
                    class="bg-transparent text-sm rounded-md">
                  <p v-else>{{ attendance.in }}</p>
                </td>
                <td class="border-t-0 px-6 align-middle text-sm whitespace-nowrap p-2">
                  <input v-if="dayInEdition === index" v-model="form.payroll[index].out" type="text"
                    class="bg-transparent text-sm rounded-md">
                  <p v-else>{{ attendance.out }}</p>
                </td>
                <td class="border-t-0 px-6 align-middle text-sm whitespace-nowrap p-2">
                  <span v-if="payroll.extras" class="ml-3 font-bold text-gray-700">
                    {{ payroll.extras[week_days[index]] ? payroll.extras[week_days[index]]?.time + ' minutos ($' +
                      payroll.extras[week_days[index]]?.pay + ')' : '--' }}
                  </span>
                  <span v-else>--</span>
                </td>
                <td class="border-t-0 px-6 align-middle text-sm whitespace-nowrap p-2">
                  <span v-if="payroll.extras" class="ml-3 font-bold text-gray-700">
                    {{ payroll.extras[week_days[index]] ? payroll.extras[week_days[index]]?.time + ' minutos ($' +
                      payroll.extras[week_days[index]]?.pay + ')' : '--' }}
                  </span>
                  <span v-else>--</span>
                </td>
                <td v-if="$page.props.user.is_admin && payroll.is_active"
                  class="px-6 align-middle text-sm whitespace-nowrap p-2 relative">

                  <button v-if="dayInEdition === index" @click="update()" class="text-lg text-green-500"><i
                      class="fa-regular fa-circle-check"></i></button>
                  <button v-if="dayInEdition === index" @click="dayInEdition = null" class="text-lg text-red-500 mx-3">
                    <i class="fa-regular fa-circle-xmark"></i></button>
                  <el-dropdown trigger="click" @command="handleCommand">
                    <button
                      class="w-6 h-6 rounded-full hover:bg-gray5 cursor-pointer flex items-center text-primary disabled:text-gray3 disabled:hover:bg-transparent disabled:cursor-not-allowed justify-center"
                      :disabled="dayInEdition !== null">
                      <i class="fa-solid fa-ellipsis-vertical"></i>
                    </button>
                    <template #dropdown>
                      <el-dropdown-menu>
                        <el-dropdown-item :command="'edit-' + attendance.id">
                          Editar</el-dropdown-item>
                        <el-dropdown-item :command="'late-' + attendance.id">
                          Quitar retardo</el-dropdown-item>
                        <el-dropdown-item :command="'extras-' + attendance.id">
                          Agregar T. Extra</el-dropdown-item>
                        <small class="px-4 text-gray4">Agregar incidencia</small>
                        <template v-for="item in justifications" :key="item.id">
                          <el-dropdown-item v-if="item.id !== 7" :command="item.id + '-' + attendance.id + '-' + index">
                            {{ item.name }}</el-dropdown-item>
                        </template>
                      </el-dropdown-menu>
                    </template>
                  </el-dropdown>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </section>
</template>


<script>

import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import ThirthButton from '@/Components/ThirthButton.vue';
import { Inertia } from '@inertiajs/inertia';
import { Link, useForm } from '@inertiajs/inertia-vue3';
import axios from 'axios';

export default {
  data() {
    const form = useForm({
      payroll: [],
    });

    return {
      form,
      dayInEdition: null,
      indexSelected: null,
      showOptions: false,
      week_days: ['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
      justifications: [],
    };
  },
  components: {
    PrimaryButton,
    SecondaryButton,
    ThirthButton,
    Link
  },
  props: {
    payroll: Object,
  },
  methods: {
    edit(day) {
      this.form.payroll = this.payroll.week_attendance.payroll;
      this.dayInEdition = day;
    },
    handleCommand(command) {
      const commandName = command.split('-')[0];
      const rowId = command.split('-')[1];

      if (commandName == 'late') {
        this.handleLate(rowId);
      } else if (commandName == 'extras') {
        this.handleExtras(rowId);
      }else if (commandName == 'edit') {
        this.dayInEdition = rowId;
      } else if (commandName == 'attendance') {
        const index = command.split('-')[2];
        const date = this.processedAttendances[index].date.estandard;
        this.handleAttendance(rowId, date);
      } else {
        const index = command.split('-')[2];
        const date = this.processedAttendances[index].date.estandard;
        this.handleIncidents(rowId, commandName, date);
      }
    },
    addExtraTime(index) {
      this.$emit('extraTime', { payroll_user: this.payroll, day: index });
    },
    update() {
      // this.form.payroll = this.payroll.week_attendance.payroll;
      Inertia.post(route('payroll-admin.update'), {
        payroll_user_id: this.payroll.payroll_user_id,
        attendance: this.form.payroll[this.dayInEdition],
        day: this.dayInEdition
      });
      this.dayInEdition = null;
    },
    async fetchJustifications() {
      try {
        const response = await axios.get(route('justifications.index'));
        if (response.status === 200) {
          this.justifications = response.data.items;
        }
      } catch (error) {
        console.log(error);
        this.$notify({
          title: 'Hubo un problema en el servidor',
          message: 'No se pudo procesar la petición de obtener la lista de justificaciones',
          type: 'error',
        });
      }
    }
  },
  mounted() {
    this.fetchJustifications();
  }
}
</script>