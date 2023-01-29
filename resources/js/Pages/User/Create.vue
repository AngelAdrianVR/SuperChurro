<template>
  <AppLayout title="Crear nuevo usuario">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Crear nuevo usuario
      </h2>
    </template>

    <div class="flex justify-start">
      <Link :href="route('users.index')" class="flex items-center mt-2 text-slate-700">
      <i class="
            fas
            fa-long-arrow-alt-left
            text-lg
            active:bg-gray-300
            bg-opacity-100
            rounded-full
            w-7
            h-7
            pl-1
            ml-2
          "></i>
      <span class="ml-1 cursor-default">Atrás</span>
      </Link>
    </div>

    <!-- component -->
    <!-- This is an example component -->
    <div class="
        max-w-2xl
        md:mx-auto
        mt-5
        shadow-md shadow-gray-500/70
        rounded-lg
        px-5
        py-8
        bg-white
        mx-4
        my-2
      ">
      <form @submit.prevent="store">
        <div class="relative z-0 mb-6 w-full group">
          <input v-model="form.name" type="text" name="floating_time_requested" autocomplete="off" required class="
              block
              py-2.5
              px-0
              w-full
              text-sm text-gray-900
              bg-transparent
              border-0 border-b-2 border-gray-300
              appearance-none
              dark:text-white dark:border-gray-600 dark:focus:border-stone-500
              focus:outline-none focus:ring-0 focus:border-stone-600
              peer
            " placeholder=" " />
          <label for="floating_name" class="
              absolute
              text-sm text-gray-500
              dark:text-gray-400
              duration-300
              transform
              -translate-y-6
              scale-75
              top-3
              -z-10
              origin-[0]
              peer-focus:left-0
              peer-focus:text-stone-600
              peer-focus:dark:text-stone-500
              peer-placeholder-shown:scale-100
              peer-placeholder-shown:translate-y-0
              peer-focus:scale-75 peer-focus:-translate-y-6
            ">Nombre*</label>
          <InputError :message="$page.props?.errors.name" />
        </div>
        <div class="relative z-0 mb-6 w-full group">
          <input v-model="form.email" type="email" name="floating_email" autocomplete="off" class="
              block
              py-2.5
              px-0
              w-full
              text-sm text-gray-900
              bg-transparent
              border-0 border-b-2 border-gray-300
              appearance-none
              dark:text-white dark:border-gray-600 dark:focus:border-stone-500
              focus:outline-none focus:ring-0 focus:border-stone-600
              peer
            " placeholder=" " />
          <label for="floating_email" class="
              absolute
              text-sm text-gray-500
              dark:text-gray-400
              duration-300
              transform
              -translate-y-6
              scale-75
              top-3
              -z-10
              origin-[0]
              peer-focus:left-0
              peer-focus:text-stone-600
              peer-focus:dark:text-stone-500
              peer-placeholder-shown:scale-100
              peer-placeholder-shown:translate-y-0
              peer-focus:scale-75 peer-focus:-translate-y-6
            ">Email</label>
        </div>
        <div class="relative z-0 mb-6 w-full group">
          <input v-model="form.phone_number" type="phone_number" name="floating_phone_number" required
            autocomplete="off" class="
              block
              py-2.5
              px-0
              w-full
              text-sm text-gray-900
              bg-transparent
              border-0 border-b-2 border-gray-300
              appearance-none
              dark:text-white dark:border-gray-600 dark:focus:border-stone-500
              focus:outline-none focus:ring-0 focus:border-stone-600
              peer
            " placeholder=" " />
          <label for="floating_phone_number" class="
              absolute
              text-sm text-gray-500
              dark:text-gray-400
              duration-300
              transform
              -translate-y-6
              scale-75
              top-3
              -z-10
              origin-[0]
              peer-focus:left-0
              peer-focus:text-stone-600
              peer-focus:dark:text-stone-500
              peer-placeholder-shown:scale-100
              peer-placeholder-shown:translate-y-0
              peer-focus:scale-75 peer-focus:-translate-y-6
            ">Número de contacto*</label>
          <InputError :message="$page.props?.errors.phone_number" />
        </div>
        <div class="relative z-0 mb-6 w-full group">
          <input v-model="form.employee_properties.birthdate" type="date" name="floating_birthdate" autocomplete="off"
            required class="
              block
              py-2.5
              px-0
              w-full
              text-sm text-gray-900
              bg-transparent
              border-0 border-b-2 border-gray-300
              appearance-none
              dark:text-white dark:border-gray-600 dark:focus:border-stone-500
              focus:outline-none focus:ring-0 focus:border-stone-600
              peer
            " placeholder=" " />
          <label for="floating_birthdate" class="
              absolute
              text-sm text-gray-500
              dark:text-gray-400
              duration-300
              transform
              -translate-y-6
              scale-75
              top-3
              -z-10
              origin-[0]
              peer-focus:left-0
              peer-focus:text-stone-600
              peer-focus:dark:text-stone-500
              peer-placeholder-shown:scale-100
              peer-placeholder-shown:translate-y-0
              peer-focus:scale-75 peer-focus:-translate-y-6
            ">Fecha de nacimiento*</label>
          <InputError :message="$page.props?.errors.employee_properties?.birthdate" />
        </div>
        <div class="relative z-0 mb-6 w-full group">
          <input v-model="form.employee_properties.base_salary" type="number" name="floating_base_salary"
            autocomplete="off" required class="
              block
              py-2.5
              px-0
              w-full
              text-sm text-gray-900
              bg-transparent
              border-0 border-b-2 border-gray-300
              appearance-none
              dark:text-white dark:border-gray-600 dark:focus:border-stone-500
              focus:outline-none focus:ring-0 focus:border-stone-600
              peer
            " placeholder=" " />
          <label for="floating_base_salary" class="
              absolute
              text-sm text-gray-500
              dark:text-gray-400
              duration-300
              transform
              -translate-y-6
              scale-75
              top-3
              -z-10
              origin-[0]
              peer-focus:left-0
              peer-focus:text-stone-600
              peer-focus:dark:text-stone-500
              peer-placeholder-shown:scale-100
              peer-placeholder-shown:translate-y-0
              peer-focus:scale-75 peer-focus:-translate-y-6
            ">Salario base*</label>
          <InputError :message="$page.props?.errors.employee_properties?.base_salary" />
        </div>
        <label class="mb-3 w-full text-sm text-gray-500">Días de trabajo</label>
          <div class="">
            <select class="
            bg-gray-200
            mb-3
            mr-2
            rounded-lg
            border border-gray-300
            text-gray-500
            focus:border-stone-500 focus:text-stone-500
          " v-model="selected_day">
              <option disabled selected class="text-gray-500" value="">
                -- Selecciona un turno --
              </option>
              <option v-for="(week_day, index) in week_days" :key="index" class="text-gray-500" :value="index">
                {{ week_day }}
              </option>
            </select>
            <div class="flex flex-col mb-4">
              <div v-for="(shift, index) in shifts" :key="index" class="flex items-center mr-3">
                <input v-model="selected_shift" :id="'shift-option-'+index" type="radio" name="shift" :value="shift"
                  class="h-4 w-4 border-gray-300 focus:ring-2 focus:ring-blue-300" :aria-labelledby="'shift-option-'+index"
                  :aria-describedby="'shift-option-'+index" checked="">
                <label :for="'shift-option-'+index" class="text-sm font-medium text-gray-900 ml-2 block">
                  {{ shift }}
                </label>
              </div>
            </div>
            <SecondaryButton @click="addWorkDay" class="mb-4">Agregar día</SecondaryButton>
            <div>
              <span v-for="item in form.employee_properties.work_days" :key="item.day" class="bg-sky-100 px-1 py-px rounded-md mr-3 text-xs">
                {{ week_days[item.day] }} - {{ item.shift }}
              </span>
            </div>
          </div>
          <label for="floating_work_days" class="
              absolute
              text-sm text-gray-500
              dark:text-gray-400
              duration-300
              transform
              -translate-y-6
              scale-75
              top-3
              -z-10
              origin-[0]
              peer-focus:left-0
              peer-focus:text-stone-600
              peer-focus:dark:text-stone-500
              peer-placeholder-shown:scale-100
              peer-placeholder-shown:translate-y-0
              peer-focus:scale-75 peer-focus:-translate-y-6
            ">Días de trabajo*</label>
          <InputError :message="$page.props?.errors.employee_properties?.work_days" />

        <label class="text-gray-600 my-4"> Documentos del empleado
          <FileUploader @input="form.resources = $event.target.files" />
        </label>

        <div class="flex justify-center lg:justify-end">
          <PrimaryButton :disabled="form.processing">Crear</PrimaryButton>
        </div>
      </form>
    </div>
  </AppLayout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import PayRollTable from "@/Components/PayRollTable.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputError from "@/Components/InputError.vue";
