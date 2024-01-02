<template>
    <div
        class="min-h-[220px] border-gray3 border rounded-[10px] lg:rounded-xl lg:p-5 py-2 px-4 text-xs lg:text-sm relative">
        <h1 class="font-bold text-center">{{ title }} <span v-html="icon"></span></h1>

        <div id="chart">
            <apexchart type="polarArea" width="335" :options="chartOptions" :series="series"></apexchart>
        </div>
        <!-- <div class="flex justify-end mx-6 absolute bottom-3 right-5">
            <button class="text-primary text-xs">Ver detalles</button>
        </div> -->
    </div>
</template>

<script>

export default {
    data() {
        return {
            series: this.options.series,
            chartOptions: {
                chart: {
                    width: 335,
                    type: 'polarArea',
                },
                colors: this.options.colors,
                stroke: {
                    width: 3,
                    colors: 'white'
                },
                labels: this.options.labels,
                fill: {
                    opacity: 0.8
                },
                yaxis: {
                    show: false
                },
                responsive: [{
                    breakpoint: 480,
                    options: {
                        chart: {
                            width: 260
                        },
                        legend: {
                            position: 'right'
                        }
                    }
                }]
            },
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
}
</script>