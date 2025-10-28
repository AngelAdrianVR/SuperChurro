<script setup>
import { onMounted, ref } from 'vue';

defineProps({
    modelValue: String,
});

defineEmits(['update:modelValue']);

const input = ref(null);

onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
});

defineExpose({ focus: () => input.value.focus() });
</script>

<template>
    <!-- 
      MODERNIZACIÓN:
      - Sizing: Eliminado 'h-8' y 'p-2.5' en favor de un padding vertical y horizontal (py-2.5 px-4) que da más altura y espacio.
      - Estilo: Cambiado a 'bg-gray-50' para un ligero contraste con el fondo blanco de la tarjeta.
      - Bordes: 'rounded-lg' es más moderno que 'rounded-md'.
      - Texto: Color de placeholder explícito 'placeholder:text-gray-400' y texto 'text-gray-900'.
      - Foco (Importante): 
        - Se eliminó el 'focus:ring-gray2'
        - Se añadió un 'focus:ring-2' y 'focus:ring-blue-500' (o 'indigo-500') para un "glow" moderno.
        - 'focus:border-blue-500' para cambiar el color del borde al enfocar.
      - Transición: Añadido 'transition duration-200' para suavizar el cambio de foco.
    -->
    <input
        ref="input"
        class="block w-full rounded-lg border-gray-300 bg-gray-50 py-2.5 px-4 text-sm text-gray-900 placeholder:text-gray-400 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition duration-200 ease-in-out disabled:cursor-not-allowed disabled:bg-gray-200 disabled:text-gray-500"
        :value="modelValue"
        @input="$emit('update:modelValue', $event.target.value)"
    >
</template>
