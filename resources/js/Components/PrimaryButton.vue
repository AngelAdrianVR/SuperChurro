<script setup>
defineProps({
    type: {
        type: String,
        default: 'submit',
    },
});
</script>

<template>
    <button :type="type" class="inline-flex items-center px-4 py-2 bg-[#BF532A] border border-transparent rounded-full font-semibold text-xs text-white uppercase tracking-widest hover:bg-[#ad6e55] active:bg-[#BF532A] focus:outline-none focus:border-[#BF532A] focus:ring focus:ring-[#BF532A] disabled:opacity-50 transition disabled:cursor-not-allowed">
        <slot />
    </button>
</template>
