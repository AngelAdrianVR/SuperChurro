<template>
    <!--
      MODERNIZACIÓN:
      - Estilo de tarjeta unificado: 'bg-white rounded-2xl shadow-lg p-6'.
      - Título con mejor tipografía.
    -->
    <div
        class="w-full bg-white rounded-2xl shadow-lg p-6">
        <h1 class="text-lg font-semibold text-gray-800 mb-4">{{ title }} <span v-html="icon"></span></h1>

        <div id="chart">
            <!-- 
              CAMBIOS:
              - :options ahora usa 'computedChartOptions'
              - :series ahora usa 'processedSeries'
            -->
            <apexchart type="bar" height="250" :options="computedChartOptions" :series="processedSeries"></apexchart>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        title: String,
        icon: {
            default: '',
            type: String
        },
        options: Object, // Espera { series: [], categories: [], colors: [] }
        
        // --- NUEVA PROP ---
        percentageToSubtract: {
            type: Number,
            default: 0,
            // Validador para asegurar que esté entre 0 y 100
            validator: (val) => val >= 0 && val <= 100
        }
    },
    data() {
        return {
            // Se migró todo a 'computed' para mejor reactividad
        };
    },
    computed: {
        /**
         * Procesa la serie de datos aplicando el descuento porcentual.
         */
        processedSeries() {
            // Factor de multiplicación (ej. 10% de resta = 0.9)
            const subtractionFactor = 1 - (this.percentageToSubtract / 100);

            if (!this.options || !this.options.series) return [];

            return this.options.series.map(s => ({
                ...s,
                // Mapea los datos, aplica el factor, y asegura que sean números
                data: s.data.map(val => 
                    parseFloat((parseFloat(val) * subtractionFactor).toFixed(2))
                )
            }));
        },

        /**
         * Genera las opciones del gráfico de forma reactiva.
         */
        computedChartOptions() {
            // Extrae categorías y colores de las props, con valores por defecto
            const categories = (this.options && this.options.categories) ? this.options.categories : [];
            const colors = (this.options && this.options.colors) ? this.options.colors : ['#a8b3cf', '#3b82f6'];

            return {
                chart: {
                    type: 'bar',
                    height: 250,
                    toolbar: { show: false }
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '60%',
                        borderRadius: 8,
                        borderRadiusApplication: 'end',
                    },
                },
                dataLabels: {
                    enabled: true, // Habilitado por defecto (para pantallas grandes)
                    formatter: (val) => {
                        const numVal = parseFloat(val);
                        if (numVal === 0) return '';
                        return numVal.toFixed(0) + "K"; // Muestra el valor ya procesado
                    },
                    offsetY: -25,
                    style: {
                        fontSize: '12px',
                        fontWeight: 600,
                        colors: ["#304758"]
                    }
                },
                colors: colors,
                stroke: {
                    show: true,
                    width: 4,
                    colors: ['transparent']
                },
                grid: {
                    show: true,
                    borderColor: '#f0f0f0',
                    strokeDashArray: 4,
                },
                xaxis: {
                    categories: categories,
                    labels: {
                        style: {
                            colors: '#6B7280',
                            fontSize: '12px',
                        }
                    },
                    axisBorder: { show: false },
                    axisTicks: { show: false }
                },
                yaxis: {
                    title: {
                        text: '$ (miles)',
                        style: {
                            color: '#6B7280',
                            fontWeight: 500,
                        }
                    },
                    labels: {
                        style: { colors: '#6B7280' },
                        formatter: (val) => "$ " + val.toFixed(0) + "K"
                    }
                },
                fill: { opacity: 1 },
                tooltip: {
                    y: {
                        // El tooltip también muestra el valor procesado
                        formatter: (val) => "$ " + parseFloat(val).toFixed(2) + "K"
                    },
                    theme: 'dark'
                },
                legend: {
                    position: 'bottom',
                    horizontalAlign: 'center',
                    offsetY: 8
                },
                
                // --- NUEVO: Opciones Responsivas ---
                responsive: [{ 
                    breakpoint: 1024, // Breakpoint 'lg' de Tailwind
                    options: {
                        // Oculta las etiquetas de datos en pantallas < 1024px
                        dataLabels: {
                            enabled: false 
                        },
                        plotOptions: {
                            bar: {
                                columnWidth: '80%', // Barras más anchas en móvil
                                borderRadius: 6,
                            }
                        },
                        // Opcional: simplificar eje Y en móvil
                        yaxis: {
                            labels: { show: false },
                            title: { text: '' }
                        }
                    }
                }]
            };
        }
    }
}
</script>

