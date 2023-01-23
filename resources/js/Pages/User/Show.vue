<template>
  <AppLayout title="Usuario">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Opciones de usuario
      </h2>
    </template>



    <div class="flex justify-start ml-2">
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
          "></i>
      <span class="ml-1 cursor-default">Atrás</span>
      </Link>
    </div>

    <div class="flex justify-center items-center">

      <PrimaryButton v-if="$page.props.user.is_active" @click="$inertia.put(route('user.disable', $page.props.user.id))"
        class="!bg-red-600 m-2 shadow-md shadow-red-900/100">Dar de baja</PrimaryButton>
      <PrimaryButton v-else @click="$inertia.put(route('user.enable', $page.props.user.id))"
        class="!bg-green-600 m-2 shadow-md shadow-green-900/100">Dar de alta</PrimaryButton>

      <PrimaryButton @click="$inertia.put(route('user.reset-pass', $page.props.user.id))" class="m-2">Resetear
        contraseña</PrimaryButton>
      <Dropdown align="right" width="48">
        <template #trigger>
          <PrimaryButton class="m-2 shadow-md">Cálculos</PrimaryButton>
        </template>
        <template #content>
          <DropdownLink href="#">
            Aguinaldo
          </DropdownLink>
          <DropdownLink href="#">
            Finiquito
          </DropdownLink>
          <DropdownLink href="#">
            Prima vacacional
          </DropdownLink>
        </template>
      </Dropdown>
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
      <form @submit.prevent="update">
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

        <div>
          <select class="
              bg-gray-200
              mb-7
              mr-2
              rounded-lg
              border border-gray-300
              text-gray-500
              focus:border-stone-500 focus:text-stone-500
            " v-model="form.employee_properties.shift">
            <option disabled selected class="text-gray-500" value="">
              -- Seleeciona un turno --
            </option>
            <option class="text-gray-500" value="cocina">Cocina</option>
            <option class="text-gray-500" value="carrito matutino">
              Carrito T/M
            </option>
            <option class="text-gray-500" value="carrito vespertino">
              Carrito T/V
            </option>
          </select>
        </div>
        <label class="mb-6 w-full text-sm text-gray-500">Días de trabajo
          <div class="grid grid-cols-3 gap-2 mt-3">
            <label class="flex items-center col-span-1">
              <input v-model="form.employee_properties.work_days" type="checkbox" value="0" name="sunday" class="
                  rounded
                  border-gray-300
                  text-indigo-600
                  shadow-sm
                  focus:border-indigo-300
                  focus:ring
                  focus:ring-indigo-200
                  focus:ring-opacity-50
                " />
              <span class="ml-2 text-sm text-gray-600">Domingo</span>
            </label>
            <label class="flex items-center col-span-1">
              <input v-model="form.employee_properties.work_days" type="checkbox" value="1" name="monday" class="
                  rounded
                  border-gray-300
                  text-indigo-600
                  shadow-sm
                  focus:border-indigo-300
                  focus:ring
                  focus:ring-indigo-200
                  focus:ring-opacity-50
                " />
              <span class="ml-2 text-sm text-gray-600">Lunes</span>
            </label>
            <label class="flex items-center col-span-1">
              <input v-model="form.employee_properties.work_days" type="checkbox" value="2" name="tuesday" class="
                  rounded
                  border-gray-300
                  text-indigo-600
                  shadow-sm
                  focus:border-indigo-300
                  focus:ring
                  focus:ring-indigo-200
                  focus:ring-opacity-50
                " />
              <span class="ml-2 text-sm text-gray-600">Martes</span>
            </label>
            <label class="flex items-center col-span-1">
              <input v-model="form.employee_properties.work_days" type="checkbox" value="3" name="wednesday" class="
                  rounded
                  border-gray-300
                  text-indigo-600
                  shadow-sm
                  focus:border-indigo-300
                  focus:ring
                  focus:ring-indigo-200
                  focus:ring-opacity-50
                " />
              <span class="ml-2 text-sm text-gray-600">Miércoles</span>
            </label>
            <label class="flex items-center col-span-1">
              <input v-model="form.employee_properties.work_days" type="checkbox" value="4" name="thursday" class="
                  rounded
                  border-gray-300
                  text-indigo-600
                  shadow-sm
                  focus:border-indigo-300
                  focus:ring
                  focus:ring-indigo-200
                  focus:ring-opacity-50
                " />
              <span class="ml-2 text-sm text-gray-600">Jueves</span>
            </label>
            <label class="flex items-center col-span-1">
              <input v-model="form.employee_properties.work_days" type="checkbox" value="5" name="fruday" class="
                  rounded
                  border-gray-300
                  text-indigo-600
                  shadow-sm
                  focus:border-indigo-300
                  focus:ring
                  focus:ring-indigo-200
                  focus:ring-opacity-50
                " />
              <span class="ml-2 text-sm text-gray-600">Viernes</span>
            </label>
            <label class="flex items-center col-span-1">
              <input v-model="form.employee_properties.work_days" type="checkbox" value="6" name="saturday" class="
                  rounded
                  border-gray-300
                  text-indigo-600
                  shadow-sm
                  focus:border-indigo-300
                  focus:ring
                  focus:ring-indigo-200
                  focus:ring-opacity-50
                " />
              <span class="ml-2 text-sm text-gray-600">Sábado</span>
            </label>
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
        </label>
        <div class="mt-3">
          <label value="Archivos subidos"></label>
          <div class="flex flex-col" v-for="(file, index) in media" :key="file.id">
            <div>
              <a :href="file.original_url" target="_blank" class="text-sm text-sky-500 hover:underline">{{
                file.name
              }}
              </a>
              <button type="button" @click="
                show_confirmation = true;
              file_to_delete = index;
              " title="Remover archivo">
                <span class="
                      text-gray-500
                      ml-2
                      font-bold
                      text-xs
                      hover:text-red-500
                    "><i class="fa-solid fa-trash-can"></i></span>
              </button>
            </div>
          </div>
        </div>
        <label class="text-gray-600 mt-4 block">
          Subir documentos del empleado
          <FileUploader @input="form.resources = $event.target.files" />
        </label>
        <p class="mb-3 text-gray-600 underline underline-offset-4 font-bold">
          Vacaciones disponibles:
          {{ $page.props.user.employee_properties.vacations }}
        </p>
        <div class="flex justify-center lg:justify-end">
          <PrimaryButton :disabled="form.processing">Actualizar</PrimaryButton>
        </div>
      </form>
    </div>
    <ConfirmationModal :show="show_confirmation" @close="show_confirmation = false">
      <template #title> Elimina recurso </template>
      <template #content>
        Estas a punto de eliminar un recurso subido anteriormente. ¿Deseas
        continuar?
      </template>
      <template #footer>
        <button class="px-2 py-1 font-semibold border rounded border-red-500 text-red-500 hover:bg-red-500 hover:text-white transition duration-200 mr-2" @click="deleteFile">Si, eliminar</button>
        <button class="px-2 py-1 font-semibold border rounded border-gray-500 text-gray-500 hover:bg-gray-100 transition duration-200" @click="show_confirmation = false">
          Cancelar
        </button>
      </template>
    </ConfirmationModal>
  </AppLayout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import PayRollTable from "@/Components/PayRollTable.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputError from "@/Components/InputError.vue";
