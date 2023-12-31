<template>
  <AppLayout title="Editar Producto">
    <template #header>
      <div class="flex items-center mt-2">
        <Back />
        <h2 class="font-semibold text-xl text-gray-800 text-center ml-5 lg:ml-28">
          Editar producto: <strong>{{ product.name }}</strong>
        </h2>
      </div>
    </template>

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
      <form @submit.prevent="update">
        <div class="relative z-0 mb-6 w-full group">
          <input
            v-model="form.name"
            type="text"
            name="floating_name_product"
            autocomplete="off"
            required
            class="
              block
              py-2.5
              px-0
              w-full
              text-sm text-gray-900
              bg-transparent
              border-0 border-b-2 border-gray-400
              appearance-none
              dark:text-gray-700 dark:border-gray-600 dark:focus:border-stone-500
              focus:outline-none focus:ring-0 focus:border-stone-600
              peer
            "
            placeholder=" "
          />
          <label
            for="floating_name_product"
            class="
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
            "
            >Nombre del producto*</label
          >
          <InputError :message="$page.props?.errors.name" />
        </div>
        <div class="relative z-0 mb-6 w-full group">
          <input
            v-model="form.low_stock"
            type="number"
            name="floating_low_stock"
            autocomplete="off"
            class="
              block
              py-2.5
              px-0
              w-full
              text-sm text-gray-900
              bg-transparent
              border-0 border-b-2 border-gray-400
              appearance-none
              dark:text-gray-700 dark:border-gray-600 dark:focus:border-stone-500
              focus:outline-none focus:ring-0 focus:border-stone-600
              peer
            "
            placeholder=" "
          />
          <label
            for="floating_low_stock"
            class="
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
            "
            >Stock mínimo</label
          >
        </div>
        <div class="relative z-0 mb-6 w-full group">
          <input
            v-model="form.price"
            type="number"
            step="0.1"
            name="floating_price"
            autocomplete="off"
            class="
              block
              py-2.5
              px-0
              w-full
              text-sm text-gray-900
              bg-transparent
              border-0 border-b-2 border-gray-400
              appearance-none
              dark:text-gray-700 dark:border-gray-600 dark:focus:border-stone-500
              focus:outline-none focus:ring-0 focus:border-stone-600
              peer
            "
            placeholder=" "
          />
          <label
            for="floating_low_stock"
            class="
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
            "
            >Precio</label
          >
        </div>
        <div class="relative z-0 mb-6 w-full group">
          <input
            v-model="form.employee_price"
            type="number"
            step="0.1"
            name="floating_price"
            autocomplete="off"
            class="
              block
              py-2.5
              px-0
              w-full
              text-sm text-gray-900
              bg-transparent
              border-0 border-b-2 border-gray-400
              appearance-none
              dark:text-gray-700 dark:border-gray-600 dark:focus:border-stone-500
              focus:outline-none focus:ring-0 focus:border-stone-600
              peer
            "
            placeholder=" "
          />
          <label
            for="floating_low_stock"
            class="
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
            "
            >Precio a empleados</label
          >
        </div>
        <select
          class="select mb-5"
          required
          v-model="form.unit_id"
        >
          <option disabled selected class="text-gray-500" value="">
            -- Unidad de medida --
          </option>
          <option
            class="text-gray-500"
            v-for="unit in units"
            :key="unit?.id"
            :value="unit?.id"
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
        <div class="flex justify-center lg:justify-end mt-4">
          <PrimaryButton :disabled="form.processing">Actualizar</PrimaryButton>
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
import { Link, useForm } from "@inertiajs/inertia-vue3";
export default {
  data() {
    const form = useForm({
      name: this.product.name,
      low_stock: this.product.low_stock,
      unit_id: this.product.unit?.id,
      price: this.product.current_price?.price,
      employee_price: this.product.current_employee_price?.price,
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
  },
};
</script>