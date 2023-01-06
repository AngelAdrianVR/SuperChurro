<template>
  <AppLayout title="Solicitud de permiso">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Solicitud de permiso
      </h2>
    </template>

    <div class="flex justify-start">
      <Link
        :href="route('work-permits.index')"
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
      "
    >
      <form @submit.prevent="store">
        <select
          @change="
            is_full_day = permission_types.find(
              (item) => item.id === form.permission_type_id
            )?.is_full_day
          "
          class="
            bg-gray-200
            mb-7
            mr-2
            rounded-lg
            border border-gray-300
            text-gray-500
            focus:border-stone-500 focus:text-stone-500
          "
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
            required
          />
          <label
            for="floating_date"
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
            >Fecha de permiso</label
          >
          <InputError :message="$page.props?.errors.date" />
        </div>
        <div v-if="!is_full_day" class="relative z-0 mb-6 w-full group">
          <input
            v-model="form.time_requested"
            type="number"
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
            for="floating_time_requested"
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
            >Tiempo requerido (hrs)</label
          >
          <InputError :message="$page.props?.errors.time_requested" />
        </div>
        <div class="relative z-0 mb-6 w-full group">
          <input
            v-model="form.description"
            type="text"
            name="floating_description"
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
            for="floating_description"
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
            >Notas o comentarios</label
          >
        </div>
        <div class="flex justify-center lg:justify-end">
          <PrimaryButton :disabled="form.processing">Programar</PrimaryButton>
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
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
export default {
  data() {
    const form = useForm({
      time_requested: null,
      permission_type_id: "",
      description: "",
      date: "",
    });
    return {
      form,
      is_full_day: 0,
    };
  },
  components: {
    AppLayout,
    PayRollTable,
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