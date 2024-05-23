<template>
    <AppLayout title="Detalles solicitud de consumibles">
        <template #header>
            <div class="flex items-center mt-2">
                <Back :to="route('carts.requests-index', {tab: '2'})" />
                <h2 class="font-semibold text-xl text-gray-800 text-center ml-5 lg:ml-28">
                    Detalles solicitud de consumibles
                </h2>
            </div>
        </template>

        <div class="max-w-2xl md:mx-auto mt-5 rounded-lg px-5 pt-4 pb-5 bg-transparent mx-4 border border-gray3">
            <h1 class="text-primary font-bold mb-2">Consumibles solicitados</h1>
            <ul>
                <li v-for="request in consumable_request.consumables" :key="request.consumable_id"
                    class="text-sm list-disc ml-2">
                    {{ consumables.find(consumable => request.consumable_id == consumable.id).name }}
                    <i class="fa-solid fa-arrow-right mx-3 text-[#ABD196]"></i>
                    {{ request.quantity }}
                    {{ consumables.find(consumable => request.consumable_id == consumable.id).unit.name }}
                </li>
            </ul>
        </div>
    </AppLayout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import Back from "@/Components/Back.vue";
import { Link } from "@inertiajs/inertia-vue3";

export default {
    data() {
        return {

        };
    },
    components: {
        AppLayout,
        SecondaryButton,
        Back,
        Link,
    },
    props: {
        consumable_request: Object,
        consumables: Array,
    },
    methods: {

    },
};
</script>