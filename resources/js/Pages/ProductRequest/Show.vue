<template>
    <AppLayout title="Detalles solicitud de mercancía">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Detalles solicitud de mercancía
            </h2>
        </template>

        <div class="flex justify-start">
            <Link :href="route('carts.index')" class="flex items-center mt-2 text-slate-700">
            <i class="
            fas
            fa-long-arrow-alt-left
            text-lg
            active:bg-gray-300
            bg-opacity-100
            rounded-full
            w-7
            h-7
            pl-1
            ml-2
          "></i>
            <span class="ml-1 cursor-default">Atrás</span>
            </Link>
        </div>

        <div class="
        max-w-2xl
        md:mx-auto
        mt-5
        shadow-md shadow-gray-500/70
        rounded-lg
        px-5
        pt-4
        pb-5
        bg-white
        mx-4
      ">
            <h1 class="text-sky-500 font-bold mb-2">Productos solicitados</h1>
            <ul>
                <li v-for="request in product_request.products" :key="request.product_id" class="text-sm list-disc ml-2">
                    {{ products.find(product => request.product_id == product.id).name }}
                    <i class="fa-solid fa-arrow-right mx-3 text-green-600"></i>
                    {{ request.quantity }}
                    {{ products.find(product => request.product_id == product.id).unit.name }}
                </li>
            </ul>
        </div>
    </AppLayout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Link } from "@inertiajs/inertia-vue3";

export default {
    data() {
        return {

        };
    },
    components: {
        AppLayout,
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