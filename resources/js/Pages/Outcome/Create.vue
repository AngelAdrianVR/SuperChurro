<template>
  <AppLayout title="Agregar Egresos">
    <template #header>
      <div class="flex items-center mt-2">
        <Back />
        <h2 class="font-semibold text-xl text-gray-800 text-center ml-5 lg:ml-28">
          Agregar egreso
        </h2>
      </div>
    </template>

    <div class="
        max-w-2xl
        md:mx-auto
        mt-5
        rounded-lg
        px-5
        pt-4
        pb-5
        bg-transparent
        border border-gray3
        mx-4
      ">
      <p v-if="validation_message" class="text-red-400 text-xs mb-2" v-html="validation_message"></p>
      <form @submit.prevent="store">
        <div class="mb-3">
          <InputLabel value="Categoría" class="ml-3 mb-1 text-sm" />
          <select
            class="select w-full"
            v-model="form.category"
          >
            <option disabled selected class="text-gray-500">
              -- Seleccione --
            </option>
            <option
              class="text-gray-500"
              v-for="category in categories"
              :key="category"
              :value="category"
            >
              {{ category }}
            </option>
          </select>
          <InputError :message="$page.props?.errors.category" />
        </div>

        <div class="mb-3 w-full">
          <InputLabel value="Fecha" class="ml-3 mb-1 text-sm" />
          <input v-model="form.date" type="date" autocomplete="off" class="input"
           placeholder="Seleccione la fecha" />
           <InputError :message="$page.props?.errors.date" />
        </div>

        <div class="mb-3">
          <InputLabel value="Método de pago" class="ml-3 mb-1 text-sm" />
          <select
            class="select w-full"
            v-model="form.payment_method"
          >
            <option disabled selected class="text-gray-500">
              -- Seleccione --
            </option>
            <option
              class="text-gray-500"
              v-for="item in payment_methods"
              :key="item"
              :value="item"
            >
              {{ item }}
            </option>
          </select>
          <InputError :message="$page.props?.errors.payment_method" />
        </div>

        <div class="mb-3 w-full">
          <InputLabel value="Proveedor o comercio" class="ml-3 mb-1 text-sm" />
          <input v-model="form.provider" type="text" autocomplete="off" class="input" />
          <InputError :message="$page.props?.errors.provider" />
        </div>

        <div>
          <OutcomeInput v-for="(item, index) in form.items" :key="item.id" :id="item.id" @deleteItem="deleteItem(index)"
            @syncItem="syncItems(index, $event)" class="mb-2" />
        </div>
        <p v-if="!form.items.length" class="text-sm text-gray-600"> Click al botón de "+" para empezar a agregar
          productos </p>
        <div class="mt-2 mb-6 text-left">
          <button class="text-primary text-sm" type="button" @click="addNewItem">
            <i class="fa-solid fa-plus"></i>
            Agregar producto
          </button>
        </div>

        <div class="my-2 w-full">
          <InputLabel value="Notas" class="ml-3 mb-1 text-sm" />
          <textarea
            v-model="form.notes"
            rows="2"
            type="text"
            autocomplete="off"
            class="textarea"
          />
        </div>

        <div class="mt-5">
          <PrimaryButton :disabled="form.processing">Guardar</PrimaryButton>
        </div>
      </form>
    </div>


  </AppLayout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import OutcomeInput from "@/Components/OutcomeInput.vue";
import Back from "@/Components/Back.vue";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import { Link, useForm } from "@inertiajs/inertia-vue3";


export default {
  data() {
    const form = useForm({
      category: null,
      date: null,
      payment_method: null,
      provider: null,
      items: [
        {
          id: 1,
          concept: null,
          quantity: 1,
          cost: null,
        }
      ],
      notes: "",
    })
    return {
      form,
      validation_message: "",
      next_item_id: 2,
      categories: [
        'Gastos varios',
        'Compra de insumos',
        'Gasto de alimento para colaboradores',
        'Costo de operaciones del carrito',
        'Servicios públicos',
        'Gastos administrativos',
        'Material de limpieza',
        'Gastos de farmacia',
        'Otro',
      ],
      payment_methods: [
        'Efectivo',
        'Tarjeta de crédito',
        'Tarjeta de débito',
        'Otro',
      ],
    }
  },
  components: {
    AppLayout,
    SecondaryButton,
    PrimaryButton,
    OutcomeInput,
    InputLabel,
    InputError,
    Back,
    Link,
  },
  props: {

  },

  methods: {
    addNewItem() {
      this.form.items.push({ id: this.next_item_id++, quantity: null, });
    },
    deleteItem(index) {
      if (this.form.items.length > 1) {
        this.form.items.splice(index, 1);
      }
    },
    syncItems(index, concept_obj) {
      this.form.items[index] = concept_obj;
    },
    store() {
      //   this.quantityValidated();
      //   if (this.validation_message == "") {
      this.form.post(this.route("outcomes.store"));
      //   }
    },
    // quantityValidated() {
    //   this.validation_message = "";
    //   this.form.items.forEach(product => {
    //     const available_quantity = this.cart_stock[product.product_id];
    //     if (available_quantity < product.quantity) {
    //       this.validation_message += `- Sólo hay disponible <strong>${available_quantity}</strong> unidades del producto <strong>` +
    //         this.products.find(item => item.id == product.product_id).name + '</strong> en carrito</br>';
    //     }
    //   });
    // },
  },
};
</script>
