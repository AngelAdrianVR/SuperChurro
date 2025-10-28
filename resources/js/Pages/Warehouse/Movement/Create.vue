<template>
  <AppLayout title="Movimientos de mercancia">
    <template #header>
      <!-- MODIFICADO: Se añade 'gap-4' para un espaciado limpio y mejor alineación -->
      <div class="flex items-center mt-2 gap-4">
        <Back />
        <!-- MODIFICADO: Se elimina 'ml-5 lg:ml-28' para un centrado más natural -->
        <h2 class="font-semibold text-xl text-gray-800">
          Movimientos de mercancía
        </h2>
      </div>
    </template>

    <!-- 
      MODIFICADO: 
      - Se cambia el contenedor por una tarjeta moderna.
      - 'max-w-lg md:mx-auto' se mantiene y se ajusta a 'max-w-2xl'.
      - Se reemplaza 'border border-gray3 bg-transparent' por 'bg-white shadow-xl rounded-2xl'.
      - Se aumenta el padding: 'p-6 sm:p-8'.
    -->
    <div class="max-w-2xl mx-auto mt-5 p-6 sm:p-8 bg-white shadow-xl rounded-2xl">
      <form @submit.prevent="submit" class="space-y-6">
        <!-- MODIFICADO: Se agrupan los inputs de radio en un fieldset para mejor semántica -->
        <fieldset>
          <InputLabel value="Tipo de movimiento" class="mb-2 font-medium text-gray-700" />
          <!-- MODIFICADO: Se usa 'flex gap-6' para espaciar los radio buttons -->
          <div class="flex items-center gap-6 mb-4">
            <div class="flex items-center">
              <input v-model="form.movement_is_entry" id="radio-entry" type="radio" name="movement-type" value="1"
                class="h-4 w-4 border-gray-300 focus:ring-2 focus:ring-indigo-500 text-indigo-600" checked />
              <label for="radio-entry" class="text-sm font-medium text-gray-900 ml-2 block">
                Entrada
              </label>
            </div>
            <div class="flex items-center">
              <input v-model="form.movement_is_entry" id="radio-exit" type="radio" name="movement-type" value="0"
                class="h-4 w-4 border-gray-300 focus:ring-2 focus:ring-red-500 text-red-600" />
              <label for="radio-exit" class="text-sm font-medium text-gray-900 ml-2 block">
                Salida
              </label>
            </div>
          </div>
        </fieldset>

        <!-- MODIFICADO: Estilos modernos para el select -->
        <div class="mb-4">
          <InputLabel value="Tipo" class="mb-1 font-medium text-gray-700" />
          <select v-model="form.movement_concept_id"
            class="block w-full px-3 py-2 bg-white border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm text-gray-900">
            <option selected value="null">-- Seleccionar --</option>
            <option v-for="(concept) in concepts" :key="concept.id" :value="concept.id">
              {{ concept.name }}
            </option>
          </select>
        </div>

        <div>
          <InputLabel value="Productos" class="mb-2 font-medium text-gray-700" />
          <!-- MODIFICADO: Se añade 'space-y-3' para espaciar los inputs de producto -->
          <div class="space-y-3">
            <ProductInput :products="products" v-for="(item, index) in form.items" :key="item.id" :id="item.id"
              @deleteItem="deleteItem(index)" @syncItem="syncItems(index, $event)" />
          </div>
        </div>
        
        <!-- MODIFICADO: Estilo de placeholder más suave -->
        <p v-if="!form.items.length" class="text-sm text-center text-gray-500 py-3">
          Click al botón de "+" para empezar a agregar productos
        </p>

        <!-- MODIFICADO: Estilo de botón para "Agregar producto" mejorado -->
        <div class="mt-4 mb-6 text-left">
          <button
            class="flex items-center gap-2 text-sm font-medium text-indigo-600 hover:text-indigo-500 transition-colors"
            type="button" @click="addNewItem">
            <i class="fa-solid fa-plus"></i>
            Agregar producto
          </button>
        </div>

        <!-- MODIFICADO: Estilos modernos para el textarea -->
        <div class="w-full">
          <InputLabel value="Observaciones o comentarios" class="mb-1 font-medium text-gray-700" />
          <textarea v-model="form.notes" rows="3" type="text" autocomplete="off"
            class="block w-full px-3 py-2 bg-white border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm text-gray-900"
            placeholder="Ej. Ingreso de mercancía semanal..." />
        </div>

        <!-- MODIFICADO: Botón principal alineado a la derecha -->
        <div class="flex justify-end pt-4">
          <PrimaryButton :disabled="form.processing">Registrar</PrimaryButton>
        </div>
      </form>
    </div>
  </AppLayout>
</template>

<script>
// El script permanece sin cambios
import AppLayout from "@/Layouts/AppLayout.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import ProductInput from "@/Components/ProductInput.vue";
import Back from "@/Components/Back.vue";
import { Link, useForm } from "@inertiajs/inertia-vue3";


export default {
  data() {
    const form = useForm({
      movement_is_entry: 1,
      movement_concept_id: null,
      notes: null,
      items: [
        {
          id: 1,
          product_id: null,
          quantity: null,
        },
      ],
    });
    return {
      next_item_id: 2,
      form,
    };
  },
  components: {
    AppLayout,
    InputError,
    InputLabel,
    ProductInput,
    PrimaryButton,
    Back,
    Link,
  },
  props: {
    products: Array,
    movement_concepts: Array,
  },
  computed: {
    concepts() {
      if (this.form.movement_is_entry == 1) {
        return this.movement_concepts.filter((concept) => concept.is_entry == true);
      } else {
        return this.movement_concepts.filter((concept) => concept.is_entry == false);
      }
    },
  },
  methods: {
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
      this.form.post(route("warehouse-movements.store"), {
        onSuccess: () => {
          this.$notify({
            title: 'Movimiento registrado',
            message: '',
            type: 'success',
          })
        }
      });
    },
  },
};
</script>

