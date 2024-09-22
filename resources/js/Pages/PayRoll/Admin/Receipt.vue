<template>
    <div class="mx-6 my-8 text-[10px] lg:text-sm">
        <section v-for="current in payroll.data.users" :key="current.id" class="border border-gray4 rounded-[3px] p-5 my-2">
            <h1 class="text-center">
                <b>Semana {{ payroll.data.week }}.</b> Del <b>{{ payroll.data.start_date }}</b> al <b>{{
                    payroll.data.end_date }}</b>
            </h1>
            <small class="text-[7px] lg:text-[10px] lg:mx-2 leading-3">Av. Manuel Ávila Camacho 1950, Interior de plaza
                patria, isla comercial enfrente
                de
                negocio comercial
                conocido como “Aldo Conti”, en el área común, Col. Jaracarandas, Zapopan, Jalisco. </small>
            <header
                class="bg-[#EDEDED] text-[#373737] text-[9px] lg:text-sm rounded-[3px] py-1 px-2 flex items-center justify-between font-bold">
                <span class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-3 h-3 lg:w-4 lg:h-4 mr-1">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                    </svg>
                    {{ current.user.name }}
                </span>
                <span>
                    Días trabajados: {{ current.week_attendance.attendances }}
                </span>
            </header>
            <article class="flex mt-2 text-[8px] lg:text-xs">
                <div
                    class="w-2/3 lg:w-3/4 mr-auto grid grid-cols-2 lg:grid-cols-3 gap-x-8 lg:gap-x-32 gap-y-1 border border-black">
                    <h2 class="col-span-full border-b border-black self-start py-px px-2">PERCEPCIONES</h2>
                    <p class="flex items-center justify-between px-2 self-start">
                        <span>Sueldo ({{ getShiftsWorked(current) }} turnos)</span>
                        <!-- Se resta del sueldo total el dinero de los dias de vacaciones sin la prima -->
                        <span>${{ current.week_attendance.vacations ? (current.raw_base_salary - ((current.raw_vacations * 100) / 125))?.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                             : current.base_salary }}</span>
                    </p>
                    <p v-for="bonus in getBonuses(current)" :key="bonus.name"
                        class="flex items-center justify-between px-2 self-start">
                        <span>{{ bonus.name }}</span>
                        <span>${{ bonus.amount }}</span>
                    </p>
                    <p v-if="current.extras" class="flex items-center justify-between px-2 self-start">
                        <span>Hrs. extra</span>
                        <span>${{ current.total_extras }}</span>
                    </p>
                    <p v-if="current.week_attendance.vacations" class="flex items-center justify-between px-2 self-start">
                        <span>Vacaciones ({{ current.week_attendance.vacations }})</span>
                        <!-- se quita el 25% de prima vacacional -->
                        <span>${{ ((current.raw_vacations * 100) / 125 )?.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",")}}</span> 
                    </p>
                    <p v-if="current.week_attendance.vacations" class="flex items-center justify-between px-2 self-start">
                        <span>Prima vacacional</span>
                        <!-- se muestra unicamente la prima vacacional -->
                        <span>${{ ((current.raw_vacations * 25) / 125)?.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",") }}</span> 
                    </p>
                    <p v-if="current.week_attendance.holidays" class="flex items-center justify-between px-2 self-start">
                        <span>Día feriado</span>
                        <span>${{ current.paid_holiday }}</span>
                    </p>
                    <p v-if="current.week_attendance.paid_leaves" class="flex items-center justify-between px-2 self-start">
                        <span>Permisos con goce ({{ current.week_attendance.paid_leaves }})</span>
                        <span>${{ current.paid_leaves }}</span>
                    </p>
                    <p v-if="current.week_attendance.sickness" class="flex items-center justify-between px-2 self-start">
                        <span>Incapacidades ({{ current.week_attendance.sickness }})</span>
                        <span>${{ current.paid_sickness }}</span>
                    </p>
                    <p v-for="(commission, index) in getCommissions(current)" :key="index"
                        class="flex items-center justify-between px-2 self-start">
                        <span>{{ commission.concept }}</span>
                        <span>${{ commission.amount }}</span>
                    </p>
                    <p v-if="current.salary_for_extras" class="flex items-center justify-between px-2 self-start">
                        <span>Minutos adicionales a hra. de salida</span>
                        <span>${{ current.salary_for_extras }}</span>
                    </p>
                </div>
                <div class="w-1/3 md:w-1/3 lg:w-1/4 ml-auto lg:grid grid-cols-1 gap-y-1 border border-l-0 border-black">
                    <h2 class="border-b border-black py-px px-2 self-start">DEDUCCIONES</h2>
                    <p v-for="(discount, index) in current.discounts" :key="index"
                        class="flex items-center justify-between px-2 self-start">
                        <span>{{ discount.description }}</span>
                        <span>${{ discount.amount }}</span>
                    </p>
                </div>
            </article>
            <p class="w-1/4 lg:w-1/6 ml-auto flex justify-between font-bold text-[#373737] mt-3 mr-3">
                <span>Total:</span>
                <!-- si hay vacaciones resta el monto de vacaciones sin prima vacacional porque lo sumaba al total -->
                <span>${{ current.week_attendance.vacations ? (current.raw_paid - ((current.raw_vacations * 100) / 125))?.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",") : current.paid }}</span>
            </p>
            <small class="text-[6px] mt-3 leading-3">
                RECBÍ DE LA EMPRESA "PURO CHURRO" LA CANTIDAD SEÑALADA MISMA QUE CUBRE LAS PERCEPCIONES QUE ME CORRESPONDEN
                EN EL PERIODO INDICADO, NO EXISTIENDO NINGUN ADEUDO POR PARTE DE LA EMPRESA PARA CON EL SUSCRITO, PUES ESTOY
                TOTALMENTE PAGADO DE MIS SALARIOS Y ESTE DOCUMENTO ES UNICAMENTE PARA FINES INFORMATIVOS SIN QUE PUEDA SER
                USADO COMO MEDIO PROBATORIO ANTE UNA AUTORIDAD Y/O INSTITUCION DE CREDITO.
            </small>
            <div class="flex justify-between mt-4 text-[9px]">
                <span class="border-t-2 px-10 border-gray-400 text-gray-500">Fecha</span>
                <span class="border-t-2 px-10 border-gray-400 text-gray-500">Firma</span>
            </div>
        </section>
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
    methods: {
        getShiftsWorked(payrollUser) {
            return payrollUser.week_attendance.days_as_double
                + payrollUser.week_attendance.attendances;
        },
        getBonuses(payrollUser) {
            if (payrollUser.additional !== null) {
                return payrollUser.additional.bonuses;
            } else {
                return payrollUser.bonuses;
            }
        },
        getCommissions(payrollUser) {
            let commissions = [];
            let allCommisions = [];
            if (payrollUser.additional !== null) {
                allCommisions = payrollUser.additional.commissions;
            } else {
                allCommisions = payrollUser.commissions;
            }

            // filtrar comisiones
            allCommisions.forEach((item, index) => {
                const day = this.week_days[index];
                if (item > 0) {
                    const obj = {
                        concept: "Comisión " + day,
                        amount: item
                    };

                    commissions.push(obj);
                };
            });

            return commissions;
        }
    },
    props: {
        payroll: Object,
    },
}
</script>
