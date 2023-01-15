<template>
  <AppLayout title="Crear nuevo usuario">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Crear nuevo usuario
      </h2>
    </template>

    <div class="flex justify-start">
      <Link
        :href="route('users.index')"
        class="flex items-center mt-2 text-slate-700"
      >
        <i
          class="
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
          "
        ></i>
        <span class="ml-1 cursor-default">Atrás</span>
      </Link>
    </div>

    <!-- component -->
    <!-- This is an example component -->
    <div
      class="
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
      "
    >
      <form @submit.prevent="store">
        <div class="relative z-0 mb-6 w-full group">
          <input
            v-model="form.name"
            type="text"
            name="floating_time_requested"
            autocomplete="off"
            required
            class="
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
            "
            placeholder=" "
          />
          <label
            for="floating_name"
            class="
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
            "
            >Nombre*</label
          >
          <InputError :message="$page.props?.errors.name" />
        </div>
        <div class="relative z-0 mb-6 w-full group">
          <input
            v-model="form.email"
            type="email"
            name="floating_email"
            autocomplete="off"
            class="
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
            "
            placeholder=" "
          />
          <label
            for="floating_email"
            class="
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
            "
            >Email</label
          >
        </div>
        <div class="relative z-0 mb-6 w-full group">
          <input
            v-model="form.phone_number"
            type="phone_number"
            name="floating_phone_number"
            required
            autocomplete="off"
            class="
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
            "
            placeholder=" "
          />
          <label
            for="floating_phone_number"
            class="
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
            "
            >Número de contacto*</label
          >
          <InputError :message="$page.props?.errors.phone_number" />
        </div>
        <div class="relative z-0 mb-6 w-full group">
          <input
            v-model="form.employee_properties.birthdate"
            type="date"
            name="floating_birthdate"
            autocomplete="off"
            required
            class="
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
            "
            placeholder=" "
          />
          <label
            for="floating_birthdate"
            class="
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
            "
            >Fecha de nacimiento*</label
          >
          <InputError :message="$page.props?.errors.employee_properties?.birthdate" />
        </div>
        <div class="relative z-0 mb-6 w-full group">
          <input
            v-model="form.employee_properties.base_salary"
            type="number"
            name="floating_base_salary"
            autocomplete="off"
            required
            class="
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
            "
            placeholder=" "
          />
          <label
            for="floating_base_salary"
            class="
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
            "
            >Salario base*</label
          >
          <InputError :message="$page.props?.errors.employee_properties?.base_salary" />
        </div>
        
        <div>
        <select
          class="
            bg-gray-200
            mb-7
            mr-2
            rounded-lg
            border border-gray-300
            text-gray-500
            focus:border-stone-500 focus:text-stone-500
          "
          v-model="form.employee_properties.shifts"
        >
          <option disabled selected class="text-gray-500" value="">
            -- Seleeciona un turno --
          </option>
          <option
            class="text-gray-500"
            value="cocina"
          >
            Cocina
          </option>
          <option
            class="text-gray-500"
            value="carrito matutino"
          >
            Carrito T/M
          </option>
          <option
            class="text-gray-500"
            value="carrito vespertino"
          >
            Carrito T/V
          </option>
        </select>
        </div>
        <label class="mb-6 w-full text-sm text-gray-500">Días de trabajo
            <div class="grid grid-cols-3 gap-2 mt-3">
                <label class="flex items-center col-span-1">
                    <input  v-model="form.employee_properties.work_days" type="checkbox" value="0" name="sunday" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    <span class="ml-2 text-sm text-gray-600">Domingo</span>
                </label>
                <label class="flex items-center col-span-1">
                    <input  v-model="form.employee_properties.work_days" type="checkbox" value="1" name="monday" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    <span class="ml-2 text-sm text-gray-600">Lunes</span>
                </label>
                <label class="flex items-center col-span-1">
                    <input  v-model="form.employee_properties.work_days" type="checkbox" value="2" name="tuesday" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    <span class="ml-2 text-sm text-gray-600">Martes</span>
                </label>
                <label class="flex items-center col-span-1">
                    <input  v-model="form.employee_properties.work_days" type="checkbox" value="3" name="wednesday" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    <span class="ml-2 text-sm text-gray-600">Miércoles</span>
                </label>
                <label class="flex items-center col-span-1">
                    <input  v-model="form.employee_properties.work_days" type="checkbox" value="4" name="thursday" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    <span class="ml-2 text-sm text-gray-600">Jueves</span>
                </label>
                <label class="flex items-center col-span-1">
                    <input  v-model="form.employee_properties.work_days" type="checkbox" value="5" name="fruday" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    <span class="ml-2 text-sm text-gray-600">Viernes</span>
                </label>
                <label class="flex items-center col-span-1">
                    <input  v-model="form.employee_properties.work_days" type="checkbox" value="6" name="saturday" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    <span class="ml-2 text-sm text-gray-600">Sábado</span>
                </label>
            </div>
          <label
            for="floating_work_days"
            class="
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
            "
            >Días de trabajo*</label
          >
          <InputError :message="$page.props?.errors.employee_properties?.work_days" />
        </label>

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
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
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
          shifts: "",
          vacations: 0,
          resources: null,
      },
    });
    return {
      form,
    };
  },
  components: {
    AppLayout,
    PayRollTable,
    Link,
    useForm,
    PrimaryButton,
    InputError,
    Checkbox,
    FileUploader,
  },
  props: {

  },
  methods: {
    store() {
      this.form.post(this.route("users.store"));
    },
  },
};
</script>