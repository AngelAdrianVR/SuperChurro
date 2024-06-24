import './bootstrap';
import '../css/app.css';
import '../css/fonts.css';
import '../css/varios.css';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/inertia-vue3';
import { InertiaProgress } from '@inertiajs/progress';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';
import ElementPlus from 'element-plus';
import 'element-plus/dist/index.css';
import locale from 'element-plus/dist/locale/es.mjs';
import VueApexCharts from "vue3-apexcharts";

// iniciar IndexedDB
import { initializeProducts } from './dbService.js';
initializeProducts(); //abre conexion a indexedDB y revisa si hay mas productos en server que en local. De ser asi, actualiza la BDD local

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, app, props, plugin }) {
        return createApp({ render: () => h(app, props) })
            .use(plugin)
            .use(ZiggyVue, Ziggy)
            .use(ElementPlus, {locale})
            .use(VueApexCharts)
            .mount(el);
    },
});

InertiaProgress.init({ color: '#F07209' });
