<script setup>
defineProps({
    type: {
        type: String,
        default: 'submit',
    },
});
</script>

<template>
    <button :type="type" class="inline-flex items-center px-4 py-1 bg-primary border border-transparent rounded-full font-semibold text-xs text-white tracking-widest active:scale-90 focus:outline-none disabled:opacity-50 transition disabled:cursor-not-allowed">
        <slot />
    </button>
</template>
