<template>
  <!-- 
    Vista Desktop:
    - Encabezado: Más sutil, con texto gris y mayúsculas.
    - Filas: Convertidas en "tarjetas" individuales (bg-white, rounded-lg, shadow-sm).
    - Tipografía: Mejor contraste y pesos de fuente.
    - Botón Eliminar: Icono más limpio con hover.
  -->
  <div v-if="saleProducts?.length" class="w-full mx-auto text-sm hidden md:block">
    <!-- Encabezado de la tabla -->
    <div class="flex items-center space-x-4 mb-2 border-b border-gray-200 px-3 pb-2">
      <div class="font-semibold text-xs uppercase text-gray-500 text-left w-[45%]">Producto</div>
      <div class="font-semibold text-xs uppercase text-gray-500 text-left w-[15%]">Precio</div>
      <div class="font-semibold text-xs uppercase text-gray-500 text-left w-[20%]">Cantidad</div>
      <div class="font-semibold text-xs uppercase text-gray-500 text-left w-[15%]">Importe</div>
      <div class="font-semibold text-xs uppercase text-gray-500 text-left w-[5%]"></div>
    </div>
    <!-- Cuerpo de la tabla -->
    <div class="overflow-auto h-[190px] px-1 space-y-2"> <!-- Añadido space-y-2 -->
      <div v-for="(sale, index) in saleProducts" :key="index"
        class="flex items-center space-x-4 bg-white rounded-lg shadow-sm py-2 px-3 relative">
        <!-- Producto -->
        <div class="flex items-center space-x-3 h-10 w-[45%]">
          <img class="h-10 w-10 object-contain rounded-md" v-if="sale.product.image_url"
            :src="sale.product.image_url" :alt="sale.product.name">
          <p class="font-semibold text-gray-800">{{ sale.product.name }}</p>
        </div>
        <!-- Precio -->
        <div :class="editMode !== null ? 'w-[35%]' : 'w-[15%]'" class="text-base flex items-center">
          <template v-if="editMode !== index">
            <span class="text-gray-700">${{ getPrice(sale.product) }}</span>
          </template>
          <!-- (Se mantiene la lógica de edición de precio) -->
          <template v-else-if="editMode == index">
            <div class="flex items-center space-x-2">
              <el-input v-model="editedPrice" @keyup.enter="stopEditing(sale)" type="number" step="0.01">
                <template #prefix>
                  <i class="fa-solid fa-dollar-sign"></i>
                </template>
              </el-input>
              <button @click="stopEditing(sale)"
                class="flex items-center justify-center rounded-full size-5 bg-indigo-600 flex-shrink-0"><i
                  class="fa-solid fa-check text-white text-[10px]"></i></button>
              <button @click="editMode = false"
                class="flex items-center justify-center rounded-full size-5 bg-gray-200 flex-shrink-0"><i
                  class="fa-solid fa-xmark text-black text-[10px]"></i></button>
            </div>
          </template>
        </div>
        <!-- Cantidad -->
        <div class="w-[20%]">
          <el-input-number v-model="sale.quantity" :min="0" :precision="2" size="default" />
        </div>
        <!-- Importe -->
        <div class="text-green-600 font-bold text-base w-[15%]">
          ${{ (getPrice(sale.product) * sale.quantity).toLocaleString('en-US', { minimumFractionDigits: 2 })
          }}
        </div>
        <!-- Acciones (Eliminar) -->
        <div class="w-[5%] text-right">
          <el-popconfirm confirm-button-text="Si" cancel-button-text="No" icon-color="#C30303" title="¿Continuar?"
            @confirm="deleteItem(sale.product.id)">
            <template #reference>
              <i
                class="fa-regular fa-trash-can text-gray-400 cursor-pointer p-2 hover:bg-gray-100 hover:text-red-600 rounded-full"></i>
            </template>
          </el-popconfirm>
        </div>
      </div>
    </div>
  </div>

  <!-- 
    Vista Móvil:
    - Convertida en "tarjetas" (bg-white, rounded-lg, shadow-sm, p-3).
    - Layout de grid más limpio.
    - Botón de eliminar en esquina superior derecha.
  -->
  <div v-if="saleProducts?.length" class="overflow-y-auto md:hidden text-sm h-[150px] space-y-2">
    <div v-for="(sale, index) in saleProducts" :key="index"
      class="bg-white rounded-lg shadow-sm p-3 grid grid-cols-3 gap-3 items-center relative">
      <!-- Imagen -->
      <figure class="flex items-center justify-center">
        <img class="mx-auto h-16 object-contain" v-if="sale.product.image_url" :src="sale.product.image_url"
          :alt="sale.product.name">
      </figure>
      <!-- Detalles -->
      <div class="col-span-2 flex flex-col space-y-2 justify-center">
        <p class="font-semibold text-gray-800">{{ sale.product.name }}</p>
        <!-- Precio -->
        <div class="flex items-center space-x-2">
          <template v-if="editMode !== index">
            <span class="text-gray-700 text-base">${{ getPrice(sale.product) }}</span>
          </template>
          <!-- (Se mantiene la lógica de edición de precio) -->
          <template v-else-if="editMode == index">
            <div class="flex items-center space-x-2">
              <div class="w-1/2">
                <el-input v-model="editedPrice" @keyup.enter="stopEditing(sale)" type="number" step="0.01">
                  <template #prefix>
                    <i class="fa-solid fa-dollar-sign"></i>
                  </template>
                </el-input>
              </div>
              <button @click="stopEditing(sale)"
                class="flex items-center justify-center rounded-full size-5 bg-indigo-600 flex-shrink-0"><i
                  class="fa-solid fa-check text-white text-[10px]"></i></button>
              <button @click="editMode = false"
                class="flex items-center justify-center rounded-full size-5 bg-gray-200 flex-shrink-0"><i
                  class="fa-solid fa-xmark text-black text-[10px]"></i></button>
            </div>
          </template>
        </div>
        <!-- Cantidad -->
        <el-input-number v-model="sale.quantity" :min="0" :precision="2" size="small" />
        <!-- Importe -->
        <div class="text-green-600 font-bold text-base">
          ${{ (getPrice(sale.product) * sale.quantity).toLocaleString('en-US', { minimumFractionDigits: 2 }) }}
        </div>
      </div>
      <!-- Botón Eliminar (Móvil) -->
      <div class="absolute top-1 right-1">
        <el-popconfirm confirm-button-text="Si" cancel-button-text="No" icon-color="#C30303" title="¿Continuar?"
          @confirm="deleteItem(sale.product.id)" class="justify-self-end">
          <template #reference>
            <button class="text-gray-400 cursor-pointer size-7 hover:bg-gray-100 hover:text-red-600 rounded-full">
              <i class="fa-regular fa-trash-can text-sm"></i>
            </button>
          </template>
        </el-popconfirm>
      </div>
    </div>
  </div>

  <!-- 
    Estado Vacío:
    - Aumentamos la altura y el padding.
    - Texto más grande y suave.
  -->
  <div class="text-center text-gray-400 text-base h-[200px] flex items-center justify-center"
    v-if="saleProducts?.length == 0">
    <p class="flex items-center justify-center">
      Selecciona un producto para comenzar la venta
      <i class="fa-regular fa-hand-point-down ml-3"></i>
    </p>
  </div>
</template>

<script>
export default {
  data() {
    return {
      quantity: 1,
      editMode: null,
      editedPrice: null
    };
  },
  props: {
    saleProducts: Array,
    saleType: String,
  },
  emits: ['delete-product'],
  methods: {
    getPrice(product) {
      if (this.saleType == 'publico') {
        return product.public_price ?? 0;
      } else if (this.saleType == 'empleado') {
        return product.current_employee_price?.price ?? 0;
      } else if (this.saleType == 'cortesia') {
        return 0;
      }
    },
    deleteItem(productId) {
      this.$emit('delete-product', productId);
    },
    startEditing(sale, index) {
      this.editMode = index;
      this.editedPrice = sale.product.public_price;
    },
    stopEditing(sale) {
      this.editMode = null;
      // Actualizamos el precio en el objeto de venta directamente.
      sale.product.public_price = parseFloat(this.editedPrice);
    },
  },
};
</script>
