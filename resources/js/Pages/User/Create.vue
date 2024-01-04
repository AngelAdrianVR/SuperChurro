<template>
  <AppLayout title="Crear nuevo usuario">
    <template #header>
      <div class="flex items-center mt-2">
        <Back />
        <h2 class="font-semibold text-xl text-gray-800 text-center ml-5 lg:ml-28">
          Crear nuevo usuario
        </h2>
      </div>
    </template>

    <div class="
        max-w-5xl
        md:mx-auto
        mt-5
        px-5
        py-8
        bg-transparent
        mx-4
        relative
      ">
      <div class="absolute -top-10 left-72 lg:-top-5 lg:-left-40 bg-white rounded-full py-5 px-6">
      <i class="fa-solid fa-user text-4xl lg:text-8xl text-gray4"></i>
      </div>
      <form class="" @submit.prevent="store">
        <h1 class="font-bold mb-9 ml-3 col-span-full">Datos personales</h1>
        
        <div class="mb-3 w-full">
          <InputLabel value="Nombre *" class="ml-3 mb-1 text-sm" />
          <input v-model="form.name" type="text" autocomplete="off" class="input"
           placeholder="Escribe el nombre del colaborador" />
          <InputError :message="$page.props?.errors.name" />
        </div>

        <div class="mb-3 w-full">
          <InputLabel value="Correo electrónico *" class="ml-3 mb-1 text-sm" />
          <input v-model="form.email" type="text" autocomplete="off" class="input"
           placeholder="Escribe el correo del colaborador" />
          <InputError :message="$page.props?.errors.email" />
        </div>

        <div class="mb-3 w-full">
          <InputLabel value="Número de teléfono *" class="ml-3 mb-1 text-sm" />
          <input v-model="form.phone_number" type="text" autocomplete="off" class="input"
           placeholder="Escribe el correo del colaborador" />
          <InputError :message="$page.props?.errors.phone_number" />
        </div>

        <div class="mb-3 w-full">
          <InputLabel value="Fecha de nacimiento *" class="ml-3 mb-1 text-sm" />
          <input v-model="form.employee_properties.birthdate" type="date" autocomplete="off" class="input"
           placeholder="Seleccione la fecha" />
          <InputError :message="$page.props?.errors['employee_properties.birthdate']" />
        </div>

        <h1 class="font-bold my-9 ml-3 col-span-full">Datos laborales</h1>

        <div class="mb-3 w-full">
          <InputLabel value="Fecha de Ingreso *" class="ml-3 mb-1 text-sm" />
          <input v-model="form.created_at" type="date" autocomplete="off" class="input"
           placeholder="Seleccione la fecha" />
          <!-- <InputError :message="$page.props?.errors['employee_properties.birthdate']" />  -->
        </div>

        <div class="mb-3 w-full">
          <InputLabel value="Salario base *" class="ml-3 mb-1 text-sm" />
          <input v-model="form.employee_properties.base_salary" type="number" min="0" autocomplete="off" class="input"
           placeholder="Escriba el salario" />
          <InputError :message="$page.props?.errors['employee_properties.base_salary']" />
        </div>

        <div class="mb-3">
          <label class="w-full text-sm text-gray-500 block">Bonos</label>
          <div class="grid grid-cols-2 lg:grid-cols-3 gap-1">
            <label v-for="bonus in bonuses" :key="bonus.id">
              <input v-model="form.employee_properties.bonuses" type="checkbox" :value="bonus.id" class="rounded border-gray-300 text-sky-600 shadow-sm focus:border-sky-300 focus:ring focus:ring-sky-200 focus:ring-opacity-50" />
              <span class="ml-1 text-xs text-gray-600">{{ bonus.name }}</span>
            </label>
          </div>
        </div>

        <label class="block mt-3 w-full text-sm text-gray-500">Días de trabajo</label>
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
                  class="h-4 w-4 border-gray-300 text-sky-600 focus:ring-2 focus:ring-sky-300" :aria-labelledby="'shift-option-'+index"
                  :aria-describedby="'shift-option-'+index" checked="">
                <label :for="'shift-option-'+index" class="text-sm font-medium text-gray-900 ml-2 block">
                  {{ shift }}
                </label>
              </div>
            </div>
            <ThirthButton @click="addWorkDay" class="mb-4"><i class="fa-solid fa-plus mr-2"></i>Agregar día de trabajo</ThirthButton>
            <div>
              <span v-for="(item,index) in form.employee_properties.work_days" :key="item.day" class="bg-sky-100 px-1 py-px rounded-md mr-3 text-xs">
                {{ week_days[item.day] }} - {{ item.shift }} <button type="button" @click="deleteUser(index)">x</button>
              </span>
            </div>
          </div>
          <label for="floating_work_days" class="
              absolute
              text-sm text-gray-500
              dark:text-gray-700
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
import ThirthButton from "@/Components/ThirthButton.vue";
import InputLabel from "@/Components/InputLabel.vue";
import Back from "@/Components/Back.vue";
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
        bonuses: []
      },
      created_at: null,
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
        'carrito 2 turnos',
        'Don Victor'
      ],
      selected_day: 0,
      selected_shift: 'carrito 2 turnos',
    };
  },
  components: {
    AppLayout,
    PayRollTable,
    PrimaryButton,
    InputError,
    Checkbox,
    FileUploader,
    ThirthButton,
    InputLabel,
    Back,
    Link,
  },
  props: {
    bonuses: Array,
  },
  methods: {
    store() {
      this.form.post(this.route("users.store"));
    },
    addWorkDay() {
      this.form.employee_properties.work_days.push({day: this.selected_day, shift: this.selected_shift});
    },
    deleteWorkDay(index) {
      this.form.employee_properties.work_days.splice(index);
    },
  },
};
</script>