import FileUploader from "@/Components/FileUploader.vue";
import Checkbox from "@/Components/Checkbox.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import { Link, useForm } from "@inertiajs/inertia-vue3";
export default {
  data() {
    const form = useForm({
      name: null,
      email: "",
      phone_number: "",
      employee_properties: {
        birthdate: "",
        base_salary: "",
        work_days: [],
        vacations: 0,
        vacations_updated_date: new Date().toISOString().split('T')[0],
      },
      resources: null,
    });
    return {
      form,
      week_days: [
        'Domingo',
        'Lunes',
        'Martes',
        'Miércoles',
        'Jueves',
        'Viernes',
        'Sábado',
      ],
      shifts: [
        'cocina',
        'carrito matutino',
        'carrito vespertino',
        'carrito 2 turnos'
      ],
      selected_day: 0,
      selected_shift: 'carrito 2 turnos',
    };
  },
  components: {
    AppLayout,
    PayRollTable,
    Link,
    PrimaryButton,
    InputError,
    Checkbox,
    FileUploader,
    SecondaryButton,
  },
  props: {

  },
  methods: {
    store() {
      this.form.post(this.route("users.store"));
    },
    addWorkDay() {
      this.form.employee_properties.work_days.push({day: this.selected_day, shift: this.selected_shift});
    },
  },
};
</script>