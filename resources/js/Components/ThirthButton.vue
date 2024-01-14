<script setup>
defineProps({
    type: {
        type: String,
        default: 'button',
    },
});
</script>

<template>
    <button :type="type" class="inline-flex items-center px-4 py-1 bg-transparent border border-primary rounded-full font-semibold text-xs text-primary tracking-widest focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 transition ease-in-out duration-200 disabled:opacity-25 disabled:cursor-not-allowed">
        <slot />
    </button>
</template>
