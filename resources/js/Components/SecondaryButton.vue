<script setup>
defineProps({
    type: {
        type: String,
        default: 'button',
    },
});
</script>

<template>
    <button :type="type" class="inline-flex items-center px-3 py-1 bg-secondary rounded-full font-semibold text-xs text-white tracking-widest hover:bg-secondary focus:outline-none focus:border-secondary focus:ring-2 focus:ring-secondary active:text-white active:bg-secondary disabled:opacity-50 transition disabled:cursor-not-allowed">
        <slot />
    </button>
</template>
