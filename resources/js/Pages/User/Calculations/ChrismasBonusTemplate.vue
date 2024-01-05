<template>
  <div class="">
    <div class="rounded-md border-2 border-gray-400 px-7 py-2 leading-none text-xs">
      <div class="globe-title">
        <h1>Aguinaldo {{ today.getFullYear() }}</h1>
      </div>
      <p style="font-size: 8px">
        Av. Manuel Ávila Camacho 1950, Interior de plaza patria, Isla comercial en frente
        de negocio comercial conocido como "ALDO CONTI", en el área común, Col.
        Jacarandas, Zapopan Jalisco.
      </p>
      <div class="mb-2 bg-[#EDEDED] rounded-sm py-2 px-3 my-2 font-bold">
        <i class="fa-regular fa-user mr-1"></i> {{ user.name }}
      </div>
      <div class="flex flex-col space-y-3 my-4">
        <p><strong> Fecha de Ingreso: </strong>{{ formattedCurrentDate(user.created_at) }}</p>
        <p><strong> Fin de Ejercicio: </strong>{{ formattedDate  }}</p>
        <p><strong> Salario diario integrado: </strong>${{ user.employee_properties.base_salary  }}</p>
        <p><strong> Aguinaldo correspondiente </strong>${{ chrismas_bonus  }}</p>

      </div>


      <div class="flex justify-end mt-12 mb-3">
        <span class="border-t-2 px-20 border-gray-400 text-gray-700 font-bold py-2">Total: ${{ chrismas_bonus }}</span>
      </div>


      <small style="font-size: 7px">
        RECIBI DE LA EMPRESA "PURO CHURRO" LA CANTIDAD SEÑALADA MISMA QUE CUBRE LAS
        PERCEPCIONES QUE ME CORRESPONDEN EN EL PERIODO INDICADO, NO EXISTIENDO NINGUN
        ADEUDO POR PARTE DE LA EMPRESA PARA CON EL SUSCRITO, PUES ESTOY TOTALMENTE PAGADO
        DE MIS SALARIOS Y ESTE DOCUMENTO ES UNICAMENTE PARA FINES INFORMATIVOS SIN QUE
        PUEDA SER USADO COMO MEDIO PROBATORIO ANTE UNA AUTORIDAD Y/O INSTITUCION DE
        CREDITO.
      </small>
      <div class="flex justify-between mt-4">
        <span class="border-t-2 px-14 border-gray-400 text-gray-500">Fecha</span>
        <span class="border-t-2 px-14 border-gray-400 text-gray-500">Firma</span>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  data() {
    return {
      today: new Date(),
    };
  },
  props: {
    user: Object,
    chrismas_bonus: Number,
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