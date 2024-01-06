<template>
  <LoadingIndicator v-if="pageLoading" />
  <section class="relative py-2">
    <div class="w-full">
      <div class="relative flex flex-col min-w-0 break-words w-full mb-6 rounded-lg bg-transparent text-[#373737]">
        <div class="rounded-t-lg mb-0 py-3 border-t border-x border-gray3">
          <div class="py-1 flex flex-wrap items-center bg-[#EDEDED]">
            <div class="relative w-full px-4 max-w-full flex-grow flex-1 flex justify-between">
              <h3 class="font-semibold text-base text-[#373737]">
                <i class="fa-regular fa-circle-user mr-1"></i>
                {{ payroll?.user.name }}
              </h3>
            </div>
          </div>
        </div>
        <div class="block w-full overflow-x-auto ">
          <table @click="showOptions = false"
            class="items-center w-full bg-transparent border-collapse border-b border-gray3">
            <thead>
              <tr class="border-b border-x border-gray3">
                <th class="px-6 align-middle py-3 text-xs uppercase whitespace-nowrap text-left font-bold">
                  Día</th>
                <th class="px-6 align-middle py-3 text-xs uppercase whitespace-nowrap text-left font-bold">
                  Entrada</th>
                <th class="px-6 align-middle py-3 text-xs uppercase whitespace-nowrap text-left font-bold">
                  Salida</th>
                <th class="px-6 align-middle py-3 text-xs uppercase whitespace-nowrap text-left font-bold">
                  T. extra</th>
                <th class="px-6 align-middle py-3 text-xs uppercase whitespace-nowrap text-left font-bold">
                  H. totales</th>
                <th v-if="$page.props.user.is_admin && payroll.is_active"
                  class="px-6 align-middle py-3 text-xs uppercase whitespace-nowrap text-left font-bold">
                </th>
              </tr>
            </thead>
            <tbody>
              <tr class="border-x border-gray3" v-for="(attendance, index) in payroll?.week_attendance.payroll"
                :key="index">
                <th class="border-t-0 px-6 align-middle text-xs whitespace-nowrap p-2 text-left flex items-center">
                  <span class="font-bold text-gray-700"> {{ attendance.day }} </span>
                </th>
                <td class="px-6 align-middle text-sm whitespace-nowrap p-2 border-white rounded-l-md"
                  :class="getColor(attendance.in)">
                  <input v-if="dayInEdition == index" v-model="form.payroll[index].in" type="time"
                    class="bg-transparent text-sm rounded-md">
                  <p v-else>{{ attendance.in }}</p>
                </td>
                <td class="px-6 align-middle text-sm whitespace-nowrap p-2 border-white" :class="getColor(attendance.in)">
                  <input v-if="dayInEdition == index" v-model="form.payroll[index].out" type="time"
                    class="bg-transparent text-sm rounded-md">
                  <p v-else>{{ attendance.out }}</p>
                </td>
                <td class="px-6 align-middle text-sm whitespace-nowrap p-2 border-white rounded-r-md"
                  :class="getColor(attendance.in)">
                  <span v-if="payroll.extras" class="text-gray-700">
                    {{ payroll.extras[week_days[index]] ? payroll.extras[week_days[index]]?.time + ' minutos ($' +
                      payroll.extras[week_days[index]]?.pay + ')' : '--' }}
                  </span>
                  <span v-else>--</span>
                </td>
                <td class="border-t-0 px-6 align-middle text-sm whitespace-nowrap p-2">
                  <span class="text-gray-700">
                    {{ calculateWorkedTime(attendance.in, attendance.out) }}
                  </span>
                </td>
                <td v-if="$page.props.user.is_admin && payroll.is_active"
                  class="px-6 align-middle text-sm whitespace-nowrap p-2 relative">
                  <div v-if="dayInEdition == index" class="flex items-center space-x-1">
                    <CancelButton @click="dayInEdition = null">Cancelar</CancelButton>
                    <PrimaryButton @click="update()">Guardar</PrimaryButton>
                  </div>
                  <el-dropdown v-if="attendance.in != 'Día de descanso'" trigger="click" @command="handleCommand">
                    <button
                      class="w-6 h-6 rounded-full hover:bg-gray5 cursor-pointer flex items-center text-primary disabled:text-gray3 disabled:hover:bg-transparent disabled:cursor-not-allowed justify-center"
                      :disabled="dayInEdition !== null">
                      <i class="fa-solid fa-ellipsis-vertical"></i>
                    </button>
                    <template #dropdown>
                      <el-dropdown-menu>
                        <el-dropdown-item :command="'attendance-' + index" :disabled="attendance.in != 'Falta'">
                          Poner asistencia</el-dropdown-item>
                        <el-dropdown-item :command="'edit-' + index"
                          v-if="!justifications.some(item => item.name == attendance.in) && attendance.in != 'Falta'">
                          Editar</el-dropdown-item>
                        <el-dropdown-item :command="'extras-' + index"
                          v-if="!justifications.some(item => item.name == attendance.in) && attendance.in != 'Falta'">
                          Agregar T. Extra</el-dropdown-item>
                        <small
                          v-if="justifications.some(item => item.name == attendance.in) || attendance.in == 'Falta' || attendance.in == '--:--:--'"
                          class="px-4 text-gray4">Agregar incidencia</small>
                        <template v-for="item in justifications" :key="item.id">
                          <el-dropdown-item
                            v-if="justifications.some(item => item.name == attendance.in) || attendance.in == 'Falta' || attendance.in == '--:--:--'"
                            :command="item.id + '-' + index">
                            {{ item.name }}
                          </el-dropdown-item>
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
import CancelButton from '@/Components/CancelButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import ThirthButton from '@/Components/ThirthButton.vue';
import { Link, useForm } from '@inertiajs/inertia-vue3';
import LoadingIndicator from "@/Components/MyComponents/LoadingIndicator.vue";
import axios from 'axios';
import { parseISO, differenceInSeconds, isValid } from 'date-fns';

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
      justifications: [
        { name: 'Vacaciones', id: 3 },
        { name: 'Permiso sin goce', id: 4 },
        { name: 'Permiso con goce', id: 5 },
        { name: 'Incapacidad', id: 6 },
      ],
      pageLoading: false,
    };
  },
  components: {
    PrimaryButton,
    SecondaryButton,
    ThirthButton,
    Link,
    CancelButton,
    LoadingIndicator,
  },
  props: {
    payroll: Object,
  },
  emits: ['extraTime'],
  methods: {
    calculateWorkedTime(entry, exit) {
      if (entry === '--:--:--' || exit === '--:--:--' || entry === 'Falta' || entry === 'Incapacidad' || entry === 'Día de descanso' || entry === 'Vacaciones' || entry === 'Día feriado') {
        return '--';
      }

      const entryTime = parseISO(`2022-01-01T${entry}`);
      const exitTime = exit === '00:00:00' ? new Date() : parseISO(`2022-01-01T${exit}`);

      if (!isValid(entryTime) || !isValid(exitTime)) {
        return '--';
      }

      const difference = differenceInSeconds(exitTime, entryTime);
      const hoursWorked = Math.floor(difference / 3600);
      const minutesWorked = Math.floor((difference % 3600) / 60);

      return `${hoursWorked}h ${minutesWorked}m`;
    },
    getColor(incident) {
      let styles = '';
      if (incident == 'Falta') {
        styles = 'bg-red-200 text-red-700';
      } else if (incident == 'Vacaciones') {
        styles = 'bg-yellow-200 text-yellow-700';
      } else if (incident == 'Permiso sin goce') {
        styles = 'bg-blue-200 text-blue-700';
      } else if (['Día de descanso', 'Permiso con goce', 'Incapacidad', 'Día feriado'].some(item => item == incident)) {
        styles = 'bg-green-200 text-green-700';
      }

      return styles;
    },
    edit(day) {
      this.form.payroll = this.payroll.week_attendance.payroll;
      this.dayInEdition = day;
    },
    handleCommand(command) {
      const commandName = command.split('-')[0];
      const rowId = command.split('-')[1];

      if (commandName == 'extras') {
        this.addExtraTime(rowId);
      } else if (commandName == 'edit') {
        this.edit(rowId);
      } else if (commandName == 'attendance') {
        this.removeAbsent(rowId);
      } else {
        this.setIncident(rowId, commandName);
      }
    },
    async setIncident(day, incidentId) {
      try {
        this.pageLoading = true;
        const response = await axios.put(route('payroll-admin.set-incident'), {
          payroll_user_id: this.payroll.payroll_user_id,
          day: day,
          incident_id: incidentId,
          attendance: this.payroll.week_attendance.payroll[day],
        });

        if (response.status === 200) {
          const justificationName = this.justifications.find(item => item.id == incidentId)?.name;
          this.payroll.week_attendance.payroll[day].in = justificationName;
          this.payroll.week_attendance.payroll[day].out = justificationName;
          this.$notify({
            title: response.data.notification.title,
            message: response.data.notification.message,
            type: response.data.notification.type
          });
        }
      } catch (error) {
        console.log(error);
      } finally {
        this.pageLoading = false;
      }
    },
    async removeAbsent(day) {
      try {
        this.pageLoading = true;
        const response = await axios.put(route('payroll-admin.remove-absent'), {
          payroll_user_id: this.payroll.payroll_user_id,
          day: day,
          attendance: this.payroll.week_attendance.payroll[day],
        });

        if (response.status === 200) {
          this.payroll.week_attendance.payroll[day].in = '10:00';
          this.payroll.week_attendance.payroll[day].out = '10:01';
          this.$notify({
            title: 'Correcto',
            message: 'Se ha registrado asistencia. No olvides editar las horas de entrada y salida a tu gusto',
            type: 'success'
          });
        }
      } catch (error) {
        console.log(error);
      } finally {
        this.pageLoading = false;
      }
    },
    addExtraTime(index) {
      this.$emit('extraTime', { payroll_user: this.payroll, day: index });
    },
    async update() {
      try {
        this.pageLoading = true;
        const response = await axios.put(route('payroll-admin.update'), {
          payroll_user_id: this.payroll.payroll_user_id,
          attendance: this.form.payroll[this.dayInEdition],
          day: this.dayInEdition
        });

        if (response.status === 200) {
          this.dayInEdition = null;
          this.$notify({
            title: 'Correcto',
            message: 'Se ha actualizado el registro',
            type: 'success'
          });
        }
      } catch (error) {
        console.log(error);
      } finally {
        this.pageLoading = false;
      }
    },
  }
}
</script>