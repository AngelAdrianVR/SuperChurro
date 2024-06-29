<template>
    <div>
      <div class="rounded-md border-2 border-gray-400 px-7 py-5 leading-none text-[14px] m-3">
        <div class="globe-title">
          <h1>Liquidación</h1>
        </div>
        <p style="font-size: 8px">
          Av. Manuel Ávila Camacho 1950, Interior de plaza patria, Isla comercial en frente
          de negocio comercial conocido como "ALDO CONTI", en el área común, Col.
          Jacarandas, Zapopan Jalisco.
        </p>
        <div class="mb-2 text-center rounded-sm py-2 px-3 my-2 text-xs">
          Nombre del colaborador: <strong> {{ user.name }} </strong>
        </div>
        <div class="grid grid-cols-2 gap-x-3 gap-y-1 my-4 text-xs">
          <p class="text-right">Fecha de Ingreso: </p>
          <p>{{ formattedCurrentDate(user.created_at) }}</p>
          <p class="text-right">Fin de ejercicio:</p>
          <p>{{ formattedDate  }}</p>
          <p class="text-right">Salario mensual:</p>
          <p>${{ separator(parseInt(month_salary)) }}</p>
          <p class="text-right">Días de vacaciones no tomados:</p>
          <p>${{ proporcional_vacations.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",") }}</p>
          <p class="text-right">Prima vacacional proporcional:</p>
          <p>${{ vacation_bonus.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",") }} ({{ vacations.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",") }} días)</p>
          <p class="text-right">Proporción de aguinaldo:</p>
          <p>${{ chrismas_bonus?.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",")  }}</p>
          <p class="text-right">Indemnización:</p>
          <p>${{ indemnization?.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",")  }}</p>
        </div>

        <p class="font-bold my-5 text-center">Total a pagar  ...................................................  ${{ settlement.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",") }}</p>
 
        <small style="font-size: 7px">
          RECIBI DE LA EMPRESA "PURO CHURRO" LA CANTIDAD SEÑALADA MISMA QUE CUBRE LAS
          PERCEPCIONES QUE ME CORRESPONDEN EN EL PERIODO INDICADO, NO EXISTIENDO NINGUN
          ADEUDO POR PARTE DE LA EMPRESA PARA CON EL SUSCRITO, PUES ESTOY TOTALMENTE PAGADO
          DE MIS SALARIOS Y ESTE DOCUMENTO ES UNICAMENTE PARA FINES INFORMATIVOS SIN QUE
          PUEDA SER USADO COMO MEDIO PROBATORIO ANTE UNA AUTORIDAD Y/O INSTITUCION DE
          CREDITO.
        </small>
        <div class="flex justify-between mt-8">
          <span class="border-t-2 px-14 py-2 border-gray-400 text-gray-500">Fecha</span>
          <span class="border-t-2 px-14 py-2 border-gray-400 text-gray-500">Firma</span>
        </div>
      </div>
    </div>
  </template>

  <script>
  export default {
    data() {
      return {
        today: new Date(),
      }
    },
    props: {
      user: Object,
      chrismas_bonus: Number,
      month_salary: Number,
      proporcional_vacations: Number,
      vacation_bonus: Number,
      vacations: Number,
      indemnization: Number,
      settlement: Number,
    },
    methods:{
      separator(numb) {
      var str = numb.toString().split(".");
      str[0] = str[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
      return str.join(".");
  },
    },
    computed: {
      formattedDate() {
      const options = { day: '2-digit', month: 'long', year: 'numeric' };
      return this.today.toLocaleDateString('es-ES', options);
    },
     formattedCurrentDate() {
      return datetime => {
        const date = new Date(datetime);
        const options = { day: '2-digit', month: 'long', year: 'numeric' };
        return date.toLocaleDateString('es-ES', options);
      };
    },
  },
  };
  </script>
