<template>
  <AppLayout title="Nuevo producto">
    <template #header>
      <div class="flex items-center mt-2">
        <Back />
        <h2 class="font-semibold text-xl text-gray-800 text-center ml-5 lg:ml-28">
          Nuevo producto
        </h2>
      </div>
    </template>

    <div
      class="max-w-xl md:mx-auto mt-5 rounded-lg px-5 py-8 bg-transparent border border-gray3 mx-4"
    >
      <form @submit.prevent="store">

        <div class="mb-3 w-full">
          <InputLabel value="Nombre del producto *" class="ml-3 mb-1 text-sm" />
          <input v-model="form.name" type="text" autocomplete="off" class="input"
           placeholder="Escribe el nombre del producto" />
          <InputError :message="$page.props?.errors.name" />
        </div>

        <div class="mb-3 w-full">
          <InputLabel value="Stock mínimo *" class="ml-3 mb-1 text-sm" />
          <input v-model="form.low_stock" type="number" autocomplete="off" class="input"
           placeholder="00" />
          <InputError :message="$page.props?.errors.low_stock" />
        </div>

        <div class="mb-3 w-full">
          <InputLabel value="Stock de apertura *" class="ml-3 mb-1 text-sm" />
          <input v-model="form.initial_stock" type="number" autocomplete="off" class="input"
           placeholder="00" />
          <InputError :message="$page.props?.errors.initial_stock" />
        </div>

        <div class="mb-3 w-full">
          <InputLabel value="Precio *" class="ml-3 mb-1 text-sm" />
          <input v-model="form.price" type="number" autocomplete="off" class="input"
           placeholder="$00.0" />
          <InputError :message="$page.props?.errors.price" />
        </div>

        <div class="mb-3 w-full">
          <InputLabel value="Precio a empleados *" class="ml-3 mb-1 text-sm" />
          <input v-model="form.employee_price" type="number" autocomplete="off" class="input"
           placeholder="$00.0" />
          <InputError :message="$page.props?.errors.employee_price" />
        </div>

        <InputLabel value="Unidad de medida *" class="ml-3 mb-1 text-sm" />
        <select class="select mb-5" v-model="form.unit_id">
          <option disabled selected class="text-gray-500">
            -- Seleccione --
          </option>
          <option
            class="text-gray-500"
            v-for="unit in units"
            :key="unit.id"
            :value="unit.id"
          >
            {{ unit.name }}
          </option>
        </select>
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
        <div class="flex justify-end mt-4">
          <PrimaryButton :disabled="form.processing">Agregar</PrimaryButton>
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
import InputLabel from "@/Components/InputLabel.vue";
import Back from "@/Components/Back.vue";
import { Link, useForm } from "@inertiajs/inertia-vue3";
export default {
  data() {
    const form = useForm({
      name: null,
      low_stock: null,
      unit_id: null,
      price: null,
      employee_price: null,
      initial_stock: null,
      media: null,
    });
    return {
      form,
    };
  },
  components: {
    AppLayout,
    PayRollTable,
    PrimaryButton,
    InputError,
    InputLabel,
    Back,
    Link,
  },
  props: {
    units: Array,
  },
  methods: {
    store() {
      this.form.post(route("products.store"));
    },
  },
};
</script>