<script setup>
defineProps({
    type: {
        type: String,
        default: 'button',
    },
});
</script>

<template>
    <button :type="type" class="inline-flex items-center px-3 py-2 bg-[#883339] rounded-full font-semibold text-xs text-white uppercase tracking-widest hover:bg-[#a84148] focus:outline-none focus:border-[#883339] focus:ring-2 focus:ring-[#883339] active:text-white active:bg-[#883339] disabled:opacity-50 transition disabled:cursor-not-allowed">
        <slot />
    </button>
</template>
