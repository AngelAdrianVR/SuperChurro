<template>
  <!-- component -->
  <section class="relative py-2 bg-blueGray-50">
    <div class="w-full px-4">
      <div class="relative flex flex-col min-w-0 break-words w-full mb-6 shadow-lg rounded 
  bg-cyan-900 text-white">
        <div class="rounded-t mb-0 px-4 py-3 border-0">
          <div class="flex flex-wrap items-center">
            <div class="relative w-full px-4 max-w-full flex-grow flex-1 ">
              <h3 class="font-semibold text-lg text-white">Nómina semana {{ payroll.week }}</h3>
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
                <!-- <th
                  class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left bg-cyan-800 text-cyan-300 border-cyan-700">
                  Tiempo Extra</th> -->
              </tr>
            </thead>

            <tbody>
              <tr v-for="(attendance, index) in payroll.week_attendance.payroll" :key="index">
                <th
                  class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-2 text-left flex items-center">
                  <span class="ml-3 font-bold text-white"> {{ attendance.day }} </span>
                </th>
                <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-2">
                  {{ attendance.in }}
                </td>
                <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-2">
                  {{ attendance.out }}
                </td>
                <!-- <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-2">
                  <div class="flex">
                    25 minutos
                  </div>
                </td> -->
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </section>
</template>


<script>
export default {
  data() {
    return {
    };
  },
  components: {
  },
  props: {
    payroll: Object,
  },
}
</script>