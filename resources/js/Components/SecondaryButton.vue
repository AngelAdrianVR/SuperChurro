<script setup>
defineProps({
    type: {
        type: String,
        default: 'button',
    },
});
</script>

<template>
    <button :type="type" class="shadow-md shadow-gray-400/100 inline-flex items-center px-3 py-2 bg-gray-500 rounded-full font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-400 focus:outline-none focus:border-blue-300 focus:ring focus:ring-blue-200 active:text-gray-800 active:bg-gray-50 disabled:opacity-25 transition">
        <slot />
    </button>
</template>
