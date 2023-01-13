<template>
    <AppLayout title="Nóminas">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Nóminas</h2>
        </template>

        <div class="mt-5 text-bold text-lg text-gray-700">
            <p class="my-2 ml-5">Nómina en curso</p>
            <PayRollTable />
        </div>

        <div class="globe-container">
            <div v-for="payroll in payrolls.data" :key="payroll.id" class="globe hover:bg-gray-200 cursor-pointer">
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

        };
    },
    components: {
        AppLayout,
        PayRollTable,
    },
    props: {
        payrolls: Array,
    },
}
</script>