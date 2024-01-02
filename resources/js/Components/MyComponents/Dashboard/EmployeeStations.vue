<template>
    <div v-if="loading" class="globe min-h-[170px] animate-pulse flex space-x-4">
        <div class="flex-1 space-y-3 py-1">
            <div class="h-4 bg-gray-200 rounded"></div>
            <div class="h-4 bg-gray-200 rounded"></div>
            <div class="h-4 bg-gray-200 rounded"></div>
            <div class="h-4 bg-gray-200 rounded"></div>
            <div class="h-4 bg-gray-200 rounded"></div>
        </div>
    </div>
    <div v-else class="globe relative z-0 text-[#373737]">
        <div class="globe-title pb-2">
            <span class="font-bold text-center">Colaboradores en carrito / cocina</span>
        </div>
        <p class="flex items-center mb-2 space-x-3 font-bold">
            <i class="fa-solid fa-hand-holding-dollar text-sm"></i>
            <span>Carrito </span>
            <span>({{ inCart.length }})</span>
        </p>
        <ul v-for="item in inCart" :key="item.id" class="text-sm ml-10">
            <li class="list-disc">{{ item.name }}</li>
        </ul>
        <p v-if="!inCart.length" class="text-xs text-gray1 text-center">No hay empleados en carrito</p>
        <div class="flex flex-col mt-3">
            <p class="flex items-center mb-2 space-x-2 font-bold">
                <i class="fa-solid fa-kitchen-set text-sm"></i>
                <span>Cocina</span>
                <span>({{ inKitchen.length }})</span>
            </p>
            <ul v-for="item in inKitchen" :key="item.id" class="text-sm ml-10">
                <li class="list-disc">{{ item.name }}</li>
            </ul>
            <p v-if="!inKitchen.length" class="text-xs text-gray1 text-center">No hay empleados en cocina</p>
        </div>
    </div>
</template>
<script>
import axios from 'axios';
import { format } from 'date-fns';
import { es } from 'date-fns/locale';

export default {
    data() {
        return {
            loading: true,
            inKitchen: [],
            inCart: [],
        };
    },
    methods: {
        formatDate(date) {
            const parsedDate = new Date(date);
            return format(parsedDate, 'dd \'de\' MMMM', { locale: es }); // Formato personalizado
        },
        async fetchEmployeesInStation() {
            try {
                this.loading = true;
                const response = await axios.get(route('users.get-in-station'));

                if (response.status === 200) {
                    this.inKitchen = response.data.kitchen;
                    this.inCart = response.data.cart;
                }
            } catch (error) {
                console.log(error);
                this.$notify({
                    title: "Hubo un problema con el servior",
                    message: "El servidor no pudo procesar la petición de obtener empleados en estación de trabajo",
                    type: "error",
                });
            } finally {
                this.loading = false;
            }
        }
    },
    mounted() {
        this.fetchEmployeesInStation();
    }
}
</script>