import FileUploader from "@/Components/FileUploader.vue";
import Checkbox from "@/Components/Checkbox.vue";
import { Link, useForm } from "@inertiajs/inertia-vue3";
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from '@/Components/DropdownLink.vue';
import ConfirmationModal from '@/Components/ConfirmationModal.vue';

export default {
  data() {
    const form = useForm({
      name: this.user.name,
      email: this.user.email,
      phone_number: this.user.phone_number,
      employee_properties: {
        birthdate: this.user.employee_properties.birthdate,
        base_salary: this.user.employee_properties.base_salary,
        work_days: this.user.employee_properties.work_days,
        shift: this.user.employee_properties.shift,
        vacations: 0,
      },
      resources: [],
    });
    return {
      form,
      show_confirmation: false,
      file_to_delete: null,
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
    Dropdown,
    DropdownLink,
    ConfirmationModal
  },
  props: {
    user: Object,
    media: Array,
  },
  methods: {
    update() {
      if (this.form.resources.length)
        this.form.post(route("users.update-with-resources", this.user.id));
      else
        this.form.put(this.route("users.update", this.user.id));
    },
    deleteFile() {
      this.show_confirmation = false;
      axios
        .post(route("users.delete-file"), {
          file_id: this.media[this.file_to_delete].id,
          user_id: this.user.id
        })
        .then(() => {
          this.media.splice(this.file_to_delete, 1);
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },
};
</script>