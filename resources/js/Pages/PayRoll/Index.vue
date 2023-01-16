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
                <div class="grid grid-cols-3 gap-1 text-sm">
                    <span>-<i class="text-red-400 fa-solid fa-dollar mr-1"></i>{{ payroll.discounts }} descuentos</span>
                    <span>+<i class="text-green-700 fa-solid fa-dollar mr-1"></i>{{ payroll.vacation_premium }} prima vacacional</span>
                    <span><i class="text-green-700 fa-regular fa-dollar-sign mr-1"></i>{{ payroll.paid }} total</span>
                    <span><i class="text-green-400 fa-solid fa-check mr-1"></i>{{ payroll.week_attendance.attendances }} Asistencias</span>
                    <span><i class="text-yellow-400 fa-solid fa-umbrella-beach mr-1"></i>{{ payroll.week_attendance.vacations }} Vacaciones</span>
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