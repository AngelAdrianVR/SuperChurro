<template>
  <!-- 
    MODIFICACIÓN: 
    - Se usa 'items-start' para que el mensaje de error (si aparece)
      no desalinee verticalmente el input de cantidad y el botón.
    - Se añade 'gap-3' para un espaciado consistente.
    - Se eliminan clases custom como 'common-container'.
  -->
  <div class="flex w-full items-start gap-3">
    
    <!-- Contenedor del Select (ocupa el espacio principal) -->
    <div class="flex-1">
      <!-- 
        MODIFICACIÓN: 
        - Se reemplaza la clase 'select' por clases de Tailwind.
      -->
      <select
        @change="syncItem"
        v-model="selection"
        class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-600 focus:border-blue-600 sm:text-sm"
        required
      >
        <option value="x" disabled>-- Seleccionar consumible --</option>
        <option
          v-for="consumable in consumables"
          :key="consumable.id"
          :value="consumable.id"
        >
          {{ consumable.name }}
        </option>
      </select>
      <!-- 
        MODIFICACIÓN: 
        - Color de error más estándar y con margen superior.
      -->
      <p v-if="error_validation" class="text-red-500 text-xs mt-1">
        Favor de seleccionar el consumible
      </p>
    </div>

    <!-- Contenedor de Cantidad (ancho fijo) -->
    <div>
      <!-- 
        MODIFICACIÓN: 
        - Se reemplaza la clase 'input' por clases de Tailwind.
        - Se da un ancho fijo 'w-24' para consistencia.
        - Se elimina el 'div' wrapper innecesario.
        - Se añade un placeholder.
      -->
      <input
        @change="syncItem"
        v-model.number="quantity"
        min="1"
        type="number"
        autocomplete="off"
        class="block w-24 border-gray-300 rounded-lg shadow-sm focus:ring-blue-600 focus:border-blue-600 sm:text-sm"
        placeholder="Cant."
      />
    </div>

    <!-- 
      MODIFICACIÓN: 
      - Botón de Eliminar estilizado.
      - 'h-10' para alinear verticalmente con la altura del input.
      - Color de ícono gris, que cambia a rojo en hover.
    -->
    <button
      type="button"
      @click="$emit('deleteItem')"
      class="h-10 px-2 flex items-center text-gray-500 hover:text-red-600 transition-colors rounded-lg"
    >
      <i class="fa-regular fa-trash-can text-base"></i>
    </button>
  </div>
</template>

<!-- El script se mantiene idéntico -->
<script>
export default {
  data() {
    return {
      selection: "x",
      quantity: 1,
      error_validation: false,
    };
  },
  emits: ["deleteItem", "syncItem"],
  props: {
    consumables: Array,
    id: Number,
    init_state: {
      type: Object,
      default: null,
    },
  },
  mounted() {
    if (this.init_state != null) {
      this.selection = this.init_state.consumable_id;
      this.quantity = this.init_state.quantity;
    }
  },
  computed: {
    syncItem() {
      if (this.selection != "x" && this.quantity) {
        this.$emit("syncItem", {
          id: this.id,
          consumable_id: this.selection,
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
