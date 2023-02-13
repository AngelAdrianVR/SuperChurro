<template>
  <section class="relative py-2 bg-blueGray-50">
    <div class="w-full px-4">
      <div class="relative flex flex-col min-w-0 break-words w-full mb-6 shadow-lg rounded 
  bg-cyan-900 text-white">
        <div class="rounded-t mb-0 px-4 py-3 border-0">
          <div class="flex flex-wrap items-center">
            <div class="relative w-full px-4 max-w-full flex-grow flex-1 flex justify-between">
              <h3 class="font-semibold text-lg text-white"><i class="fa-solid fa-user mr-1"></i> {{
                payroll?.user.name
              }}</h3>
              <Link v-if="$page.props.user.is_admin" :href="route('payroll-admin.show', payroll.payroll_user_id)">
              <PrimaryButton>Ver nómina</PrimaryButton>
              </Link>
            </div>
          </div>
        </div>
        <div class="block w-full overflow-x-auto ">
          <table class="items-center w-full bg-transparent border-collapse">
            <thead>
              <tr>
                <th
                  class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left bg-cyan-800 text-cyan-300 border-cyan-700">
                  Día</th>
                <th
                  class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left bg-cyan-800 text-cyan-300 border-cyan-700">
                  Entrada</th>
                <th
                  class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left bg-cyan-800 text-cyan-300 border-cyan-700">
                  Salida</th>
                <th v-if="$page.props.user.is_admin && payroll.is_active" class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left bg-cyan-800 text-cyan-300 border-cyan-700">
                  Editar
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
                <td v-if="$page.props.user.is_admin && payroll.is_active" class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-2">
                  <button v-if="day_in_edition === index" @click="update()" class="text-lg text-green-400 ml-5"><i
                      class="fa-regular fa-circle-check"></i></button>
                  <button v-else @click="edit(index)" class="text-lg text-blue-400 ml-5"><i
                      class="fa-solid fa-pencil"></i></button>
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
    };
  },
  components: {
    PrimaryButton,
    Link,
  },
  props: {
    payroll: Object,
  },
  methods: {
    edit(day) {
      this.form.payroll = this.payroll.week_attendance.payroll;
      this.day_in_edition = day;
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