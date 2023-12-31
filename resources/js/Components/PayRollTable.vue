<template>
  <section class="relative py-2 bg-blueGray-50">
    <div class="w-full px-4">
      <div class="relative flex flex-col min-w-0 break-words w-full mb-6 rounded-lg 
  bg-transparent text-gray-700">
        <div class="rounded-t-lg mb-0 py-3 border-t border-x border-gray3">
          <div class="py-1 flex flex-wrap items-center bg-gray4">
            <div class="relative w-full px-4 max-w-full flex-grow flex-1 flex justify-between">
              <h3 class="font-semibold text-lg text-gray-700"><i class="fa-regular fa-circle-user mr-1"></i> {{
                payroll?.user.name
              }}</h3>
              <Link v-if="$page.props.user.is_admin" :href="route('payroll-admin.show', payroll.payroll_user_id)">
              <ThirthButton>Ver nómina</ThirthButton>
              </Link>
            </div>
          </div>
        </div>
        <div class="block w-full overflow-x-auto ">
          <table @click="showOptions = false" class="items-center w-full bg-transparent border-collapse border-b border-gray3">
            <thead>
              <tr class="border-b border-x border-gray3">
                <th
                  class="px-6 align-middle py-3 text-sm uppercase whitespace-nowrap text-left font-bold">
                  Día</th>
                <th
                  class="px-6 align-middle py-3 text-sm uppercase whitespace-nowrap text-left font-bold">
                  Entrada</th>
                <th
                  class="px-6 align-middle py-3 text-sm uppercase whitespace-nowrap text-left font-bold">
                  Salida</th>
                <th
                  class="px-6 align-middle py-3 text-sm uppercase whitespace-nowrap text-left font-bold">
                   T. extra</th>
                <th
                  class="px-6 align-middle py-3 text-sm uppercase whitespace-nowrap text-left font-bold">
                   H. totales</th>
                <th v-if="$page.props.user.is_admin && payroll.is_active"
                  class="px-6 align-middle py-3 text-sm uppercase whitespace-nowrap text-left font-bold">
                </th>
              </tr>
            </thead>
            <tbody>
              <tr class="border-x border-gray3" v-for="(attendance, index) in payroll?.week_attendance.payroll" :key="index">
                <th
                  class="border-t-0 px-6 align-middle text-sm whitespace-nowrap p-2 text-left flex items-center">
                  <span class="ml-3 font-bold text-gray-700"> {{ attendance.day }} </span>
                </th>
                <td class="border-t-0 px-6 align-middle text-sm whitespace-nowrap p-2">
                  <input v-if="day_in_edition === index" v-model="form.payroll[index].in" type="text"
                    class="bg-transparent text-sm rounded-md">
                  <p v-else>{{ attendance.in }}</p>
                </td>
                <td class="border-t-0 px-6 align-middle text-sm whitespace-nowrap p-2">
                  <input v-if="day_in_edition === index" v-model="form.payroll[index].out" type="text"
                    class="bg-transparent text-sm rounded-md">
                  <p v-else>{{ attendance.out }}</p>
                </td>
                <td class="border-t-0 px-6 align-middle text-sm whitespace-nowrap p-2">
                  <span v-if="payroll.extras" class="ml-3 font-bold text-gray-700">
                     {{ payroll.extras[week_days[index]] ? payroll.extras[week_days[index]]?.time + ' minutos ($' + payroll.extras[week_days[index]]?.pay + ')' : '--' }} 
                  </span>
                  <span v-else>--</span>
                </td>
                <td class="border-t-0 px-6 align-middle text-sm whitespace-nowrap p-2">
                  <span v-if="payroll.extras" class="ml-3 font-bold text-gray-700">
                     {{ payroll.extras[week_days[index]] ? payroll.extras[week_days[index]]?.time + ' minutos ($' + payroll.extras[week_days[index]]?.pay + ')' : '--' }} 
                  </span>
                  <span v-else>--</span>
                </td>
                <td v-if="$page.props.user.is_admin && payroll.is_active"
                  class="px-6 align-middle text-sm whitespace-nowrap p-2 relative">

                  <button v-if="day_in_edition === index" @click="update()" class="text-lg text-green-500"><i
                      class="fa-regular fa-circle-check"></i></button>
                  <button v-if="day_in_edition === index" @click="day_in_edition = null" class="text-lg text-red-500 mx-3">
                    <i class="fa-regular fa-circle-xmark"></i></button>

                  <i @click.stop="showOptions = !showOptions; indexSelected = index" class="fa-solid fa-ellipsis-vertical text-primary p-1 cursor-pointer"></i>
                  <div v-if="showOptions && index == indexSelected" class="absolute z-10 bg-gray-100 top-7 right-9 rounded-md border border-gray3 py-2">
                    <p @click="edit(index)" class="text-sm px-2 py-1 hover:bg-gray4 hover:font-bold cursor-pointer">Editar</p>
                    <p class="text-sm px-2 py-1 hover:bg-gray4 hover:font-bold cursor-pointer">Quitar retardo</p>
                    <p @click="addExtraTime(index)" class="text-sm px-2 py-1 hover:bg-gray4 cursor-pointer">Agregar T. extra</p>
                    <p class="text-xs text-gray3 px-2 mt-2">Agregar incidencia</p>
                    <p class="text-sm px-2 py-1 hover:bg-gray4 hover:font-bold cursor-pointer">Descanso</p>
                    <p class="text-sm px-2 py-1 hover:bg-gray4 hover:font-bold cursor-pointer">Vacaciones</p>
                    <p class="text-sm px-2 py-1 hover:bg-gray4 hover:font-bold cursor-pointer">Falta</p>
                    <p class="text-sm px-2 py-1 hover:bg-gray4 hover:font-bold cursor-pointer">Permiso</p>
                    <p class="text-sm px-2 py-1 hover:bg-gray4 hover:font-bold cursor-pointer">Incapacidad</p>
                  </div>
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

export default {
  data() {
    const form = useForm({
      payroll: [],
    });

    return {
      form,
      day_in_edition: null,
      indexSelected: null,
      showOptions: false,
      week_days: ['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado']
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
      this.day_in_edition = day;
    },
    addExtraTime(index) {
      this.$emit('extraTime', { payroll_user: this.payroll, day: index });
    },
    update() {
      // this.form.payroll = this.payroll.week_attendance.payroll;
      Inertia.post(route('payroll-admin.update'), {
        payroll_user_id: this.payroll.payroll_user_id,
        attendance: this.form.payroll[this.day_in_edition],
        day: this.day_in_edition
      });
      this.day_in_edition = null;
    }
  }
}
</script>