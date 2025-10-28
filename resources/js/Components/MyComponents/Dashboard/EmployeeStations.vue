<template>
    <!-- 
      MODERNIZACIÓN:
      - Estado 'loading' ahora usa el mismo contenedor de tarjeta.
      - Tarjeta principal con 'bg-white rounded-2xl shadow-lg p-6'.
      - Título y estructura alineados con BirthdatesCard.
      - Reemplazados íconos de Font Awesome por SVGs inline.
      - Listas y estados vacíos mejor estilizados.
    -->
    
    <!-- Estado de Carga (Skeleton) -->
    <div v-if="loading" class="w-full bg-white rounded-2xl shadow-lg p-6 animate-pulse">
        <div class="border-b border-gray-200 pb-4 mb-4">
            <div class="h-5 bg-gray-200 rounded w-3/4"></div>
        </div>
        <div class="space-y-5 mt-5">
            <!-- Skeleton para Carrito -->
            <div>
                <div class="h-4 bg-gray-200 rounded w-1/3 mb-3"></div>
                <div class="space-y-2 ml-6">
                    <div class="h-4 bg-gray-200 rounded w-1/2"></div>
                    <div class="h-4 bg-gray-200 rounded w-1/2"></div>
                </div>
            </div>
            <!-- Skeleton para Cocina -->
            <div>
                <div class="h-4 bg-gray-200 rounded w-1/3 mb-3"></div>
                <div class="space-y-2 ml-6">
                    <div class="h-4 bg-gray-200 rounded w-1/2"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Contenido Real -->
    <div v-else class="w-full bg-white rounded-2xl shadow-lg p-6 self-start">
        <div class="globe-title pb-4 border-b border-gray-200">
            <h1 class="text-lg font-semibold text-gray-800">Colaboradores en Estación</h1>
        </div>
        
        <div class="mt-4 space-y-5">
            <!-- Sección Carrito -->
            <div>
                <p class="flex items-center space-x-2 font-semibold text-gray-700">
                    <!-- Icono Carrito (SVG) -->
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-blue-600">
                      <path d="M1 1.75A.75.75 0 0 1 1.75 1h1.628a1.75 1.75 0 0 1 1.734 1.51L5.18 3a.75.75 0 0 1 0 .23l.634 2.533a.75.75 0 0 1-.23.7L4.34 7.73a.75.75 0 0 1-1.06-1.06l1.01-1.01-.525-2.1H1.75a.75.75 0 0 1-.75-.75ZM6.104 4.25 5.23 7.75H18.25a.75.75 0 0 1 .74.83l-1.5 6a.75.75 0 0 1-.74.67H7.75a.75.75 0 0 1 0-1.5h8.33l1.02-4.085-11.43-.002-.85-3.415h11.234Z" />
                      <path d="M7 16.25a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0ZM17 16.25a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z" />
                    </svg>
                    <span>Carrito</span>
                    <span class="font-normal text-gray-500">({{ Object.keys(inCart).length }})</span>
                </p>
                <ul v-if="Object.keys(inCart).length" class="text-sm text-gray-600 ml-7 mt-2 space-y-1.5">
                    <li v-for="item in inCart" :key="item.id" class="flex items-center">
                        <span class="mr-2 h-1.5 w-1.5 bg-gray-400 rounded-full"></span>
                        {{ item.name }}
                    </li>
                </ul>
                <p v-else class="text-sm text-gray-500 text-left ml-7 mt-2">No hay empleados en carrito.</p>
            </div>

            <!-- Sección Cocina -->
            <div>
                <p class="flex items-center space-x-2 font-semibold text-gray-700">
                    <!-- Icono Cocina (SVG) -->
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-orange-600">
                      <path fill-rule="evenodd" d="M10.43 2.22a.75.75 0 0 0-1.09-.506l-7.5 4.5A.75.75 0 0 0 1.5 6.75v8.5a.75.75 0 0 0 .75.75h15a.75.75 0 0 0 .75-.75v-8.5a.75.75 0 0 0-.34-.636l-7.5-4.5ZM9 4.13 15.16 8H2.84L9 4.13Z" clip-rule="evenodd" />
                      <path d="M3 9.75h14v5.5H3v-5.5Z" />
                    </svg>
                    <span>Cocina</span>
                    <span class="font-normal text-gray-500">({{ Object.keys(inKitchen).length }})</span>
                </p>
                <ul v-if="Object.keys(inKitchen).length" class="text-sm text-gray-600 ml-7 mt-2 space-y-1.5">
                    <li v-for="item in inKitchen" :key="item.id" class="text-sm ml-10">
                        <span class="mr-2 h-1.5 w-1.5 bg-gray-400 rounded-full"></span>
                        {{ item.name }}
                    </li>
                </ul>
                <p v-else class="text-sm text-gray-500 text-left ml-7 mt-2">No hay empleados en cocina.</p>
            </div>
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
            return format(parsedDate, "dd 'de' MMMM", { locale: es }); // Formato personalizado
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
                // Evitar usar 'this.$notify' si no está globalmente definido
                // Reemplazar con un 'console.error' o un sistema de notificación local
                console.error("Hubo un problema con el servidor al obtener empleados en estación.");
                // this.$notify({
                //     title: "Hubo un problema con el servior",
                //     message: "El servidor no pudo procesar la petición de obtener empleados en estación de trabajo",
                //     type: "error",
                // });
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
