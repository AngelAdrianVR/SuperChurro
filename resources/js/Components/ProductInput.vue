<template>
  <!-- 
    Contenedor principal: 
    - Usamos flex-row y un espacio (space-x-3).
    - 'items-start' alinea los elementos en la parte superior, lo que es mejor si aparecen mensajes de error.
  -->
  <div class="flex flex-row items-start space-x-3 w-full">

    <!-- 
      Selector de Producto:
      - 'flex-1' para que ocupe el espacio principal.
      - Clases de formulario modernas: rounded-md, shadow-sm, focus:ring-indigo-500.
    -->
    <div class="flex-1">
      <select @change="syncItem" v-model="selection"
        class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm"
        required>
        <option value="x">-- Seleccionar producto --</option>
        <option v-for="product in products" :key="product.id" :value="product.id">
          {{ product.name }} {{ show_price ? '($' + product.current_employee_price?.price + '/unidad)' : '' }}
        </option>
      </select>
      <!-- Mensaje de error moderno -->
      <p v-if="error_validation" class="mt-1 text-xs text-red-600">
        Favor de seleccionar el producto
      </p>
    </div>

    <!-- 
      Input de Cantidad:
      - Ancho fijo (w-24) para que no sea ni muy grande ni muy pequeño.
      - Mismas clases de formulario modernas.
    -->
    <div class="relative">
      <input @change="syncItem" v-model.number="quantity" min="1" type="number" autocomplete="off"
        class="w-24 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm"
        placeholder="Cant." />
    </div>

    <!-- 
      Botón de Eliminar:
      - Botón de icono, sutil (text-gray-400) pero claro en hover (hover:text-red-600).
      - 'flex-shrink-0' para que no se encoja.
    -->
    <button type="button" @click="$emit('deleteItem')"
      class="flex-shrink-0 flex items-center justify-center size-9 rounded-full text-gray-400 hover:bg-gray-100 hover:text-red-600 transition-colors">
      <i class="fa-regular fa-trash-can text-base"></i>
    </button>
  </div>
</template>

<script>

export default {
  data() {
    return {
      selection: "x",
      quantity: 1,
      error_validation: false,
    };
  },
  emits: ['deleteItem', 'syncItem'],
  props: {
    products: Array,
    id: Number,
    init_state: {
      type: Object,
      default: null,
    },
    show_price: {
      type: Boolean,
      default: false
    }
  },
  mounted() {
    if (this.init_state != null) {
      this.selection = this.init_state.product_id;
      this.quantity = this.init_state.quantity;
    }
  },
  computed: {
    getTotal() {
      return this.selection != "x"
        ? (this.quantity * this.products.find(product => { return product.id === this.selection }).price)?.toFixed(2) +
        " " +
        this.products.find(product => { return product.id === this.selection }).currency
        : 0;
    },
    getPrice() {
      return this.selection != "x"
        ? this.products.find(product => { return product.id === this.selection }).price + ' ' +
        this.products.find(product => { return product.id === this.selection }).currency +
        " / Unidad"
        : 0;
    },
    syncItem() {
      if (this.selection != 'x' && this.quantity) {
        this.$emit('syncItem', {
          id: this.id,
          product_id: this.selection,
          quantity: this.quantity,
        });
        this.error_validation = false;
      } else {
        this.error_validation = true;
      }
    },
  },
};
</script>
