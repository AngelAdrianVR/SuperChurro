<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/inertia-vue3';

const props = defineProps({
    active: Boolean,
    href: String,
    as: String,
});

const classes = computed(() => {
    return props.active
        ? 'block pl-3 pr-4 py-2 border-l-4 border-primary text-base font-semibold text-primary bg-[#FDE0C8] focus:outline-none focus:text-primary focus:bg-amber-600/25 focus:border-[#883339] transition ease-linear duration-200'
        : 'block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:bg-primary/25 hover:border-primary focus:outline-none focus:text-primary focus:bg-[#FDE0C8] focus:border-primary transition';
});
</script>

<template>
    <div>
        <button v-if="as == 'button'" :class="classes" class="w-full text-left">
            <slot />
        </button>

        <Link v-else :href="href" :class="classes">
            <slot />
        </Link>
    </div>
</template>
