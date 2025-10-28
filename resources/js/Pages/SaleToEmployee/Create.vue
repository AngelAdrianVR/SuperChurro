<template>
  <AppLayout title="Venta a empleado / cortesias">
    <template #header>
      <!-- MODIFICADO: Se añade 'gap-4' para un espaciado limpio entre el botón de volver y el título -->
      <div class="flex items-center mt-2 gap-4">
        <Back />
        <!-- MODIFICADO: Se elimina el 'ml-5 lg:ml-28' para un centrado más natural con flexbox -->
        <h2 class="font-semibold text-xl text-gray-800 dar:text-gray-200">
          Venta a empleado / cortesias
        </h2>
      </div>
    </template>

    <!-- 
      MODIFICADO: 
      - Se cambia 'mx-2 md:mx-48' por 'max-w-4xl mx-auto' para un contenedor centrado y con ancho máximo.
      - Se eliminan 'border border-gray3 bg-transparent'
      - Se añaden estilos de "tarjeta" modernos: 'bg-white dar:bg-gray-800 shadow-xl rounded-2xl'
      - Se aumenta el padding: 'p-6 sm:p-8'
    -->
    <div class="max-w-4xl mx-auto mt-5 p-6 sm:p-8 bg-white dar:bg-gray-800 shadow-xl rounded-2xl">
      <form @submit.prevent="submit">
        <div>
          <!-- MODIFICADO: Se añade más espaciado vertical 'my-4' -->
          <el-radio-group v-model="form.is_sell_to_employee" @change="handleChangeType"
            class="!flex justify-center my-4">
            <el-radio label="1">Venta a empleado</el-radio>
            <el-radio label="0">Cortesías</el-radio>
          </el-radio-group>
        </div>

        <!-- MODIFICADO: Se envuelve la lista de productos en un div con espaciado -->
        <div class="space-y-3">
          <ProductInput :products="products" show_price v-for="(item, index) in form.items" :key="item.id" :id="item.id"
            @deleteItem="deleteItem(index)" @syncItem="syncItems(index, $event)" />
        </div>
        
        <!-- MODIFICADO: Se centra el texto y se le da un estilo más suave y con más padding -->
        <p v-if="!form.items.length" class="text-sm text-center text-gray-500 dar:text-gray-400 py-4">
          Click al botón de "+" para empezar a agregar productos
        </p>

        <div class="mt-4 mb-6 text-left">
          <!-- 
            MODIFICADO: 
            - Se cambia el estilo de enlace simple por un botón de aspecto más moderno y claro.
            - Se añade 'flex items-center gap-2' para alinear el icono y el texto.
          -->
          <button
            class="flex items-center gap-2 text-sm font-medium text-indigo-600 dar:text-indigo-400 hover:text-indigo-500 dar:hover:text-indigo-300 transition-colors"
            type="button" @click="addNewItem">
            <i class="fa-solid fa-plus"></i>
            Agregar producto
          </button>
        </div>

        <div v-if="form.is_sell_to_employee == 0" class="mb-6 w-full">
          <!-- MODIFICADO: Se aplica un estilo de label moderno -->
          <label class="block text-sm font-medium text-gray-700 dar:text-gray-300 mb-1">Motivo *</label>
          <!-- 
            MODIFICADO: 
            - Se reemplaza 'class="textarea"' por clases de Tailwind modernas para inputs.
            - Añade 'shadow-sm', 'rounded-lg', 'focus:ring-2', 'focus:ring-indigo-500'
            - Añade soporte para modo oscuro.
          -->
          <textarea v-model="form.notes" rows="3" type="text" autocomplete="off"
            class="block w-full px-3 py-2 bg-white dar:bg-gray-700 border border-gray-300 dar:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm text-gray-900 dar:text-gray-100"
            placeholder="Ej. Rocío me dió permiso de tomar una botella de agua" />
          <InputError :message="form.errors.notes" class="mt-1" />
        </div>

        <!-- MODIFICADO: Se envuelve el botón principal en un flex para alinearlo a la derecha -->
        <div class="flex justify-end mt-6">
          <PrimaryButton :disabled="form.processing">Registrar</PrimaryButton>
        </div>
      </form>
    </div>
  </AppLayout>
</template>

<script>
// El script permanece sin cambios
import AppLayout from "@/Layouts/AppLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import ProductInput from "@/Components/ProductInput.vue";
import InputError from "@/Components/InputError.vue";
import Back from "@/Components/Back.vue";
import { Link, useForm } from "@inertiajs/inertia-vue3";
export default {
  data() {
    const form = useForm({
      items: [
        {
          id: 1,
          product_id: null,
          quantity: null,
        },
      ],
      is_sell_to_employee: '1',
      notes: null,
    });
    return {
      next_item_id: 2,
      form,
    };
  },
  components: {
    AppLayout,
    PrimaryButton,
    InputError,
    ProductInput,
    Back,
    Link,
  },
  props: {
    products: Array,
  },
  methods: {
    handleChangeType() {
      if (this.form.is_sell_to_employee == '0') {
        this.form.notes = null;
      } else {
        this.form.notes = 'Venta a empleado';
      }
    },
    addNewItem() {
      this.form.items.push({ id: this.next_item_id++, product_id: null, quantity: null });
    },
    deleteItem(index) {
      if (this.form.items.length > 1) {
        this.form.items.splice(index, 1);
      }
    },
    syncItems(index, product_obj) {
      this.form.items[index] = product_obj;
    },
    submit() {
      this.form.post(route("sales-to-employees.store"));
    },
  },
};
</script>
