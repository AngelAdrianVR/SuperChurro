<script setup>
defineProps({
    type: {
        type: String,
        default: 'button',
    },
});
</script>

<template>
    <button :type="type" class="inline-flex items-center px-3 py-1 bg-secondary rounded-full font-semibold text-xs text-white tracking-widest active:scale-90 disabled:opacity-50 transition disabled:cursor-not-allowed">
        <slot />
    </button>
</template>
