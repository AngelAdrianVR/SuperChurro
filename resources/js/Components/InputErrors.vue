<script setup>
defineProps({
    errors: Object,
});
</script>

<template>
    <div>
        <ul class="text-sm text-red-600">
            <li v-for="(error, index) in errors" :key="index">{{ error }}</li>
        </ul>
    </div>
</template>
