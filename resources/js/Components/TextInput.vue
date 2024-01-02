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
    <input
        ref="input"
        class="h-8 bg-transparent border placeholder:text-gray-400 border-gray3 text-gray-700 text-sm rounded-md focus:ring-gray2 focus:border-gray2 block w-full p-2.5 disabled:bg-gray4 disabled:text-gray2 disabled:cursor-not-allowed"
        :value="modelValue"
        @input="$emit('update:modelValue', $event.target.value)"
    >
</template>
