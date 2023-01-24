<script setup>
import { Head, Link } from '@inertiajs/inertia-vue3';

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,
});
</script>

<template>
    <Head title="Welcome" />

    <div class="relative flex items-top justify-center min-h-screen bg-gray-500 dark:bg-gray-900 sm:items-center sm:pt-0">        
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-center pt-8 sm:justify-start sm:pt-0">
                <Link :href="route('login')" class="text-6xl text-gray-700 dark:text-gray-500 underline">Iniciar sesión</Link>
            </div>
        </div>
    </div>
</template>
