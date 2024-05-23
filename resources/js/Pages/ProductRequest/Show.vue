<template>
    <AppLayout title="Detalles solicitud de mercancía">
        <template #header>
            <div class="flex items-center mt-2">
                <Back :to="route('carts.requests-index')"/>
                <h2 class="font-semibold text-xl text-gray-800 text-center ml-5 lg:ml-28">
                    Detalles solicitud de mercancía
                </h2>
            </div>
        </template>

        <div class="max-w-2xl md:mx-auto mt-5 rounded-lg px-5 pt-4 pb-5 bg-transparent mx-4 border border-gray3">
            <h1 class="text-primary font-bold mb-2">Productos solicitados</h1>
            <ul>
                <li v-for="request in product_request.products" :key="request.product_id"
                    class="text-sm list-disc ml-2">
                    {{ products.find(product => request.product_id == product.id).name }}
                    <i class="fa-solid fa-arrow-right mx-3 text-[#ABD196]"></i>
                    {{ request.quantity }}
                    {{ products.find(product => request.product_id == product.id).unit.name }}
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
        product_request: Object,
        products: Array,
    },
    methods: {

    },
};
</script>