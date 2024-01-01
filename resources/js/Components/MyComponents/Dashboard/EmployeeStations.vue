<template>
    <div class="globe relative z-0">
        <div class="globe-title pb-2">
            <span class="font-bold text-center">Colaboradores en carrito / cocina</span>
        </div>
        <p class="flex items-center mb-2 space-x-2 font-bold">
            <i class="fa-solid fa-hand-holding-dollar text-sm"></i>
            <span>Carrito</span>
            <span>(2)</span>
        </p>
        <ul class="text-sm ml-10">
            <li class="list-disc">Plazola Esquivel Cristian</li>
        </ul>
        <div class="flex flex-col mt-3">
            <p class="flex items-center mb-2 space-x-2 font-bold">
                <i class="fa-solid fa-kitchen-set text-sm"></i>
                <span>Cocina</span>
                <span>(2)</span>
            </p>
            <ul class="text-sm ml-10">
                <li class="list-disc">Plazola Esquivel Cristian</li>
            </ul>
        </div>
    </div>
</template>
<script>
import { format } from 'date-fns';
import { es } from 'date-fns/locale';

export default {
    data() {
        return {

        };
    },
    props: {
        users: Array,
    },
    methods: {
        formatDate(date) {
            const parsedDate = new Date(date);
            return format(parsedDate, 'dd \'de\' MMMM', { locale: es }); // Formato personalizado
        },
    }
}
</script>