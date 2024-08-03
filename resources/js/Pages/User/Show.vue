<template>
  <AppLayout title="Usuario">
    <template #header>
      <div @click="showUserOptions = false" class="flex items-center justify-between mt-2">
        <Back />
        <div class="flex items-center space-x-2 relative">
          <PrimaryButton v-if="!canEdit" @click="canEdit = true" class="!rounded-md">Editar</PrimaryButton>
          <CancelButton v-if="canEdit" @click="canEdit = false" class="!rounded-md">Cancelar</CancelButton>
          <PrimaryButton v-if="canEdit" :disabled="canEdit" @click="canEdit = true" class="!rounded-md">En edición</PrimaryButton>
          <button @click.stop="showUserOptions = !showUserOptions" class="border border-gray3 rounded-md text-sm py-1 px-2">Más <i class="fa-solid fa-angle-down ml-1"></i></button>
        </div>
        <div v-if="showUserOptions" class="z-10 text-sm border border-gray3 bg-gray-100 rounded-lg py-3 absolute top-[138px] right-[16px] lg:right-[225px]">
          <p @click="$inertia.put(route('user.reset-pass', user.id))" class="px-3 py-1 cursor-pointer hover:bg-gray4">Resetear contraseña</p>
          <p @click.stop="showCalcsOptions = !showCalcsOptions" class="px-3 py-1 cursor-pointer hover:bg-gray4">Cálculos</p>
          <p v-if="showCalcsOptions" @click="$inertia.get(route('chrismas-bonus.show', user.id))" class="pr-3 pl-5 py-1 cursor-pointer hover:bg-gray4 text-xs">Aguinaldo</p>
          <p v-if="showCalcsOptions" @click="$inertia.get(route('settlement.show', user.id))" class="pr-3 pl-5 py-1 cursor-pointer hover:bg-gray4 text-xs">Finiquito</p>
          <p v-if="showCalcsOptions" @click="$inertia.get(route('vacation-bonus.show', user.id))" class="pr-3 pl-5 py-1 cursor-pointer hover:bg-gray4 text-xs">Prima vacacional</p>
          <p v-if="user.is_active" @click.stop="$inertia.put(route('user.disable', user.id))" class="px-3 py-1 cursor-pointer hover:bg-gray4">Dar de baja</p>
          <p v-else @click="$inertia.put(route('user.enable', user.id))" class="px-3 py-1 cursor-pointer hover:bg-gray4">Dar de alta</p>
        </div>
      </div>
    </template> 

    <div
      @click="showUserOptions = false"
      class="max-w-4xl md:mx-auto mt-5 rounded-lg px-5 py-8 bg-transparent mx-4 my-2"
    >
      <form @submit.prevent="update">
        <div class="relative z-0 mb-6 w-full group">
          <h1 class="font-bold mb-9 ml-3 col-span-full">Datos personales</h1>
          <div class="mb-3 w-full group">
            <InputLabel value="Nombre *" class="ml-3 mb-1 text-sm" />
            <input :disabled="!canEdit" v-model="form.name" type="text" autocomplete="off" class="input"
            placeholder="Escribe el nombre del colaborador" />
            <InputError :message="$page.props?.errors.name" />
          </div>

          <div class="mb-3 w-full group">
            <InputLabel value="Correo electrónico *" class="ml-3 mb-1 text-sm" />
            <input :disabled="!canEdit" v-model="form.email" type="text" autocomplete="off" class="input"
            placeholder="Escribe el correo del colaborador" />
            <InputError :message="$page.props?.errors.email" />
          </div>

          <div class="mb-3 w-full group">
            <InputLabel value="Número de teléfono *" class="ml-3 mb-1 text-sm" />
            <input :disabled="!canEdit" v-model="form.phone_number" type="text" autocomplete="off" class="input"
            placeholder="Escribe el correo del colaborador" />
            <InputError :message="$page.props?.errors.phone_number" />
          </div>

          <div class="mb-3 w-full group">
            <InputLabel value="Fecha de nacimieno *" class="ml-3 mb-1 text-sm" />
            <input :disabled="!canEdit" v-model="form.employee_properties.birthdate" type="date" autocomplete="off" class="input"
            placeholder="Seleccione la fecha" />
            <InputError :message="$page.props?.errors['employee_properties.birthdate']" />
          </div>

          <h1 class="font-bold my-9 ml-3 col-span-full">Datos laborales</h1>

          <div class="mb-3 w-full group">
            <InputLabel value="Fecha de Ingreso *" class="ml-3 mb-1 text-sm" />
            <input :disabled="!canEdit" v-model="form.created_at" type="date" autocomplete="off" class="input"
            placeholder="Seleccione la fecha" />
          </div>

          <div class="mb-3 w-full group">
            <InputLabel value="Salario base *" class="ml-3 mb-1 text-sm" />
            <input :disabled="!canEdit" v-model="form.employee_properties.base_salary" type="number" min="0" autocomplete="off" class="input"
            placeholder="Escriba el salario" />
            <InputError :message="$page.props?.errors['employee_properties.base_salary']" />
          </div>

        </div>

        <div class="mb-3">
          <label class="w-full text-sm text-gray-500 block">Bonos</label>
          <div class="grid grid-cols-2 lg:grid-cols-3 gap-1">
            <label v-for="bonus in bonuses" :key="bonus.id">
              <input :disabled="!canEdit" v-model="form.employee_properties.bonuses" type="checkbox" :value="bonus.id"
               class="rounded border-gray-300 text-primary shadow-sm focus:border-[#883339] focus:ring focus:ring-[#883339] focus:ring-opacity-50 disabled:cursor-not-allowed disabled:bg-gray4" />
              <span :class="!canEdit ? 'text-gray-400' : 'text-gray-600'" class="ml-1 text-xs">{{ bonus.name }}</span>
            </label>
          </div>
        </div>

        <label class="mb-3 w-full text-sm text-gray-500">Días de trabajo</label>
        <div class="">
          <select
            :disabled="!canEdit"
            class="bg-gray-200 mb-3 mr-2 rounded-lg border border-gray-300 text-gray-500 focus:border-stone-500 focus:text-stone-500"
            v-model="selected_day"
          >
            <option disabled selected class="text-gray-500" value="">
              -- Selecciona un turno --
            </option>
            <option
              v-for="(week_day, index) in week_days"
              :key="index"
              class="text-gray-500"
              :value="index"
            >
              {{ week_day }}
            </option>
          </select>
          <div class="flex flex-col mb-4">
            <div
              v-for="(shift, index) in shifts"
              :key="index"
              class="flex items-center mr-3"
            >
              <input
                :disabled="!canEdit"
                v-model="selected_shift"
                :id="'shift-option-' + index"
                type="radio"
                name="shift"
                :value="shift"
                class="h-4 w-4 border-gray-300 focus:ring-2 focus:ring-[#ABD196] text-[#8cbe71] disabled:bg-gray4 disabled:text-gray-400 disabled:cursor-not-allowed"
                :aria-labelledby="'shift-option-' + index"
                :aria-describedby="'shift-option-' + index"
                checked=""
              />
              <label
                :for="'shift-option-' + index"
                class="text-sm font-medium ml-2 block"
                :class="!canEdit ? 'text-gray-400' : 'text-gray-700'"
              >
                {{ shift }}
              </label>
            </div>
          </div>
          <div class="mb-4">
            <ThirthButton :disabled="!canEdit" @click="addWorkDay" class="mr-2"
              >Agregar día</ThirthButton
            >
            <ThirthButton :disabled="!canEdit" @click="cleanWorkDays">Borrar días</ThirthButton>
          </div>
          <div>
            <span
              v-for="(item, index) in form.employee_properties.work_days"
              :key="item.day"
              class="bg-sky-100 px-2 py-1 rounded-full mr-3 text-xs"
            >
              {{ week_days[item.day] }} - {{ item.shift }} <button v-if="canEdit" type="button" @click="deleteWorkDay(index)">x</button>
            </span>
          </div>
        </div>
        <label
          for="floating_work_days"
          class="absolute text-sm text-gray-500 dark:text-gray-700 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-stone-600 peer-focus:dark:text-stone-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
          >Días de trabajo*</label
        >
        <InputError :message="$page.props?.errors.employee_properties?.work_days" />
        <div class="mt-3">
          <label value="Archivos subidos"></label>
          <div class="flex flex-col" v-for="(file, index) in media" :key="file.id">
            <div>
              <a
                :href="file.original_url"
                target="_blank"
                class="text-sm text-sky-500 hover:underline"
                >{{ file.name }}
              </a>
              <button
                type="button"
                @click="
                  show_confirmation = true;
                  file_to_delete = index;
                "
                title="Remover archivo"
              >
                <span class="text-gray-500 ml-2 font-bold text-xs hover:text-red-500"
                  ><i class="fa-solid fa-trash-can"></i
                ></span>
              </button>
            </div>
          </div>
        </div>
        <div class="col-span-full mt-2">
          <div class="flex items-center">
            <span
              class="font-bold text-[16px] inline-flex items-center text-gray-600 border border-r-8 border-transparent rounded-l-md h-9 darkk:bg-gray-600 darkk:text-gray-400 darkk:border-gray-600"
            >
              <el-tooltip content="Imagen del producto" placement="top">
                <i class="fa-solid fa-images"></i>
              </el-tooltip>
            </span>
            <input
              :disabled="!canEdit"
              @input="form.media = $event.target.files[0]"
              class="input h-12 rounded-lg file:mr-4 file:py-1 file:px-2 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary file:text-white file:cursor-pointer hover:file:bg-red-600"
              aria-describedby="file_input_help"
              id="file_input"
              type="file"
            />
          </div>
          <p class="mt-1 text-xs text-right text-gray-500" id="file_input_help">
            SVG, PNG, JPG o GIF (MAX. 4 MB).
          </p>
        </div>
        <div class="flex justify-center lg:justify-end mt-4">
          <CancelButton v-if="canEdit" @click="canEdit = false" class="!rounded-md mr-3">Cancelar</CancelButton>
          <PrimaryButton v-if="canEdit" :disabled="form.processing">Actualizar</PrimaryButton>
        </div>
        <div class="border-b border-gray3 my-8"></div>
        <p class="mb-3 text-gray-600 flex">
          Vacaciones disponibles:
          {{ $page.props.user.employee_properties.vacations?.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",") }}
        <ThirthButton type="button" @click.stop="show_confirmation = true; confirmation_for_pay_vacations = true;" class="ml-10" :disabled="form.processing">Pagar Vacaciones</ThirthButton>
        <p v-if="vacations_error_message" class="text-red-500 text-sm my-2 "> {{ vacations_error_message }} </p>
        </p>
      </form>
    </div>

    <ConfirmationModal :show="show_confirmation" @close="show_confirmation = false">
      <template #title> 
        <p v-if="confirmation_for_pay_vacations"> Pagar vacaciones en nomina actual </p>
        <p v-else> Elimina recurso </p>
      </template>
      <template #content>
        <p v-if="confirmation_for_pay_vacations"> Se van a descontar los dias de vacaciones acumulados y se va a reflejar el pago en la nomina actual. ¿Deseas continuar?</p>
        <p v-else> Estas a punto de eliminar un recurso subido anteriormente. ¿Deseas continuar? </p>
      </template>
      <template #footer>
        <div v-if="confirmation_for_pay_vacations">
          <button
            class="px-2 py-1 font-semibold border rounded border-red-500 text-red-500 hover:bg-red-500 hover:text-white transition duration-200 mr-2"
            @click="payVacations"
          >
            Si, continuar
          </button>
          <button
            class="px-2 py-1 font-semibold border rounded border-gray-500 text-gray-500 hover:bg-gray-100 transition duration-200"
            @click="show_confirmation = false; confirmation_for_pay_vacations = false"
          >
            Cancelar
          </button>
        </div>
        <div v-else>
          <button
            class="px-2 py-1 font-semibold border rounded border-red-500 text-red-500 hover:bg-red-500 hover:text-white transition duration-200 mr-2"
            @click="deleteFile"
          >
            Si, eliminar
          </button>
          <button
            class="px-2 py-1 font-semibold border rounded border-gray-500 text-gray-500 hover:bg-gray-100 transition duration-200"
            @click="show_confirmation = false"
          >
            Cancelar
          </button>
        </div>
      </template>
    </ConfirmationModal>
  </AppLayout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import PayRollTable from "@/Components/PayRollTable.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import CancelButton from "@/Components/CancelButton.vue";
