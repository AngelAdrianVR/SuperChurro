<template>
  <AppLayout title="Remover productos">
    <template #header>
      <!-- MODIFICADO: 
        - Se agregaron clases para modo oscuro (dar:text-gray-100).
        - Se cambió el centrado de 'ml-5 lg:ml-28' (que era frágil) a 'flex-grow text-center'.
        - Se agregó un pequeño margen negativo en móvil ('-ml-10') para compensar el botón 'Back' y se resetea en 'sm'.
      -->
      <div class="flex items-center mt-2">
        <Back />
        <h2 class="font-semibold text-xl text-gray-900 dar:text-gray-100 text-center flex-grow -ml-10 sm:ml-0">
          Remover producto(s)
        </h2>
      </div>
    </template>

    <!-- MODIFICADO: 
      - Contenedor principal cambiado de 'bg-transparent' y 'border' a una tarjeta moderna.
      - Se usa 'bg-white dar:bg-gray-800' para un fondo sólido.
      - Se reemplaza 'border' por 'shadow-xl' para elevación.
      - Se aumenta el radio del borde a 'rounded-2xl'.
      - Se aumenta el espaciado interno (padding) a 'p-6 sm:p-8'.
      - Se aumenta el margen superior (margin-top) a 'mt-6 sm:mt-8'.
    -->
    <div class="
        max-w-2xl
        md:mx-auto
        mt-6 sm:mt-8
        rounded-2xl
        p-6 sm:p-8
        bg-white
        dar:bg-gray-800
        shadow-xl
        mx-4
      ">

      <!-- MODIFICADO: 
        - Mensaje de validación estilizado como una "alerta" o "callout".
        - Colores de texto y fondo más definidos para la alerta.
      -->
      <div v-if="validation_message" class="mb-4 p-4 text-sm text-red-700 bg-red-50 rounded-lg dar:bg-gray-700 dar:text-red-400 border border-red-200 dar:border-red-600"
        role="alert">
        <span class="font-medium">Error de validación:</span>
        <div v-html="validation_message" class="mt-1"></div>
      </div>

      <form @submit.prevent="store">
        <!-- MODIFICADO: 
          - Se agregó 'mb-1' a la etiqueta para separarla del select.
          - Se reemplazó la clase 'select' por clases estándar de Tailwind para formularios.
          - Ahora es 'w-full' y tiene estilos para modo oscuro, foco y bordes redondeados.
          - Se aumentó el margen inferior a 'mb-4'.
        -->
        <InputLabel value="Concepto" class="mb-1" />
        <select class="
            mb-4
            block
            w-full
            border-gray-300
            dar:border-gray-600
            dar:bg-gray-700
            dar:text-gray-200
            focus:border-indigo-500
            dar:focus:border-indigo-400
            focus:ring-indigo-500
            dar:focus:ring-indigo-400
            rounded-lg
            shadow-sm" v-model="form.concept">
          <option disabled selected class="text-gray-500" value="">
            -- Selecciona concepto --
          </option>
          <option v-for="(concept, index) in concepts" :key="index" :value="concept">
            {{ concept }}
          </option>
        </select>

        <div>
          <ProductInput :products="products" v-for="(item, index) in form.items" :key="item.id" :id="item.id"
            @deleteItem="deleteItem(index)" @syncItem="syncItems(index, $event)" class="mb-2" />
        </div>

        <p v-if="!form.items.length" class="text-sm text-gray-600 dar:text-gray-400"> 
          Click al botón de "+" para empezar a agregar productos 
        </p>
        
        <!-- MODIFICADO: 
          - Botón de "Agregar" estilizado como un botón de texto moderno.
          - Se usa 'text-indigo-600' para un color de acento.
          - Se agregaron efectos 'hover' y 'focus' claros.
          - Se añadió 'items-center' y 'mr-2' al ícono para mejor alineación.
        -->
        <div class="mt-4 mb-6 text-left">
          <button class="
              inline-flex
              items-center
              text-sm
              font-medium
              text-indigo-600
              dar:text-indigo-400
              hover:text-indigo-800
              dar:hover:text-indigo-300
              focus:outline-none
              focus:ring-2
              focus:ring-indigo-500
              focus:ring-offset-2
              dar:focus:ring-offset-gray-800
              rounded-md" 
            type="button" @click="addNewItem">
            <i class="fa-solid fa-plus mr-2"></i>
            Agregar producto
          </button>
        </div>

        <!-- MODIFICADO: 
          - Se envolvió el botón principal en un 'div' con 'flex justify-end'.
          - Se agregó 'w-full sm:w-auto' al botón para que sea full-width en móviles
            y de ancho automático en pantallas más grandes.
        -->
        <div class="flex justify-end mt-6">
          <PrimaryButton class="w-full sm:w-auto" :disabled="form.processing">
            Remover de carrito
          </PrimaryButton>
        </div>
      </form>
    </div>
  </AppLayout>
</template>

<script>
// El script permanece sin cambios
import AppLayout from "@/Layouts/AppLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import ProductInput from "@/Components/ProductInput.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
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
        }
      ],
      concept: "",
    })
    return {
      validation_message: "",
      next_item_id: 2,
      form,
      concepts: [
        'Producto en mal estado',
        'Devolución a cocina'
      ],
    };
  },
  components: {
    AppLayout,
    PrimaryButton,
    InputError,
    SecondaryButton,
    ProductInput,
    InputLabel,
    Back,
    Link,
  },
  props: {
    products: Array,
    cart_stock: Object,
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
    store() {
      this.quantityValidated();
      if (this.validation_message == "") {
        this.form.post(this.route("cart.store-removed-products"));
      }
    },
    quantityValidated() {
      this.validation_message = "";
      this.form.items.forEach(product => {
        const available_quantity = this.cart_stock[product.product_id];
        if (available_quantity < product.quantity) {
          this.validation_message += `- Sólo hay disponible <strong>${available_quantity}</strong> unidades del producto <strong>` +
            this.products.find(item => item.id == product.product_id).name + '</strong> en carrito</br>';
        }
      });
    },
  },
};
</script>
