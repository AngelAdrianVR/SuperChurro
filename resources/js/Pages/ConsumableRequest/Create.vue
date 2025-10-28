<template>
  <AppLayout title="Solicitar consumibles">
    <template #header>
      <!-- 
        MODIFICACIÓN: 
        - Layout de header centrado y consistente.
      -->
      <div class="relative flex items-center justify-center py-2">
        <div class="absolute left-0">
          <Back />
        </div>
        <h2 class="font-semibold text-xl text-gray-900 leading-tight">
          Solicitud de consumibles
        </h2>
      </div>
    </template>

    <!-- 
      MODIFICACIÓN: 
      - Contenedor del formulario estilo 'card' moderno.
      - Se usa max-w-2xl para dar más espacio a los items.
    -->
    <div class="max-w-2xl mx-auto mt-8 p-6 lg:p-8 bg-white rounded-xl shadow-lg mb-8">
      <!-- <p v-if="validation_message" class="text-red-600 text-sm mb-4" v-html="validation_message"></p> -->
      <form @submit.prevent="store">
        <div>
          <!-- 
            MODIFICACIÓN: 
            - Header de la lista con mejor espaciado y tipografía.
          -->
          <header class="flex items-center border-b pb-2 mb-3">
            <label class="w-1/2 font-semibold text-sm text-gray-700">Consumible</label>
            <label class="font-semibold text-sm text-gray-700">Cantidad</label>
          </header>
          <!-- 
            MODIFICACIÓN: 
            - Se añade un contenedor para los items con espaciado.
          -->
          <div class="space-y-3">
            <ConsumableInput
              :consumables="consumables"
              v-for="(item, index) in form.items"
              :key="item.id"
              :id="item.id"
              @deleteItem="deleteItem(index)"
              @syncItem="syncItems(index, $event)"
            />
          </div>
        </div>

        <!-- 
          MODIFICACIÓN: 
          - Mensaje de "sin items" centrado y más claro.
        -->
        <p v-if="!form.items.length" class="text-sm text-gray-500 text-center py-4">
          Click al botón de "+" para empezar a agregar consumibles
        </p>

        <!-- 
          MODIFICACIÓN: 
          - Botón "Agregar" con un estilo más limpio y moderno.
        -->
        <div class="mt-4 mb-6 text-left">
          <button
            class="text-blue-600 hover:text-blue-800 text-sm font-medium flex items-center gap-1"
            type="button"
            @click="addNewItem"
          >
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
              <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
            Agregar consumible
          </button>
        </div>

        <!-- 
          MODIFICACIÓN: 
          - Estilos modernos para el 'textarea'.
        -->
        <div class="mt-6">
          <label class="block mb-2 text-sm font-medium text-gray-700">Comentarios</label>
          <textarea
            v-model="form.notes"
            rows="3"
            class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-600 focus:border-blue-600 sm:text-sm"
            placeholder="Añade notas o comentarios a la solicitud..."
          ></textarea>
        </div>

        <!-- 
          MODIFICACIÓN: 
          - Botón de envío alineado a la derecha.
        -->
        <div class="flex justify-end mt-8">
          <PrimaryButton :disabled="form.processing">Solicitar</PrimaryButton>
        </div>
      </form>
    </div>
  </AppLayout>
</template>

<!-- El script se mantiene idéntico -->
<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import ConsumableInput from "@/Components/ConsumableInput.vue";
import InputError from "@/Components/InputError.vue";
import Back from "@/Components/Back.vue";
import { Link, useForm } from "@inertiajs/inertia-vue3";
export default {
  data() {
    const form = useForm({
      items: [
        {
          id: 1,
          consumable_id: null,
          quantity: null,
          notes: null,
        },
      ],
    });
    return {
      validation_message: "",
      next_item_id: 2,
      form,
    };
  },
  components: {
    AppLayout,
    PrimaryButton,
    InputError,
    SecondaryButton,
    ConsumableInput,
    Back,
    Link,
  },
  props: {
    consumables: Array,
    warehouse_stock: Object,
  },
  methods: {
    addNewItem() {
      this.form.items.push({ id: this.next_item_id++, consumable_id: null, quantity: null });
    },
    deleteItem(index) {
      if (this.form.items.length > 1) {
        this.form.items.splice(index, 1);
      }
    },
    syncItems(index, consumable_obj) {
      this.form.items[index] = consumable_obj;
    },
    store() {
      // this.quantityValidated();
      if (this.validation_message == "") {
        this.form.post(this.route("consumable-request.store"), {
          onSuccess: () => {
            this.$notify({
              title: "Solicitado",
              message: "",
              type: "success",
            });
          }
        });
      }
    },
    // quantityValidated() {
    //   this.validation_message = "";
    //   this.form.items.forEach((consumable) => {
    //     const available_quantity = this.warehouse_stock[consumable.consumable_id];
    //     if (available_quantity < consumable.quantity) {

    //       this.validation_message += `- Sólo hay disponible <strong>${available_quantity}</strong> unidades del consumible <strong>` +
    //         this.consumables.find(item => item.id == consumable.consumable_id).name + '</strong> en cocina</br>';

    //     }
    //   });
    // },
  },
};
</script>

