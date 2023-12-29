<template>
  <table class="border-separate border-spacing-x-8 mt-2">
        <thead>
          <tr>
            <th class="pr-4">Nombre del producto</th>
            <th class="px-4">Stock</th>
            <th class="px-4">Fecha</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <tr class="text-gray-600 cursor-pointer mb-4">
            <td class="text-left pb-3">
              <!-- {{ Product.name }} -->
            </td>
            <td class="text-center pb-3">
              <!-- {{ Product.low_stock }} {{ Product.unit?.name }} -->
            </td>
            <td class="text-center pb-3">
              <!-- {{ Product.name }} -->
            </td>
          </tr>
        </tbody>
      </table>
</template>

<script>
export default {

}
</script>

<style>

</style>