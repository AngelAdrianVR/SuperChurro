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
      - Este es un botón de contorno (outline).
      - Se asume que 'border-primary' y 'text-primary' son colores tipo 'indigo'.
      - Se cambia 'rounded-full' por 'rounded-lg'.
      - Se ajusta el padding a 'px-4 py-2' y el texto a 'text-sm font-medium'.
      - Se añaden estados de 'hover' (un fondo ligero) y 'focus'.
    -->
    <button :type="type" 
            class="inline-flex items-center justify-center px-4 py-2 
                   bg-transparent border border-indigo-600 rounded-lg 
                   font-medium text-sm text-indigo-700 tracking-wider 
                   hover:bg-indigo-50 
                   focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 
                   active:scale-95 disabled:opacity-50 transition-all disabled:cursor-not-allowed">
        <slot />
    </button>
</template>
