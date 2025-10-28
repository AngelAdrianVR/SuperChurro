<template>
    <AppLayout title="Solicitudes de mercancía / Consumibles">
        <template #header>
            <!-- MODIFICADO: 
              - Mismos cambios que en el otro archivo para el header.
              - Se agregaron clases para modo oscuro (dar:text-gray-100).
              - Se mejoró el centrado con 'flex-grow' y el hack '-ml-10 sm:ml-0'.
            -->
            <div class="flex items-center mt-2 w-full">
                <Back />
                <h2 class="font-semibold text-xl text-gray-900 dar:text-gray-100 text-center flex-grow -ml-10 sm:ml-0">
                    Solicitudes de mercancía / Consumibles
                </h2>
            </div>
        </template>

        <!-- MODIFICADO: 
          - Se reemplazó 'mt-5 mx-10' por márgenes responsivos: 'mt-6 sm:mt-8 mx-4 sm:mx-6 lg:mx-8'.
          - Se envolvió el componente 'el-tabs' en una tarjeta moderna para darle un contenedor elegante.
          - Se usa 'bg-white dar:bg-gray-800', 'shadow-xl', y 'rounded-2xl'.
          - Se agregó 'overflow-hidden' para que los bordes redondeados se apliquen correctamente a 'el-tabs'.
          - Se agregó padding 'p-4 sm:p-6' al componente 'el-tabs' (Element UI usualmente lo aplica al contenedor interno).
        -->
        <div class="mt-6 sm:mt-8 mx-4 sm:mx-6 lg:mx-8">
            <div class="bg-white dar:bg-gray-800 shadow-xl rounded-2xl overflow-hidden">
                <el-tabs v-model="activeTab" @tab-click="updateURL" class="p-4 sm:p-6">
                    <el-tab-pane label="Mercancía" name="1">
                        <ProductHistory />
                    </el-tab-pane>
                    <el-tab-pane label="Consumibles" name="2">
                        <ConsumableHistory />
                    </el-tab-pane>
                </el-tabs>
            </div>
        </div>
    </AppLayout>
</template>

<script>
// El script permanece sin cambios
import AppLayout from "@/Layouts/AppLayout.vue";
import Back from "@/Components/Back.vue";
import ProductHistory from "@/Pages/ProductRequest/History.vue";
import ConsumableHistory from "@/Pages/ConsumableRequest/History.vue";
import { Link } from "@inertiajs/inertia-vue3";

export default {
    data() {
        return {
            activeTab: '1'
        };
    },
    components: {
        AppLayout,
        Back,
        Link,
        ProductHistory,
        ConsumableHistory,
    },
    props: {
    },
    methods: {
        updateURL(tab) {
            const params = new URLSearchParams(window.location.search);
            params.set('tab', tab.props.name);
            window.history.replaceState({}, '', `${window.location.pathname}?${params.toString()}`);
        },
        setActiveTabFromURL() {
            const params = new URLSearchParams(window.location.search);
            const tab = params.get('tab');
            if (tab) {
                this.activeTab = tab;
            }
        }
    },
    mounted() {
        this.setActiveTabFromURL();
    }

};
</script>
