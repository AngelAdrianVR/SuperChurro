<template>
    <AppLayout title="Bonos">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Bonos
            </h2>
        </template>

        <div class="flex justify-end mb-3">
            <Link :href="route('bonuses.create')">
            <SecondaryButton class="mr-7 mt-4">Crear nuevo</SecondaryButton>
            </Link>
        </div>

        <div v-if="bonuses.length" class="globe-container">
            <div v-for="bonus in bonuses" :key="bonus.id" class="globe relative cursor-pointer hover:bg-slate-100 text-sm">
                <Link :href="route('bonuses.edit', bonus)">
                    <div class="globe-title !justify-between">
                        <p>{{ bonus.name }}</p>
                    </div>
                    <p><strong>Cantidad: </strong> ${{ bonus.amount }}</p>
                    <p class="mb-3"><strong>Descripción: </strong> {{ bonus.description }}</p>
                    <p v-if="bonus.is_active" class="px-2 py-1 text-center text-green-700 bg-green-200 rounded-md">Activo
                    </p>
                    <p v-else class="px-2 py-1 text-center text-red-700 bg-red-200 rounded-md">Inactivo</p>
                </Link>
            </div>
        </div>

        <div v-else class="text-center">
            <p>No hay información para mostrar</p>
        </div>

    </AppLayout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import { Link } from "@inertiajs/inertia-vue3";
export default {
    data() {
        return {

        }
    },
    components: {
        AppLayout,
        SecondaryButton,
        Link,
    },
    props: {
        bonuses: Array,
    },
    methods: {

    },
};
</script>
