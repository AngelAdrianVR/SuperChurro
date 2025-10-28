<script setup>
defineProps({
    type: {
        type: String,
        default: 'button',
    },
});
</script>

<template>
    <!-- 
      MODIFICADO: 
      - Se asume que 'bg-secondary' es un color como 'bg-gray-600'.
      - Se cambia 'rounded-full' por 'rounded-lg' para un look más moderno.
      - Se ajusta el padding a 'px-4 py-2' y el texto a 'text-sm font-medium'.
      - Se añaden estados de 'hover' y 'focus' más claros.
    -->
    <button :type="type" 
            class="inline-flex items-center justify-center px-4 py-2 
                   bg-gray-600 border border-transparent rounded-lg 
                   font-medium text-sm text-white tracking-wider 
                   shadow-sm hover:bg-gray-700 
                   focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 
                   active:scale-95 disabled:opacity-50 transition-all disabled:cursor-not-allowed">
        <slot />
    </button>
</template>
