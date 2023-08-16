<template>
  <section class="relative py-2 bg-blueGray-50">
    <div class="w-full px-4">
      <div class="relative flex flex-col min-w-0 break-words w-full mb-6 shadow-lg rounded 
  bg-[#686868] text-white">
        <div class="rounded-t mb-0 px-4 py-3 border-0">
          <div class="flex flex-wrap items-center">
            <div class="relative w-full px-4 max-w-full flex-grow flex-1 flex justify-between">
              <h3 class="font-semibold text-lg text-white"><i class="fa-solid fa-user mr-1"></i> {{
                payroll?.user.name
              }}</h3>
              <Link v-if="$page.props.user.is_admin" :href="route('payroll-admin.show', payroll.payroll_user_id)">
              <SecondaryButton>Ver nómina</SecondaryButton>
              </Link>
            </div>
          </div>
        </div>
        <div class="block w-full overflow-x-auto ">
          <table class="items-center w-full bg-transparent border-collapse">
            <thead>
              <tr>
                <th
                  class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left bg-secondary-gray text-wite border-stone-800">
                  Día</th>
                <th
                  class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left bg-secondary-gray text-wite border-stone-800">
                  Entrada</th>
                <th
                  class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left bg-secondary-gray text-wite border-stone-800">
                  Salida</th>
                <th
                  class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left bg-secondary-gray text-wite border-stone-800">
                  Extras</th>
                <th v-if="$page.props.user.is_admin && payroll.is_active"
                  class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left bg-secondary-gray text-wite border-stone-800">
                  Acciones
                </th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(attendance, index) in payroll?.week_attendance.payroll" :key="index">
                <th
                  class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-2 text-left flex items-center">
                  <span class="ml-3 font-bold text-white"> {{ attendance.day }} </span>
                </th>
                <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-2">
                  <input v-if="day_in_edition === index" v-model="form.payroll[index].in" type="text"
                    class="bg-transparent text-sm rounded-md">
                  <p v-else>{{ attendance.in }}</p>
                </td>
                <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-2">
                  <input v-if="day_in_edition === index" v-model="form.payroll[index].out" type="text"
                    class="bg-transparent text-sm rounded-md">
                  <p v-else>{{ attendance.out }}</p>
                </td>
                <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-2">
                  <span v-if="payroll.extras" class="ml-3 font-bold text-white">
                     {{ payroll.extras[week_days[index]] ? payroll.extras[week_days[index]]?.time + ' minutos ($' + payroll.extras[week_days[index]]?.pay + ')' : '--' }} 
                  </span>
                  <span v-else>--</span>
                </td>
                <td v-if="$page.props.user.is_admin && payroll.is_active"
                  class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-2">
                  <button v-if="day_in_edition === index" @click="update()" class="text-lg text-green-500 ml-5"><i
                      class="fa-regular fa-circle-check"></i></button>
                  <button v-else @click="edit(index)" class="text-lg text-blue-500 ml-5"><i
                      class="fa-solid fa-pencil"></i></button>
                  <button v-if="day_in_edition !== index" @click="addExtraTime(index)" class="text-lg text-sky-500 ml-5">
                    <i class="fa-solid fa-clock"></i>
                  </button>
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
      week_days: ['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado']
    };
  },
  components: {
    PrimaryButton,
    Link,
    SecondaryButton,
    ThirthButton
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