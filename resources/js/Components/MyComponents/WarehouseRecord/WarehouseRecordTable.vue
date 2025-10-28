<template>
  <!-- 
    MODIFICADO: 
    - Se elimina 'mt-4 lg:mx-auto mx-2'. La tabla ahora ocupa el ancho de su contenedor.
    - Se usa 'min-w-full divide-y divide-gray-200' para un estilo de tabla moderno.
    - El `overflow-x-auto` debe estar en el componente PADRE (como en ShowProductRecord.vue) 
      que contiene esta tabla.
  -->
  <div class="w-full">
    <table class="min-w-full divide-y divide-gray-200">
      <!-- MODIFICADO: Se añade un fondo 'bg-gray-50' al header de la tabla -->
      <thead class="bg-gray-100">
        <tr>
          <!-- MODIFICADO: Estilos de header de tabla modernos: 'px-6 py-3', 'text-left', 'uppercase', etc. -->
          <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
            Solicitado por
          </th>
          <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
            Tipo
          </th>
          <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
            Solicitado el
          </th>
          <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
            Para
          </th>
          <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
            Notas
          </th>
          <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
            Cantidad
          </th>
        </tr>
      </thead>
      <!-- MODIFICADO: Se eliminan las clases de 'bg-gray4' y se usa 'divide-y' para las líneas -->
      <tbody class="bg-white divide-y divide-gray-200">
        <tr v-for="(movement, index) in movements" :key="index">
          <!-- 
            MODIFICADO: 
            - Se eliminan 'rounded-l-full', 'py-2', 'px-5'.
            - Se usan 'px-6 py-4' para padding estándar.
            - Se añade 'whitespace-nowrap' para evitar saltos de línea.
          -->
          <td class="px-6 py-4 whitespace-nowrap">
            <div class="text-sm text-gray-900">{{ movement.user.name }}</div>
          </td>
          <td class="px-6 py-4 whitespace-nowrap">
            <div class="text-sm text-gray-900">{{ movement.concept.name }}</div>
          </td>
          <td class="px-6 py-4 whitespace-nowrap">
            <span class="text-sm text-gray-900">
              {{ movement.created_at.split("T")[0] }}
            </span>
          </td>
          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
            {{ movement.warehouse_id }}
          </td>
          <!-- MODIFICADO: Se quita el ancho fijo 'w-40' y se permite texto normal -->
          <td class="px-6 py-4 whitespace-normal text-sm text-gray-500">
            {{ movement.notes ?? "--" }}
          </td>
          <!-- 
            MODIFICADO: 
            - Se limpia el estilo de 'Cantidad'.
            - Se eliminan 'rounded-r-full' y 'w-36'.
            - Se aplica el color directamente al span.
          -->
          <td class="px-6 py-4 whitespace-nowrap text-sm">
            <span :class="movement.concept.is_entry ? 'text-green-600' : 'text-red-600'"
              class="flex items-center gap-1 font-medium">
              <i v-if="movement.concept.is_entry" class="fa-solid fa-plus fa-xs"></i>
              <i v-else class="fa-solid fa-minus fa-xs"></i>
              <span>{{ movement.quantity }} {{ product.unit.name }}</span>
            </span>
          </td>
        </tr>
      </tbody>
    </table>
    <!-- MODIFICADO: Se añade más padding 'p-6' al mensaje de "no hay movimientos" -->
    <p v-if="movements.length === 0" class="text-sm text-gray-500 text-center p-6">
      No hay ningún movimiento registrado para este producto.
    </p>
  </div>
</template>

<script>
// El script permanece sin cambios
export default {
  data() {
    return {

    }
  },
  components: {

  },
  props: {
    movements: Array,
    product: Object,
  },
  methods: {

  }
}
</script>
