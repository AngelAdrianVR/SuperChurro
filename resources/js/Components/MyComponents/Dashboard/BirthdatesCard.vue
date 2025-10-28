<template>
    <!--
      MODERNIZACIÓN:
      - Estilo de tarjeta unificado: 'bg-white rounded-2xl shadow-lg p-6'.
      - Título alineado a la izquierda, más profesional.
      - Lista con mejor espaciado (space-y-4).
      - Icono de regalo (gift) más limpio.
      - Layout de item (flex justify-between) para alinear nombre y fecha.
    -->
    <div class="w-full bg-white rounded-2xl shadow-lg p-6 self-start">
        <div class="globe-title pb-4 border-b border-gray-200">
            <h1 class="text-lg font-semibold text-gray-800">Cumpleaños de este mes</h1>
        </div>
        <ul class="text-gray-700 mt-4 space-y-4">
            <li v-for="user in users" :key="user.id" class="flex items-center justify-between text-sm">
                <div class="flex items-center space-x-3">
                    <!-- Icono de Regalo -->
                    <div class="flex-shrink-0 bg-blue-100 rounded-full p-2">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-blue-600">
                          <path d="M10 4.5a.75.75 0 0 1 .75.75v2.25a.75.75 0 0 1-1.5 0v-2.25A.75.75 0 0 1 10 4.5Z" />
                          <path fill-rule="evenodd" d="M8.5 1.75A2.75 2.75 0 0 0 5.75 4.5v.5H4.5a.75.75 0 0 0 0 1.5h1.25V15A2.75 2.75 0 0 0 8.5 17.75h3A2.75 2.75 0 0 0 14.25 15V6.5h1.25a.75.75 0 0 0 0-1.5H14.25v-.5A2.75 2.75 0 0 0 11.5 1.75h-3ZM7.25 6.5v8.5A1.25 1.25 0 0 0 8.5 16.25h3A1.25 1.25 0 0 0 12.75 15V6.5H7.25Z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <!-- Nombre -->
                    <span class="font-medium text-gray-800">{{ user.name }}</span>
                </div>
                <!-- Fecha -->
                <span class="text-gray-500">{{ formatDate(user.employee_properties?.birthdate) }}</span>
            </li>
        </ul>
        <p v-if="!users.length" class="mt-4 text-sm text-gray-500">No hay cumpleaños este mes</p>
    </div>
</template>
<script>
import { format, addDays } from 'date-fns';
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
            // Fix para fechas que pueden estar en UTC
            if (!date) return '';
            const parsedDate = new Date(date);
            const adjustedDate = addDays(parsedDate, 1); // Sumar 1 día por posible ajuste de zona horaria
            return format(adjustedDate, "dd 'de' MMMM", { locale: es });
        }
    }
}
</script>
