<template>
    <div class="globe-container">
        <div v-for="current_payroll in payroll.data.users" :key="current_payroll.id"
            class="rounded-md border-2 border-gray-400 px-3 py-2">
            <div class="globe-title pb-2">
                Semana {{ payroll.data.week }}: {{ payroll.data.start_date }} al {{ payroll.data.end_date }}
            </div>
            <div class="text-sm mb-2 bg-sky-200 px-1 py-px rounded-sm">
                <i class="fa-solid fa-user mr-1"></i> {{ current_payroll.user.name }}
            </div>
            <div class="grid grid-cols-3 gap-2 text-sm">
                <span v-for="(discount, index) in current_payroll.discounts" :key="index">-<i
                        class="text-red-400 fa-solid fa-dollar mr-1"></i>{{ discount.amount }} ({{
                            discount.description
                        }})</span>
                <span v-if="current_payroll.vacation_premium">+<i class="text-green-700 fa-solid fa-dollar mr-1"></i>{{
                    current_payroll.vacation_premium
                }} prima
                    vacacional</span>
                <span>+<i class="text-green-700 fa-regular fa-dollar-sign mr-1"></i>{{ current_payroll.base_salary }} salario
                    base</span>
                <span>+<i class="text-green-700 fa-regular fa-dollar-sign mr-1"></i>{{ current_payroll.commissions }}
                    comisiones</span>
                <span v-if="current_payroll.salary_for_extras">+<i class="text-green-700 fa-regular fa-dollar-sign mr-1"></i>{{
                    current_payroll.salary_for_extras
                }}
                    tiempo extra</span>
                <span><i class="text-green-700 fa-regular fa-dollar-sign mr-1"></i>{{ current_payroll.paid }} total</span>
                <span><i class="text-green-400 fa-solid fa-check mr-1"></i>{{ current_payroll.week_attendance.attendances }}
                    Asistencias</span>
                <span><i class="text-yellow-400 fa-solid fa-umbrella-beach mr-1"></i>{{
                    current_payroll.week_attendance.vacations
                }} Vacaciones</span>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: {
        payroll: Object,
    },
}
</script>
