<template>
    <div>
      <div class="rounded-md border-2 border-gray-400 px-7 py-5 leading-none text-[14px] m-3">
        <div class="globe-title">
          <h1>Finiquito</h1>
        </div>
        <p style="font-size: 8px">
          Av. Manuel Ávila Camacho 1950, Interior de plaza patria, Isla comercial en frente
          de negocio comercial conocido como "ALDO CONTI", en el área común, Col.
          Jacarandas, Zapopan Jalisco.
        </p>
        <div class="mb-2 text-center rounded-sm py-2 px-3 my-2">
          Nombre del colaborador: <strong> {{ user.name }} </strong>
        </div>
        <div class="grid grid-cols-4 gap-3 my-4">
          <p class="text-left col-start-2">Fecha de Ingreso: </p>
          <p class="">{{ formattedCurrentDate(user.created_at) }}</p>
          <p class="text-left col-start-2">Fin de ejercicio:</p>
          <p>{{ formattedDate  }}</p>
          <p class="text-left col-start-2">Salario mensual:</p>
          <p>${{ separator(parseInt(month_salary)) }}</p>
          <p class="text-left col-start-2">Días de vacaciones no tomados:</p>
          <p>{{ proporcional_vacations }}</p>
          <p class="text-left col-start-2">Prima vacacional proporcional:</p>
          <p>${{ vacation_bonus }}</p>
          <p class="text-left col-start-2">Proporción de aguinaldo:</p>
          <p>${{ chrismas_bonus  }}</p>
        </div>

        <p class="font-bold my-9 text-center">Total a pagar  ...................................................  ${{ settlement }}</p>
 
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
      chrismas_bonus: String,
      month_salary: Number,
      proporcional_vacations: String,
      vacation_bonus: String,
      settlement: String,
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
