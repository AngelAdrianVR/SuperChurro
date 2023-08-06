<script setup>
defineProps({
    type: {
        type: String,
        default: 'submit',
    },
});
</script>

<template>
    <button :type="type" class="inline-flex items-center px-4 py-2 bg-transparent border-2 border-[#883339] rounded-full font-semibold text-xs text-[#883339] tracking-widest focus:bg-gray-200 active:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-[#883339] focus:ring-offset-2 transition ease-in-out duration-200 disabled:opacity-25 disabled:cursor-not-allowed">
        <slot />
    </button>
</template>
