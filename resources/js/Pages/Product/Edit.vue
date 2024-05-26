<template>
  <AppLayout title="Editar Producto">
    <template #header>
      <div class="flex items-center mt-2">
        <Back />
        <h2 class="font-semibold text-xl text-gray-800 text-center ml-5 lg:ml-28">
          Editar producto <strong class="ml-2 text-primary">{{ product.name }}</strong>
        </h2>
      </div>
    </template>

    <div
      class="
        max-w-2xl
        md:mx-auto
        mt-5
        rounded-lg
        px-5
        py-8
        bg-transparent
        border border-gray3
        mx-4
      "
    >
      <form @submit.prevent="update">

        <div class="mb-2 w-full">
          <InputLabel value="Nombre del producto *" class="ml-3 mb-1 text-sm" />
          <input v-model="form.name" type="text" autocomplete="off" class="input"
           placeholder="Escribe el nombre del producto" />
          <InputError :message="$page.props?.errors.name" />
        </div>

        <div class="mb-2 w-full">
          <InputLabel value="Stock mínimo *" class="ml-3 mb-1 text-sm" />
          <input v-model="form.low_stock" type="number" autocomplete="off" class="input"
           placeholder="Agrega el stock mínimo" />
          <InputError :message="$page.props?.errors.low_stock" />
        </div>

        <div class="mb-2 w-full">
          <InputLabel value="Stock de apertura *" class="ml-3 mb-1 text-sm" />
          <input v-model="form.initial_stock" type="number" autocomplete="off" class="input"
           placeholder="Agrega el stock inicial" />
          <InputError :message="$page.props?.errors.initial_stock" />
        </div>

        <div class="mb-2 w-full relative">
          <InputLabel value="Precio *" class="ml-3 mb-1 text-sm" />
          <input v-model="form.price" type="number" autocomplete="off" class="input pl-7"
           placeholder="Agrega el precio" />
           <p class="text-sm text-gray-500 absolute top-[26px] left-2 border-r border-gray2 pr-[4px] py-[5px]">$</p>
          <InputError :message="$page.props?.errors.price" />
        </div>

        <div class="mb-2 w-full relative">
          <InputLabel value="Precio a empleados *" class="ml-3 mb-1 text-sm" />
          <input v-model="form.employee_price" type="number" autocomplete="off" class="input pl-7"
           placeholder="Agrega el precio" />
           <p class="text-sm text-gray-500 absolute top-[26px] left-2 border-r border-gray2 pr-[4px] py-[5px]">$</p>
          <InputError :message="$page.props?.errors.employee_price" />
        </div>

        <InputLabel value="Unidad de medida *" class="ml-3 mb-1 text-sm" />
        <select class="select mb3" v-model="form.unit_id">
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

        <div class="mt-3 w-ull relative">
            <InputLabel value="Código del producto (en caso de tener)" class="ml-3 mb-1" />
            <input v-model="form.code" type="text" autocomplete="off" class="input pl-8"
              placeholder="Escribe el código de producto" />
            <p class="text-sm text-gray-500 absolute top-[26px] left-2 border-r border-gray2 pr-[4px] py-[5px]"><i class="fa-solid fa-barcode"></i></p>
            <InputError :message="form.errors.code" />
        </div>

        <div class="mt-5">
            <InputLabel value="Agregar foto del producto" class="ml-3 mb-1" />
            <InputFilePreview :imageUrl="product.media[0]?.original_url" @imagen="saveImage" />
        </div>

        <div class="flex justify-start mt-10">
          <PrimaryButton :disabled="form.processing">Guardar cambios</PrimaryButton>
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
import Back from "@/Components/Back.vue";
import InputLabel from "@/Components/InputLabel.vue";
import InputFilePreview from '@/Components/MyComponents/InputFilePreview.vue';
import { Link, useForm } from "@inertiajs/inertia-vue3";

export default {
  data() {
    const form = useForm({
      name: this.product.name,
      low_stock: this.product.low_stock,
      unit_id: this.product.unit?.id,
      price: this.product.current_price?.price,
      employee_price: this.product.current_employee_price?.price,
      code: this.product.code,
      media: this.product.media,
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
    InputFilePreview,
    Back,
    Link,
  },
  props: {
    product: Object,
    units: Array,
  },
  methods: {
    update() {
      if (this.form.media == null) {
        this.form.put(route("products.update", this.product.id));
      } else {
        this.form.post(route("products.update-with-media", this.product.id), {
          method: '_put'
        });
      }
    },
    saveImage(image) {
    this.form.media = image;
  }
  },
};
</script>