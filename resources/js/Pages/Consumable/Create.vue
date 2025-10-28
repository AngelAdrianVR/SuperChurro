<template>
  <AppLayout title="Nuevo Consumible">
    <template #header>
      <!-- 
        MODIFICACIÓN: 
        - Se usa un layout relativo/absoluto para centrar el título 
          independientemente del botón "Back".
        - Se añade padding vertical (py-2) y se oscurece el texto (text-gray-900).
      -->
      <div class="relative flex items-center justify-center py-2">
        <div class="absolute left-0">
          <Back />
        </div>
        <h2 class="font-semibold text-xl text-gray-900 leading-tight">
          Nuevo Consumible
        </h2>
      </div>
    </template>

    <!-- 
      MODIFICACIÓN: 
      - Contenedor principal del formulario.
      - Se cambia de 'border' a un 'card' con fondo blanco, sombra y bordes redondeados.
      - Se aumenta el padding (p-6 lg:p-8) y el margen superior (mt-8).
    -->
    <div class="max-w-xl mx-auto mt-8 p-6 lg:p-8 bg-white rounded-xl shadow-lg mb-8">
      <form @submit.prevent="store">

        <!-- 
          MODIFICACIÓN: 
          - Espaciado estandarizado (mb-6) para cada grupo de formulario.
        -->
        <div class="mb-6 w-full">
          <!-- 
            MODIFICACIÓN: 
            - Estilo de label mejorado: más legible, sin margen izquierdo.
          -->
          <InputLabel value="Nombre del consumible *" class="block mb-2 text-sm font-medium text-gray-700" />
          <!-- 
            MODIFICACIÓN: 
            - Clases de Tailwind modernas para el input.
            - Se reemplaza la clase genérica 'input' por clases específicas
              para bordes, sombras en foco y esquinas redondeadas.
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
            - Mismos estilos modernos aplicados al 'select'.
          -->
          <select class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-600 focus:border-blue-600 sm:text-sm" v-model="form.unit_id">
            <option disabled selected value.="null" class="text-gray-500">
              -- Seleccione --
            </option>
            <option
              class="text-gray-600"
              v-for="unit in units"
              :key="unit.id"
              :value="unit.id"
            >
              {{ unit.name }}
            </option>
          </select>
           <InputError :message="$page.props?.errors.unit_id" />
        </div>

        <!-- Campos comentados eliminados para mayor claridad -->

        <div class="mt-6">
            <InputLabel value="Agregar foto del consumible" class="block mb-2 text-sm font-medium text-gray-700" />
            <InputFilePreview @imagen="saveImage" />
        </div>

        <!-- 
          MODIFICACIÓN: 
          - Se alinea el botón a la derecha (justify-end), 
            que es una convención más moderna para formularios.
        -->
        <div class="flex justify-end mt-10">
          <PrimaryButton :disabled="form.processing">Agregar</PrimaryButton>
        </div>
      </form>
    </div>
  </AppLayout>
</template>

<!-- El script se mantiene idéntico -->
<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import InputFilePreview from '@/Components/MyComponents/InputFilePreview.vue';
import Back from "@/Components/Back.vue";
import { Link, useForm } from "@inertiajs/inertia-vue3";
export default {
  data() {
    const form = useForm({
      name: null,
      low_stock: 100,
      unit_id: null,
      code: null,
      media: null,
    });
    return {
      form,
    };
  },
  components: {
    AppLayout,
    PrimaryButton,
    InputError,
    InputLabel,
    InputFilePreview,
    Back,
    Link,
  },
  props: {
    units: Array,
  },
  methods: {
    store() {
      this.form.post(route("consumables.store"), {
        onSuccess: () => {
          this.$notify({
            title: "Creado",
            message: "",
            type: "success",
          });
        }
      });
    },
    saveImage(image) {
    this.form.media = image;
  }
  },
};
</script>
