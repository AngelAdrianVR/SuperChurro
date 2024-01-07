<template>
    <AppLayout title="Nóminas">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">Nóminas</h2>
        </template>

        <div class="contenedor">
            <div class="globe-containe flex space-x-3 pb-4">
                <div v-for="payroll in payrolls.data" :key="payroll.id" @click="payroll_selected = payroll"
                    class="globe !pb-0 lg:!pb-3 hover:bg-gray-100 cursor-pointer w-[600px] lg:w-[1400px]"
                    :class="{ 'border-2 border-primary': payroll_selected.id === payroll.id }">
                    <div class="font-bold text-sm text-center pb-1">
                        Semana {{ payroll.week }}: {{ payroll.start_date }} al {{ payroll.end_date }}
                    </div>
                    <div>
                        <article class="flex mt-1 text-[8px] lg:text-xs">
                            <div
                                class="w-2/3 lg:w-3/4 mr-auto grid grid-cols-2 lg:grid-cols-3 gap-x-8 lg:gap-x-32 gap-y-1 border border-black">
                                <h2 class="col-span-full border-b border-black self-start py-px px-2">PERCEPCIONES</h2>
                                <p class="flex items-center justify-between px-2 self-start">
                                    <span>Sueldo ({{ getShiftsWorked(payroll) }} turnos)</span>
                                    <span>${{ payroll.base_salary }}</span>
                                </p>
                                <p v-for="bonus in payroll.bonuses" :key="bonus.name"
                                    class="flex items-center justify-between px-2 self-start">
                                    <span>{{ bonus.name }}</span>
                                    <span>${{ bonus.amount }}</span>
                                </p>
                                <p v-if="payroll.extras" class="flex items-center justify-between px-2 self-start">
                                    <span>Hrs. extra</span>
                                    <span>${{ payroll.total_extras }}</span>
                                </p>
                                <p v-if="payroll.week_attendance.vacations"
                                    class="flex items-center justify-between px-2 self-start">
                                    <span>Vacaciones ({{ payroll.week_attendance.vacations }})</span>
                                    <span>${{ payroll.paid_vacations }}</span>
                                </p>
                                <p v-if="payroll.week_attendance.holidays"
                                    class="flex items-center justify-between px-2 self-start">
                                    <span>Día feriado</span>
                                    <span>${{ payroll.paid_holiday }}</span>
                                </p>
                                <p v-if="payroll.week_attendance.paid_leaves"
                                    class="flex items-center justify-between px-2 self-start">
                                    <span>Permisos con goce ({{ payroll.week_attendance.paid_leaves }})</span>
                                    <span>${{ payroll.paid_leaves }}</span>
                                </p>
                                <p v-if="payroll.week_attendance.sickness"
                                    class="flex items-center justify-between px-2 self-start">
                                    <span>Incapacidades ({{ payroll.week_attendance.sickness }})</span>
                                    <span>${{ payroll.paid_sickness }}</span>
                                </p>
                                <p v-for="(commission, index) in payroll.commissions.filter(item => item > 0)" :key="index"
                                    class="flex items-center justify-between px-2 self-start">
                                    <span>Comisión {{ week_days[index] }}</span>
                                    <span>${{ commission }}</span>
                                </p>
                                <p v-if="payroll.salary_for_extras"
                                    class="flex items-center justify-between px-2 self-start">
                                    <span>Minutos adicionales a hra. de salida</span>
                                    <span>${{ payroll.salary_for_extras }}</span>
                                </p>
                            </div>
                            <div
                                class="w-1/3 md:w-1/3 lg:w-1/4 ml-auto lg:grid grid-cols-1 gap-y-1 border border-l-0 border-black">
                                <h2 class="border-b border-black py-px px-2 self-start">DEDUCCIONES</h2>
                                <p v-for="(discount, index) in payroll.discounts" :key="index"
                                    class="flex items-center justify-between px-2 self-start">
                                    <span>{{ discount.description }}</span>
                                    <span>${{ discount.amount }}</span>
                                </p>
                            </div>
                        </article>
                        <p class="text-xs w-1/4 lg:w-1/6 ml-auto flex justify-between font-bold text-[#373737] mt-3 mr-3">
                            <span>Total:</span>
                            <span>${{ payroll.paid }}</span>
                        </p>
                    </div>
                    <!-- <p v-else class="text-gray-500 text-xs pt-2 text-center">Nómina en curso</p> -->
                </div>
            </div>
        </div>

        <div class="mt-5 text-bold text-lg text-gray-700">
            <p class="my-2 ml-5">Detalle de nómina</p>
            <PayRollTable :payroll="payroll_selected" />
        </div>

    </AppLayout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout.vue';
import PayRollTable from '@/Components/PayRollTable.vue';

export default {
    data() {
        return {
            week_days: [
                'Domingo',
                'Lunes',
                'Martes',
                'Miércoles',
                'Jueves',
                'Viernes',
                'Sábado'
            ],
            payroll_selected: this.payrolls.data[0]
        };
    },
    components: {
        AppLayout,
        PayRollTable,
    },
    methods: {
        getShiftsWorked(payrollUser) {
            return payrollUser.week_attendance.days_as_double
                + payrollUser.week_attendance.attendances;
        },
    },
    props: {
        payrolls: Object,
    },
}
</script>

<style>
.contenedor {
    display: flex;
    overflow-x: scroll;
    /* Permite el desplazamiento horizontal */
    white-space: nowrap;
    /* Evita el salto de línea de las secciones */
}
</style>