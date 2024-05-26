<template>
    <AppLayout title="Solicitudes de mercancía / Consumibles">
        <template #header>
            <div class="flex items-center mt-2">
                <Back />
                <h2 class="font-semibold text-xl text-gray-800 text-center ml-5 lg:ml-28">
                    Solicitudes de mercancía / Consumibles
                </h2>
            </div>
        </template>

        <el-tabs v-model="activeTab" @tab-click="updateURL" class="mt-5 mx-10">
            <el-tab-pane label="Mercancía" name="1">
                <ProductHistory />
            </el-tab-pane>
            <el-tab-pane label="Consumibles" name="2">
                <ConsumableHistory />
            </el-tab-pane>
        </el-tabs>
    </AppLayout>
</template>

<script>
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