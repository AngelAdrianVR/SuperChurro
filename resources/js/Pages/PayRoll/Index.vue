<template>
    <AppLayout title="Nóminas">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Nóminas</h2>
        </template>

        <div class="mt-5 text-bold text-lg text-gray-700">
            <p class="my-2 ml-5">Detalle de nómina</p>
            <PayRollTable :payroll="payroll_selected" />
        </div>

        <div class="globe-container">
            <div v-for="payroll in payrolls.data" :key="payroll.id" @click="payroll_selected = payroll"
                class="globe hover:bg-gray-100 cursor-pointer"
                :class="{ 'border-4 border-sky-500 !bg-sky-100': payroll_selected.id === payroll.id }">
                <div class="globe-title pb-2">
                    Semana {{ payroll.week }}: {{ payroll.start_date }} al {{ payroll.end_date }}
                </div>
                <div class="flex justify-between items-center">
                    <span><i class="fa-regular fa-dollar-sign mr-2"></i>1,000</span>
                    <span><i class="fa-solid fa-check mr-2"></i>5 Asistencia(s)</span>
                    <span><i class="fa-solid fa-xmark mr-2"></i>1 falta(s)</span>
                </div>
            </div>
        </div>
    </AppLayout>

</template>

<script>
import AppLayout from '@/Layouts/AppLayout.vue'
import PayRollTable from '@/Components/PayRollTable.vue'

export default {
    data() {
        return {
            payroll_selected: this.payrolls.data[0]
        };
    },
    components: {
        AppLayout,
        PayRollTable,
    },
    props: {
        payrolls: Object,
    },
}
</script>