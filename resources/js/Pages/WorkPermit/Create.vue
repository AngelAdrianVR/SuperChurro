<template>
  <AppLayout title="Solicitud de permiso">
    <template #header>
      <div class="flex items-center mt-2">
          <Back />
          <h2 class="font-semibold text-xl text-gray-800 text-center ml-5 lg:ml-28">
            Solicitud de permiso
          </h2>
      </div>
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

    <div
      class="max-w-2xl md:mx-auto mt-5 rounded-lg px-5 py-8 bg-transparent border border-gray3 mx-4"
    >
      <form @submit.prevent="store">
        <InputLabel value="Tipo de permiso *" class="ml-3 mb-1 text-sm" />
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
          v-model="form.permission_type_id"
        >
          <option disabled selected class="text-gray-500">
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

        <div class="mb-3 w-full">
          <InputLabel value="Fecha de permiso *" class="ml-3 mb-1 text-sm" />
          <input v-model="form.date" type="date" autocomplete="off" class="input"
           placeholder="Seleccione la fecha" />
          <InputError :message="$page.props?.errors.date" />
        </div>

        <div v-if="form.permission_type_id == 1 || form.permission_type_id == 2" class="mb-3 w-full">
          <InputLabel value="Tiempo requerido" class="ml-3 mb-1 text-sm" />
          <input v-model="form.time_requested" type="number" min="0" autocomplete="off" class="input"
           placeholder="Tiempo en minutos" />
          <InputError :message="$page.props?.errors.time_requested" />
        </div>

        <div class="my-2 w-full">
          <InputLabel value="Notas o comentarios" class="ml-3 mb-1 text-sm" />
          <textarea
            v-model="form.description"
            rows="2"
            type="text"
            autocomplete="off"
            placeholder="Escribe la descripción"
            class="textarea"
          />
        </div>

        <div class="flex justify-center lg:justify-end mt-7">
          <!-- the button is configured to disabled when vacations == 0 and type of permit is vacations. ID of vacation = 3. change taking Id from database -->
          <PrimaryButton
            :disabled="
              form.processing ||
              (vacation_id == 3 && $page.props.user.employee_properties?.vacations < 1)
            "
            >Solicitar</PrimaryButton
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
import Back from "@/Components/Back.vue";
import InputLabel from "@/Components/InputLabel.vue";
import { Link, useForm } from "@inertiajs/inertia-vue3";

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
    PrimaryButton,
    InputError,
    InputLabel,
    Back,
    Link
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
