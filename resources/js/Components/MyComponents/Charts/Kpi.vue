<template>
    <!--
      MODERNIZACIÓN:
      - Estilo de tarjeta unificado: 'bg-white rounded-2xl shadow-lg p-6'.
      - Título más sutil (típico de KPIs).
      - Layout simplificado con flex.
      - Reemplazada la sección de % por un "Pill" (cápsula) moderno.
    -->
    <div
        class="w-full bg-white rounded-2xl shadow-lg p-6">
        <h1 class="text-sm font-medium text-gray-500 mb-2">{{ title }} <span v-html="icon"></span></h1>
        
        <main class="flex items-end justify-between pt-2">
            <!-- Sección de Valores -->
            <section class="flex flex-col">
                <el-tooltip :content="options.tooltipCurrentVal" placement="top">
                    <p class="font-bold text-3xl text-gray-900">{{ options.unit }}{{ options.currentVal.toLocaleString('en-US', {
                        minimumFractionDigits: 2
                    }) }}</p>
                </el-tooltip>
                <el-tooltip :content="options.tooltipRefVal" placement="bottom">
                    <p class="text-sm text-gray-500 mt-1">vs {{ options.unit }}{{ options.refVal.toLocaleString('en-US', {
                        minimumFractionDigits: 2
                    }) }}</p>
                </el-tooltip>
            </section>

            <!-- 
              Sección de Porcentaje (Pill Moderno)
              - Se usa 'v-if' para cambiar color y contenido.
            -->
            <section v-if="percentageChange >= 0"
                class="flex items-center space-x-1 rounded-full px-3 py-1 bg-green-100 text-green-800">
                 <!-- Icono de flecha arriba -->
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                  <path fill-rule="evenodd" d="M10 17a.75.75 0 0 1-.75-.75V5.612L5.22 9.64a.75.75 0 0 1-1.06-1.06l5.25-5.25a.75.75 0 0 1 1.06 0l5.25 5.25a.75.75 0 1 1-1.06 1.06L10.75 5.612V16.25A.75.75 0 0 1 10 17Z" clip-rule="evenodd" />
                </svg>
                <span class="text-sm font-semibold">{{ formattedPercentage }}%</span>
            </section>

            <section v-else
                class="flex items-center space-x-1 rounded-full px-3 py-1 bg-red-100 text-red-800">
                 <!-- Icono de flecha abajo -->
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                  <path fill-rule="evenodd" d="M10 3a.75.75 0 0 1 .75.75v10.638l3.97-3.969a.75.75 0 1 1 1.06 1.06l-5.25 5.25a.75.75 0 0 1-1.06 0l-5.25-5.25a.75.75 0 1 1 1.06-1.06l3.97 3.969V3.75A.75.75 0 0 1 10 3Z" clip-rule="evenodd" />
                </svg>
                <span class="text-sm font-semibold">{{ formattedPercentage.replace('-', '') }}%</span>
            </section>

        </main>
    </div>
</template>

<script>
export default {
    data() {
        return {

        };
    },
    props: {
        title: String,
        icon: {
            default: '',
            type: String
        },
        options: Object,
    },
    computed: {
        // Calculamos el % para usarlo en el template
        percentageChange() {
            if (this.options.refVal === 0) return 0; // Evitar división por cero
            const dif = this.options.currentVal - this.options.refVal;
            return (dif * 100) / this.options.refVal;
        },
        // Formateamos el %
        formattedPercentage() {
            return this.percentageChange.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
        }
    }
}
</script>
