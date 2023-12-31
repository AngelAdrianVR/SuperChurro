<template>
    <AppLayout title="Nóminas">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">Nóminas</h2>
        </template>

        <div class="contenedor">
            <div class="globe-containe flex space-x-3">
                <div v-for="payroll in payrolls.data" :key="payroll.id" @click="payroll_selected = payroll"
                    class="globe hover:bg-gray-100 cursor-pointer w-[600px]"
                    :class="{ 'border-2 border-primary': payroll_selected.id === payroll.id }">
                    <div class="globe-title pb-2">
                        Semana {{ payroll.week }}: {{ payroll.start_date }} al {{ payroll.end_date }}
                    </div>
                    <div v-if="!payroll.is_active" class="grid grid-cols-3 gap-2 text-sm">
                        <span v-for="(discount, index) in payroll.discounts" :key="index">-<i
                                class="text-red-400 fa-solid fa-dollar mr-1"></i>{{ discount.amount }} ({{
                                    discount.description
                                }})
                        </span>
                        <span v-for="(bonus, index) in payroll.bonuses" :key="index">
                            +<i class="text-green-700 fa-solid fa-dollar mr-1"></i>
                            {{ bonus.amount }} {{ bonus.name }}
                        </span>
                        <span v-if="payroll.vacation_premium">+<i class="text-green-700 fa-solid fa-dollar mr-1"></i>{{
                            payroll.vacation_premium
                        }} prima
                            vacacional</span>
                        <span>+<i class="text-green-700 fa-regular fa-dollar-sign mr-1"></i>{{ payroll.base_salary }}
                            salario
                            base semana</span>
                        <span v-for="(commission, index) in payroll.commissions" :key="index">
                            +<i class="text-green-700 fa-solid fa-dollar mr-1"></i>
                            {{ commission }} comisión {{ week_days[index] }}
                        </span>
                        <span v-if="payroll.salary_for_extras">+<i
                                class="text-green-700 fa-regular fa-dollar-sign mr-1"></i>{{ payroll.salary_for_extras }}
                            tiempo extra</span>
                        <span><i class="text-green-700 fa-regular fa-dollar-sign mr-1"></i>{{ payroll.paid }} total</span>
                        <span><i class="text-green-400 fa-solid fa-check mr-1"></i>{{ payroll.week_attendance.attendances }}
                            Asistencias</span>
                        <span><i class="text-yellow-400 fa-solid fa-umbrella-beach mr-1"></i>{{
                            payroll.week_attendance.vacations
                        }} Vacaciones</span>
                    </div>
                    <p v-else class="text-gray-500 text-sm text-center">Nómina en curso</p>
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