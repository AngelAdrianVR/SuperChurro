<script setup>
defineProps({
    type: {
        type: String,
        default: 'submit',
    },
});
</script>

<template>
    <!-- 
      MODERNIZACIÓN:
      - Sizing: Aumentado el padding a 'px-6 py-3' y el tamaño de fuente a 'text-sm' con 'font-semibold'. 'py-1' y 'text-xs' eran muy pequeños.
      - Bordes: Cambiado de 'rounded-full' a 'rounded-xl' para un look más corporativo y elegante.
      - Color: Usando 'bg-blue-600' y 'hover:bg-blue-700' como ejemplo (puedes reemplazar 'blue' por tu color 'primary').
      - Foco: Añadido 'focus-visible:ring-2' para accesibilidad y un look moderno.
      - Transición: 'transition-all' para suavizar todos los cambios (color, escala).
      - Interacción: Cambiado 'active:scale-90' a 'active:scale-95' para una pulsación más sutil.
    -->
    <button :type="type" class="inline-flex items-center justify-center rounded-xl border border-transparent bg-amber-600 px-6 py-3 text-sm font-semibold text-white shadow-sm transition-all duration-200 ease-in-out hover:bg-amber-700 active:scale-95 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-600 focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50">
        <slot />
    </button>
</template>
