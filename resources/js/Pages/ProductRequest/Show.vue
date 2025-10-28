<template>
    <AppLayout title="Detalles solicitud de mercancía">
        <template #header>
            <!-- MODIFICADO: 
              - Mismos cambios de centrado y modo oscuro para el header.
            -->
            <div class="flex items-center mt-2 w-full">
                <Back :to="route('carts.requests-index')"/>
                <h2 class="font-semibold text-xl text-gray-900 dar:text-gray-100 text-center flex-grow -ml-10 sm:ml-0">
                    Detalles solicitud de mercancía
                </h2>
            </div>
        </template>

        <!-- MODIFICADO: 
          - Contenedor principal estilizado como tarjeta moderna.
          - Se reemplaza 'bg-transparent' y 'border' por 'bg-white dar:bg-gray-800', 'shadow-xl', 'rounded-2xl'.
          - Se aumenta el espaciado ('mt-6 sm:mt-8', 'p-6 sm:p-8').
        -->
        <div class="
            max-w-2xl 
            md:mx-auto 
            mt-6 sm:mt-8 
            rounded-2xl 
            p-6 sm:p-8 
            bg-white 
            dar:bg-gray-800 
            shadow-xl 
            mx-4
          ">
            <!-- MODIFICADO: 
              - Título de sección estilizado.
              - Se usa 'text-indigo-600' como color de acento.
              - Se agrega un borde inferior.
            -->
            <h1 class="
                text-lg 
                font-bold 
                mb-4 
                pb-3 
                text-indigo-600 
                dar:text-indigo-400 
                border-b 
                border-gray-200 
                dar:border-gray-700
              ">
              Productos solicitados
            </h1>

            <!-- MODIFICADO: 
              - Se reemplaza <ul> por un <div> con 'space-y-4' para mejor espaciado.
              - Se quita 'list-disc' para un look más limpio.
            -->
            <div class="space-y-4">
                <!-- MODIFICADO: 
                  - Cada item 'li' ahora es un 'div' flex.
                  - Se estiliza para mostrar claramente el producto y la cantidad.
                  - Se usa 'font-medium' para el nombre y 'font-bold' para la cantidad.
                  - Se cambia el ícono de flecha por uno más estándar y se estiliza.
                -->
                <div v-for="request in product_request.products" :key="request.product_id"
                    class="
                      flex 
                      items-center 
                      justify-between 
                      text-base 
                      p-4 
                      bg-gray-50 
                      dar:bg-gray-700
                      rounded-lg
                    ">
                    <span class="font-medium text-gray-800 dar:text-gray-100">
                      {{ products.find(product => request.product_id == product.id).name }}
                    </span>
                    
                    <div class="flex items-center space-x-3">
                      <i class="fa-solid fa-arrow-right text-gray-400 dar:text-gray-500"></i>
                      <span class="font-bold text-lg text-gray-900 dar:text-white">
                        {{ request.quantity }}
                      </span>
                      <span class="text-sm text-gray-600 dar:text-gray-400">
                        {{ products.find(product => request.product_id == product.id).unit.name }}
                      </span>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script>
// El script permanece sin cambios
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
