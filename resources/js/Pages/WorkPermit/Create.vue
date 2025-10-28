<template>
  <AppLayout title="Solicitud de permiso">
    <template #header>
      <div class="flex items-center mt-2">
        <Back />
        <h2 class="font-semibold text-xl text-gray-800 dar:text-gray-200 text-center ml-5 lg:ml-28">
          Solicitud de permiso
        </h2>
      </div>
    </template>

    <!-- Modernized: Alerta con diseño actualizado y más sutil -->
    <div class="max-w-2xl md:mx-auto mt-10 mx-4">
      <div class="bg-amber-50 dar:bg-amber-900/20 border-l-4 border-amber-400 dar:border-amber-600 p-4 rounded-lg shadow-md" role="alert">
        <div class="flex">
          <div class="flex-shrink-0 py-1">
            <svg class="fill-current h-6 w-6 text-amber-500 dar:text-amber-400 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
              <path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z" />
            </svg>
          </div>
          <div class="text-amber-800 dar:text-amber-200">
            <p class="font-bold">Vacaciones disponibles</p>
            <p class="text-sm">
              Tienes
              <strong>{{ $page.props.user.employee_properties?.vacations?.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",") }}</strong>
              días de vacaciones
            </p>
          </div>
        </div>
      </div>
    </div>

    <!-- Modernized: Contenedor principal estilo "card" -->
    <div class="max-w-2xl md:mx-auto mt-5 mb-10 p-6 sm:p-8 bg-white dar:bg-gray-800 shadow-xl rounded-lg mx-4">
      
      <!-- Modernized: Formulario con espaciado vertical -->
      <form @submit.prevent="store" class="space-y-6">
        
        <div>
          <InputLabel for="permission_type" value="Tipo de permiso *" class="mb-1 text-sm" />
          <!-- Modernized: Clases de Tailwind estándar para select -->
          <select
            id="permission_type"
            @change="
              is_full_day = permission_types.find(
                (item) => item.id === form.permission_type_id
              )?.is_full_day;
              vacation_id = permission_types.find(
                (item) => item.id === form.permission_type_id
              )?.id;
            "
            class="w-full rounded-md border-gray-300 dar:border-gray-600 dar:bg-gray-700 dar:text-gray-200 focus:border-indigo-500 dar:focus:border-indigo-600 focus:ring-indigo-500 dar:focus:ring-indigo-600"
            v-model="form.permission_type_id"
          >
            <option disabled :value="null" class="text-gray-500">
              -- Tipo de Permiso --
            </option>
            <option
              class="text-gray-500 dar:text-gray-300"
              v-for="permission_type in permission_types"
              :key="permission_type.id"
              :value="permission_type.id"
            >
              {{ permission_type.name }}
            </option>
          </select>
          <InputError :message="$page.props?.errors.permission_type_id" class="mt-1" />
        </div>

        <div>
          <InputLabel for="date" value="Fecha de permiso *" class="mb-1 text-sm" />
          <!-- Modernized: Clases de Tailwind estándar para input -->
          <input 
            id="date"
            v-model="form.date" 
            type="date" 
            autocomplete="off" 
            class="w-full rounded-md border-gray-300 dar:border-gray-600 dar:bg-gray-700 dar:text-gray-200 focus:border-indigo-500 dar:focus:border-indigo-600 focus:ring-indigo-500 dar:focus:ring-indigo-600"
            placeholder="Seleccione la fecha" 
          />
          <InputError :message="$page.props?.errors.date" class="mt-1" />
        </div>

        <div v-if="form.permission_type_id == 1 || form.permission_type_id == 2">
          <InputLabel for="time_requested" value="Tiempo requerido (minutos)" class="mb-1 text-sm" />
          <!-- Modernized: Clases de Tailwind estándar para input number -->
          <input 
            id="time_requested"
            v-model="form.time_requested" 
            type="number" 
            min="0" 
            autocomplete="off" 
            class="w-full rounded-md border-gray-300 dar:border-gray-600 dar:bg-gray-700 dar:text-gray-200 focus:border-indigo-500 dar:focus:border-indigo-600 focus:ring-indigo-500 dar:focus:ring-indigo-600"
            placeholder="Ej: 30" 
          />
          <InputError :message="$page.props?.errors.time_requested" class="mt-1" />
        </div>

        <div>
          <InputLabel for="description" value="Notas o comentarios (Opcional)" class="mb-1 text-sm" />
          <!-- Modernized: Clases de Tailwind estándar para textarea -->
          <textarea
            id="description"
            v-model="form.description"
            rows="3"
            type="text"
            autocomplete="off"
            placeholder="Escribe aquí el motivo o detalles adicionales..."
            class="w-full rounded-md border-gray-300 dar:border-gray-600 dar:bg-gray-700 dar:text-gray-200 focus:border-indigo-500 dar:focus:border-indigo-600 focus:ring-indigo-500 dar:focus:ring-indigo-600"
          />
          <InputError :message="$page.props?.errors.description" class="mt-1" />
        </div>

        <!-- Modernized: Botón alineado a la derecha -->
        <div class="flex flex-col items-end pt-4">
          <PrimaryButton
            :disabled="
              form.processing ||
              (vacation_id == 3 && $page.props.user.employee_properties?.vacations < 1)
            "
          >
            <span v-if="form.processing">Enviando...</span>
            <span v-else>Solicitar Permiso</span>
          </PrimaryButton>
          
          <p
            v-if="vacation_id == 3 && $page.props.user.employee_properties?.vacations < 1"
            class="mt-2 text-sm text-red-600 dar:text-red-400"
          >
            Necesitas tener al menos 1 día de vacaciones.
          </p>
        </div>
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
      permission_type_id: null, // Asegurado que inicie como null para el placeholder
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
    Link,
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

