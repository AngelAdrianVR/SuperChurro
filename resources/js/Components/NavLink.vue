<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/inertia-vue3';

const props = defineProps({
    href: String,
    active: Boolean,
});

const classes = computed(() => {
    return props.active
        ? 'inline-flex items-center px-4 pt-7 border-b-2 border-primary text-base font-semibold leading-5 text-primary focus:outline-none focus:border-primary transition'
        : 'inline-flex items-center px-4 pt-7 border-b-2 border-transparent text-base font-medium leading-5 text-gray-800 hover:text-primary hover:border-primary focus:outline-none focus:text-primary focus:border-primary transition';
});
</script>

<template>
    <Link :href="href" :class="classes">
        <slot />
    </Link>
</template>
