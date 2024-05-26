<template>
  <AppLayout title="Editar consumible">
    <template #header>
      <div class="flex items-center mt-2">
        <Back />
        <h2 class="font-semibold text-xl text-gray-800 text-center ml-5 lg:ml-28">
          Editar consumible <strong class="ml-2 text-primary">{{ consumable.name }}</strong>
        </h2>
      </div>
    </template>

    <div class="max-w-2xl md:mx-auto mt-5 rounded-lg px-5 py-8 bg-transparent border border-gray3 mx-4">
      <form @submit.prevent="update">

        <div class="mb-2 w-full">
          <InputLabel value="Nombre del consumible *" class="ml-3 mb-1 text-sm" />
          <input v-model="form.name" type="text" autocomplete="off" class="input"
            placeholder="Escribe el nombre del consumible" />
          <InputError :message="$page.props?.errors.name" />
        </div>

        <!-- <div class="mb-2 w-full">
          <InputLabel value="Stock mínimo *" class="ml-3 mb-1 text-sm" />
          <input v-model="form.low_stock" type="number" autocomplete="off" class="input"
            placeholder="Agrega el stock mínimo" />
          <InputError :message="$page.props?.errors.low_stock" />
        </div> -->

        <InputLabel value="Unidad de medida *" class="ml-3 mb-1 text-sm" />
        <select class="select mb3" v-model="form.unit_id">
          <option disabled selected class="text-gray-500">
            -- Seleccione --
          </option>
          <option class="text-gray-500" v-for="unit in units" :key="unit.id" :value="unit.id">
            {{ unit.name }}
          </option>
        </select>

        <!-- <div class="mt-3 w-ull relative">
          <InputLabel value="Código del consumible (en caso de tener)" class="ml-3 mb-1" />
          <input v-model="form.code" type="text" autocomplete="off" class="input pl-8"
            placeholder="Escribe el código de consumible" />
          <p class="text-sm text-gray-500 absolute top-[26px] left-2 border-r border-gray2 pr-[4px] py-[5px]"><i
              class="fa-solid fa-barcode"></i></p>
          <InputError :message="form.errors.code" />
        </div> -->

        <div class="mt-5">
          <InputLabel value="Agregar foto del consumible" class="ml-3 mb-1" />
          <InputFilePreview :imageUrl="consumable.media[0]?.original_url" @imagen="saveImage" />
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
      name: this.consumable.name,
      low_stock: this.consumable.low_stock,
      unit_id: this.consumable.unit?.id,
      code: this.consumable.code,
      media: this.consumable.media,
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
    consumable: Object,
    units: Array,
  },
  methods: {
    update() {
      if (this.form.media == null) {
        this.form.put(route("consumables.update", this.consumable.id), {
          onSuccess: () => {
            this.$notify({
              title: "Actualizado",
              message: "",
              type: "success",
            });
          }
        });
      } else {
        this.form.post(route("consumables.update-with-media", this.consumable.id), {
          method: '_put',
          onSuccess: () => {
            this.$notify({
              title: "Actualizado",
              message: "",
              type: "success",
            });
          }
        });
      }
    },
    saveImage(image) {
      this.form.media = image;
    }
  },
};
</script>