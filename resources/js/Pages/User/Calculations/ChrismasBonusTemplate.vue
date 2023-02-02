<template>
  <div class="grid grid-cols-2 gap-1">
    <div class="rounded-md border-2 border-gray-400 px-3 py-2 leading-none text-xs">
      <div class="globe-title">
        <h1>Cálculo de Aguinaldo año {{ today.getFullYear() }}</h1>
      </div>
      <p style="font-size: 8px">
        Av. Manuel Ávila Camacho 1950, Interior de plaza patria, Isla comercial en frente
        de negocio comercial conocido como "ALDO CONTI", en el área común, Col.
        Jacarandas, Zapopan Jalisco.
      </p>
      <div class="mb-2 bg-sky-200 px-1 py-px rounded-sm">
        <i class="fa-solid fa-user mr-1"></i> {{ user.name }}
      </div>
      <div class="flex flex-col space-y-2 mb-4">
        <p><strong> Fecha de Ingreso: </strong>{{ user.created_at.split('T')[0] }}</p>
        <p><strong> Fin de Ejercicio: </strong>{{ '31-Diciembre -' + today.getFullYear() }}</p>
        <p><strong> Salario diario integrado: </strong>${{ user.employee_properties.base_salary  }}</p>
        <p><strong> Aguinaldo correspondiente: </strong>${{ chrismas_bonus  }}</p>
        
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
        <span class="border-t-2 px-20 border-gray-400 text-gray-500">Fecha</span>
        <span class="border-t-2 px-20 border-gray-400 text-gray-500">Firma</span>
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
};
</script>