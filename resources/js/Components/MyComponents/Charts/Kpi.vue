<template>
    <div
        class="min-h-[100px] self-start border border-gray3 rounded-[10px] lg:rounded-xl lg:p-5 py-2 px-4 text-xs lg:text-sm relative">
        <h1 class="font-bold text-center">{{ title }} <span v-html="icon"></span></h1>
        <main class="flex items-center space-x-4 pt-4">
            <section class="flex flex-col items-center space-y-1 w-2/3">
                <el-tooltip :content="options.tooltipCurrentVal" placement="left">
                    <p class="font-bold text-3xl">{{ options.unit }}{{ options.currentVal.toLocaleString('en-US', {
                        minimumFractionDigits: 2
                    }) }}</p>
                </el-tooltip>
                <el-tooltip :content="options.tooltipRefVal" placement="left">
                    <p class="text-sm text-gray1">{{ options.unit }}{{ options.refVal.toLocaleString('en-US', {
                        minimumFractionDigits: 2
                    }) }}</p>
                </el-tooltip>
            </section>
            <section :class="options.currentVal - options.refVal < 0 ? 'text-red-600' : 'text-green-600'"
                class="w-1/3 text-3xl text-center">
                <span>{{
                    calcPercentage() }}%</span>
                <svg v-if="options.currentVal - options.refVal >= 0" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M2.25 18 9 11.25l4.306 4.306a11.95 11.95 0 0 1 5.814-5.518l2.74-1.22m0 0-5.94-2.281m5.94 2.28-2.28 5.941" />
                </svg>
                <svg v-else xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M2.25 6 9 12.75l4.286-4.286a11.948 11.948 0 0 1 4.306 6.43l.776 2.898m0 0 3.182-5.511m-3.182 5.51-5.511-3.181" />
                </svg>

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
    methods: {
        calcPercentage() {
            const dif = this.options.currentVal - this.options.refVal;
            const percentage = dif * 100 / this.options.refVal;
            return percentage.toLocaleString('en-US', { minimumFractionDigits: 2 });
        }
    }
}
</script>