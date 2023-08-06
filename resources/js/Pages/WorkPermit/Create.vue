<template>
  <AppLayout title="Solicitud de permiso">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Solicitud de permiso
      </h2>
    </template>

    <div
      class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md"
      role="alert"
    >
      <div class="flex">
        <div class="py-1">
          <svg
            class="fill-current h-6 w-6 text-teal-500 mr-4"
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 20 20"
          >
            <path
              d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"
            />
          </svg>
        </div>
        <div>
          <p class="font-bold">Vacaciones disponibles</p>
          <p class="text-sm">
            Tienes
            <strong>{{ $page.props.user.employee_properties?.vacations }}</strong> días de
            vacaciones
          </p>
        </div>
      </div>
    </div>

    <div class="flex justify-start">
      <Link
        :href="route('work-permits.index')"
        class="flex items-center mt-2 text-secondary"
      >
        <i
          class="fa-solid fa-angle-left text-lg hover:bg-gray-300 bg-opacity-100 rounded-full w-7 h-7 pl-1 ml-5"
        ></i>
        <span class="ml-1 cursor-default">Atrás</span>
      </Link>
    </div>

    <!-- component -->
    <!-- This is an example component -->
    <div
      class="max-w-2xl md:mx-auto mt-5 shadow-md shadow-gray-500/70 rounded-lg px-5 py-8 bg-white mx-4"
    >
      <form @submit.prevent="store">
        <select
          @change="
            is_full_day = permission_types.find(
              (item) => item.id === form.permission_type_id
            )?.is_full_day;
            vacation_id = permission_types.find(
              (item) => item.id === form.permission_type_id
            )?.id;
          "
          class="select mb-5"
          required
          v-model="form.permission_type_id"
        >
          <option disabled selected class="text-gray-500" value="">
            -- Tipo de Permiso --
          </option>
          <option
            class="text-gray-500"
            v-for="permission_type in permission_types"
            :key="permission_type.id"
            :value="permission_type.id"
          >
            {{ permission_type.name }}
          </option>
        </select>
        <div class="relative z-0 mb-6 w-full group">
          <input
            v-model="form.date"
            type="date"
            name="floating_date"
            autocomplete="off"
            class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-gray-700 dark:border-gray-600 dark:focus:border-stone-500 focus:outline-none focus:ring-0 focus:border-stone-600 peer"
            placeholder=" "
            required
          />
          <label
            for="floating_date"
            class="absolute text-sm text-gray-500 dark:text-gray-700 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-stone-600 peer-focus:dark:text-stone-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
            >Fecha de permiso</label
          >
          <InputError :message="$page.props?.errors.date" />
        </div>
        <div v-if="!is_full_day" class="relative z-0 mb-6 w-full group">
          <input
            v-model="form.time_requested"
            type="number"
            step="0.1"
            name="floating_time_requested"
            autocomplete="off"
            class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-gray-700 dark:border-gray-600 dark:focus:border-stone-500 focus:outline-none focus:ring-0 focus:border-stone-600 peer"
            placeholder=" "
          />
          <label
            for="floating_time_requested"
            class="absolute text-sm text-gray-500 dark:text-gray-700 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-stone-600 peer-focus:dark:text-stone-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
            >Tiempo requerido en minutos</label
          >
          <InputError :message="$page.props?.errors.time_requested" />
        </div>
        <div class="relative z-0 mb-6 w-full group">
          <textarea
            v-model="form.description"
            rows="1"
            type="text"
            name="floating_description"
            autocomplete="off"
            class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-gray-700 dark:border-gray-600 dark:focus:border-stone-500 focus:outline-none focus:ring-0 focus:border-stone-600 peer"
            placeholder=" "
          />
          <label
            for="floating_description"
            class="absolute text-sm text-gray-500 dark:text-gray-700 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-stone-600 peer-focus:dark:text-stone-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
            >Notas o comentarios</label
          >
        </div>
        <div class="flex justify-center lg:justify-end">
          <!-- the button is configured to disabled when vacations == 0 and type of permit is vacations. ID of vacation = 3. change taking Id from database -->
          <PrimaryButton
            :disabled="
              form.processing ||
              (vacation_id == 3 && $page.props.user.employee_properties?.vacations < 1)
            "
            >Programar</PrimaryButton
          >
        </div>
        <p
          v-if="vacation_id == 3 && $page.props.user.employee_properties?.vacations < 1"
          class="mt-2 text-center text-sm text-red-600"
        >
          Necesitas tener al menos 1 día de vacaciones.
        </p>
      </form>
    </div>
  </AppLayout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputError from "@/Components/InputError.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
export default {
  data() {
    const form = useForm({
      time_requested: null,
      permission_type_id: null,
      description: "",
      date: "",
    });
    return {
      form,
      is_full_day: 0,
      vacation_id: 0,
    };
  },
  components: {
    AppLayout,
    Link,
    useForm,
    PrimaryButton,
    InputError,
  },
  props: {
    permission_types: Array,
  },
  methods: {
    store() {
      this.form.post(this.route("work-permits.store"));
    },
  },
};
</script>
