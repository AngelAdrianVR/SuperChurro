<template>
    <AppLayout title="Bonos">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Bonos
            </h2>
        </template>

        <div class="flex justify-end mb-3">
            <Link :href="route('bonuses.create')">
                <PrimaryButton class="mr-7 my-4">Crear bono</PrimaryButton>
            </Link>
        </div>

        <div v-if="bonuses.length" class="globe-container">
            <div v-for="bonus in bonuses" :key="bonus.id" class="globe relative hover:bg-slate-100 text-sm">
                    <div class="globe-title !justify-between">
                        <p>{{ bonus.name }}</p>
                    </div>
                    <p>Cantidad:  <strong class="ml-6">${{ bonus.amount }}</strong></p>
                    <p class="mb-3">Descripción: <strong class="ml-2">{{ bonus.description }}</strong></p>
                    <p v-if="bonus.is_active" class="px-3 py-1 text-xs text-center text-green-700 bg-[#B4FD9B] rounded-md absolute top-4 right-3">Activo
                    </p>
                    <p v-else class="px-2 py-1 text-center text-xs text-red-700 bg-red-200 rounded-md absolute top-4 right-3">Inactivo</p>

                    <div class="flex justify-between items-center mt-4">
                        <PrimaryButton @click="$inertia.get(route('bonuses.edit', bonus.id ))">Editar</PrimaryButton>
                        <ThirthButton
                        v-if="bonus.is_active"
                        @click="$inertia.put(route('bonuses.toggle-status', bonus))"
                        >Marcar como inactivo
                        </ThirthButton
                        >
                        <ThirthButton
                        v-else
                        @click="$inertia.put(route('bonuses.toggle-status', bonus))"
                        >Marcar como activo</ThirthButton
                        >
                    </div>
            </div>
        </div>

        <div v-else class="text-center">
            <p>No hay información para mostrar</p>
        </div>

    </AppLayout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import ThirthButton from "@/Components/ThirthButton.vue";
import { Link } from "@inertiajs/inertia-vue3";
export default {
    data() {
        return {

        }
    },
    components: {
        AppLayout,
        PrimaryButton,
        ThirthButton,
        Link
    },
    props: {
        bonuses: Array,
    },
    methods: {

    },
};
</script>