import ThirthButton from "@/Components/ThirthButton.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import FileUploader from "@/Components/FileUploader.vue";
import Checkbox from "@/Components/Checkbox.vue";
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";
import ConfirmationModal from "@/Components/ConfirmationModal.vue";
import Back from "@/Components/Back.vue";
import { Inertia } from "@inertiajs/inertia";
import { Link, useForm } from "@inertiajs/inertia-vue3";

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
        vacations: this.user.employee_properties.vacations,
        vacations_updated_date: this.user.employee_properties.vacations_updated_date,
        bonuses: this.user.employee_properties.bonuses ?? [],
      },
      created_at: this.user.created_at.split('T')[0],
      resources: [],
    });
    return {
      form,
      showCalcsOptions: false,
      canEdit: false,
      show_confirmation: false,
      showUserOptions: false,
      file_to_delete: null,
      confirmation_for_pay_vacations: false,
      week_days: [
        "Domingo",
        "Lunes",
        "Martes",
        "Miércoles",
        "Jueves",
        "Viernes",
        "Sábado",
      ],
      shifts: ["cocina", "carrito matutino", "carrito vespertino", "carrito 2 turnos", "Don Victor"],
      selected_day: 0,
      selected_shift: "carrito 2 turnos",
      vacations_error_message: null,
    };
  },
  components: {
    AppLayout,
    PayRollTable,
    PrimaryButton,
    ThirthButton,
    CancelButton,
    InputError,
    Checkbox,
    FileUploader,
    Dropdown,
    DropdownLink,
    ConfirmationModal,
    InputLabel,
    Back,
    Link,
  },
  props: {
    user: Object,
    media: Array,
    bonuses: Array,
  },
  methods: {
    update() {
      if (this.form.resources.length)
        this.form.post(route("users.update-with-resources", this.user.id));
      else this.form.put(this.route("users.update", this.user.id));
    },
    deleteFile() {
      this.show_confirmation = false;
      axios
        .post(route("users.delete-file"), {
          file_id: this.media[this.file_to_delete].id,
          user_id: this.user.id,
        })
        .then(() => {
          this.media.splice(this.file_to_delete, 1);
        })
        .catch((error) => {
          console.log(error);
        });
    },
    addWorkDay() {
      this.form.employee_properties.work_days.push({
        day: this.selected_day,
        shift: this.selected_shift,
      });
    },
    cleanWorkDays() {
      this.form.employee_properties.work_days = [];
    },
    deleteWorkDay(index) {
      this.form.employee_properties.work_days.splice(index, 1);
    },
    async payVacations() {
      try {
        const response = await axios.post(route('users.pay-vacations'), {
          vacation_days: this.form.employee_properties.vacations,
          user_id: this.user.id
        });

        if (response.status == 200) {
          Inertia.get(route('users.index'));
        }
      } catch (error) {
        this.vacations_error_message = error.response.data.message;
        console.log("err: ",error)
      } finally {
        this.show_confirmation = false;
      }
    }
  },
};
</script>
