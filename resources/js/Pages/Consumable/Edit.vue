<template>
  <AppLayout title="Editar consumible">
    <template #header>
      <!-- 
        MODIFICACIÓN: 
        - Mismo layout de header que en 'Create'.
        - Se usa un color azul (text-blue-600) para el nombre,
          en lugar de 'text-primary' para asegurar consistencia.
      -->
      <div class="relative flex items-center justify-center py-2">
        <div class="absolute left-0">
          <Back />
        </div>
        <h2 class="font-semibold text-xl text-gray-900 leading-tight">
          Editar consumible <strong class="ml-2 text-blue-600">{{ consumable.name }}</strong>
        </h2>
      </div>
    </template>

    <!-- 
      MODIFICACIÓN: 
      - Mismo estilo de 'card' moderno que en 'Create'.
      - Se unifica a max-w-xl por consistencia (antes era 2xl).
    -->
    <div class="max-w-xl mx-auto mt-8 p-6 lg:p-8 bg-white rounded-xl shadow-lg mb-8">
      <form @submit.prevent="update">

        <!-- 
          MODIFICACIÓN: 
          - Espaciado estandarizado (mb-6).
        -->
        <div class="mb-6 w-full">
          <!-- 
            MODIFICACIÓN: 
            - Estilo de label mejorado.
          -->
          <InputLabel value="Nombre del consumible *" class="block mb-2 text-sm font-medium text-gray-700" />
          <!-- 
            MODIFICACIÓN: 
            - Estilos de input modernos.
          -->
          <input v-model="form.name" type="text" autocomplete="off"
            class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-600 focus:border-blue-600 sm:text-sm"
            placeholder="Escribe el nombre del consumible" />
          <InputError :message="$page.props?.errors.name" />
        </div>

        <!-- Campos comentados eliminados para mayor claridad -->

        <div class="mb-6 w-full">
          <InputLabel value="Unidad de medida *" class="block mb-2 text-sm font-medium text-gray-700" />
          <!-- 
            MODIFICACIÓN: 
            - Estilos de select modernos.
          -->
          <select class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-600 focus:border-blue-600 sm:text-sm" v-model="form.unit_id">
            <option disabled value.="null" class="text-gray-500">
              -- Seleccione --
            </option>
            <option class="text-gray-600" v-for="unit in units" :key="unit.id" :value="unit.id">
              {{ unit.name }}
            </option>
          </select>
          <InputError :message="$page.props?.errors.unit_id" />
        </div>

        <!-- Campos comentados eliminados para mayor claridad -->

        <div class="mt-6">
          <InputLabel value="Agregar foto del consumible" class="block mb-2 text-sm font-medium text-gray-700" />
          <InputFilePreview :imageUrl="consumable.media[0]?.original_url" @imagen="saveImage" />
        </div>

        <!-- 
          MODIFICACIÓN: 
          - Botón alineado a la derecha (justify-end).
        -->
        <div class="flex justify-end mt-10">
          <PrimaryButton :disabled="form.processing">Guardar cambios</PrimaryButton>
        </div>
      </form>
    </div>
  </AppLayout>
</template>

<!-- El script se mantiene idéntico -->
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
