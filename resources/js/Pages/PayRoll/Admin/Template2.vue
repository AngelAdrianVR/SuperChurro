<template>
    <div class="grid grid-cols-2 gap-1">
        <div class="rounded-md border-2 border-gray-400 px-3 py-2 leading-none text-xs">
            <div class="globe-title">
                Semana {{ payroll_user.data.payroll.week }}: {{ payroll_user.data.payroll.start_date }} al {{
                    payroll_user.data.payroll.end_date
                }}
            </div>
            <p style="font-size: 8px;">Av. Manuel Ávila Camacho 1950, Interior de plaza patria, Isla comercial en frente
                de
                negocio comercial conocido como "ALDO CONTI", en el área común, Col. Jacarandas, Zapopan Jalisco.
            </p>
            <div class="mb-2 bg-sky-200 px-1 py-px rounded-sm">
                <i class="fa-solid fa-user mr-1"></i> {{ payroll_user.data.user.name }}
            </div>
            <div class="grid grid-cols-3 gap-2 mb-1">
                <span v-for="(discount, index) in payroll_user.data.discounts" :key="index">-<i
                        class="text-red-400 fa-solid fa-dollar mr-1"></i>{{ discount.amount }} ({{
                            discount.description
                        }})</span>
                <span v-for="(commission, index) in payroll_user.data.commissions" :key="index">
                    +<i class="text-green-700 fa-solid fa-dollar mr-1"></i>
                    {{ commission }} comisión {{ week_days[index] }}
                </span>
                <span v-for="(bonus, index) in payroll_user.data.bonuses" :key="index">
                    +<i class="text-green-700 fa-solid fa-dollar mr-1"></i>
                    {{ bonus.amount }} {{ bonus.name }}
                </span>
                <span v-if="payroll_user.data.vacation_premium">+<i
                        class="text-green-700 fa-solid fa-dollar mr-1"></i>{{
                            payroll_user.data.vacation_premium
                        }} prima
                    vacacional</span>
                <span>+<i class="text-green-700 fa-regular fa-dollar-sign mr-1"></i>{{ payroll_user.data.base_salary }}
                    salario base semana</span>
                <span v-if="payroll_user.data.salary_for_extras">+<i
                        class="text-green-700 fa-regular fa-dollar-sign mr-1"></i>{{
                            payroll_user.data.salary_for_extras
                        }}
                    tiempo extra</span>
                <span class="font-bold underline"><i class="text-green-700 fa-regular fa-dollar-sign mr-1"></i>{{
                    payroll_user.data.paid
                }}
                    total</span>
                <span><i class="text-green-400 fa-solid fa-check mr-1"></i>{{
                    payroll_user.data.week_attendance.attendances
                }}
                    Asistencias</span>
                <span><i class="text-yellow-400 fa-solid fa-umbrella-beach mr-1"></i>{{
                    payroll_user.data.week_attendance.vacations
                }} Vacaciones</span>
            </div>
            <small style="font-size: 7px;">
                RECIBI DE LA EMPRESA "PURO CHURRO" LA CANTIDAD SEÑALADA MISMA QUE CUBRE LAS PERCEPCIONES
                QUE ME CORRESPONDEN EN EL PERIODO INDICADO, NO EXISTIENDO NINGUN ADEUDO POR PARTE DE LA EMPRESA PARA CON
                EL SUSCRITO, PUES ESTOY TOTALMENTE PAGADO DE MIS SALARIOS Y ESTE DOCUMENTO ES UNICAMENTE PARA FINES
                INFORMATIVOS SIN QUE PUEDA SER USADO COMO MEDIO PROBATORIO ANTE UNA AUTORIDAD Y/O INSTITUCION DE
                CREDITO.
            </small>
            <div class="flex justify-between mt-4">
                <span class="border-t-2 px-10 border-gray-400 text-gray-500">Fecha</span>
                <span class="border-t-2 px-10 border-gray-400 text-gray-500">Firma</span>
            </div>
        </div>
    </div>
</template>
<script>
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
            ]
        };
    },
    props: {
        payroll_user: Object,
    },
}
</script>
