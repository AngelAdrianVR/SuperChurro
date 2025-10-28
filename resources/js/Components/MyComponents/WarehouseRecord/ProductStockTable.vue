<template>
  <!-- 
    MODIFICADO: 
    - Se elimina 'border-separate border-spacing-x-8 mt-2'.
    - Se aplica la misma estructura de tabla moderna que en el otro componente.
  -->
  <div class="w-full">
    <table class="min-w-full divide-y divide-gray-200">
      <!-- MODIFICADO: Header de tabla moderno -->
      <thead class="bg-gray-50">
        <tr>
          <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
            Nombre del producto
          </th>
          <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
            Stock
          </th>
          <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
            Fecha
          </th>
        </tr>
      </thead>
      <!-- MODIFICADO: Body de tabla moderno, con los placeholders dentro de celdas estilizadas -->
      <tbody class="bg-white divide-y divide-gray-200">
        <!-- 
          NOTA: Esta fila es de ejemplo, basada en tus placeholders. 
          Deberías reemplazarla con un v-for cuando tengas datos.
        -->
        <tr>
          <td class="px-6 py-4 whitespace-nowrap">
            <div class="text-sm text-gray-900">
              <!-- {{ Product.name }} -->
            </div>
          </td>
          <td class="px-6 py-4 whitespace-nowrap">
            <div class="text-sm text-gray-900">
              <!-- {{ Product.low_stock }} {{ Product.unit?.name }} -->
            </div>
          </td>
          <td class="px-6 py-4 whitespace-nowrap">
            <span class="text-sm text-gray-900">
              <!-- {{ Product.name }} -->
            </span>
          </td>
        </tr>
        <!-- Aquí iría el v-for de los productos -->
      </tbody>
    </table>
    <!-- MODIFICADO: Se añade un mensaje de fallback en caso de que la tabla esté vacía -->
    <p v-if="!products || products.length === 0" class="text-sm text-gray-500 text-center p-6">
      No hay información de stock para mostrar.
    </p>
  </div>
</template>

<script>
export default {
  // MODIFICADO: Se añade un 'props' de ejemplo para que el v-if/v-else funcione
  props: {
    products: {
      type: Array,
      default: () => []
    }
  }
}
</script>

<style>
/* No se necesita CSS personalizado */
</style>
