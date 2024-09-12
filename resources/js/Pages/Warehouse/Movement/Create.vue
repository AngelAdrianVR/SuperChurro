<template>
  <AppLayout title="Movimientos de mercancia">
    <template #header>
      <div class="flex items-center mt-2">
        <Back />
        <h2 class="font-semibold text-xl text-gray-800 text-center ml-5 lg:ml-28">
          Movimientos de mercancía
        </h2>
      </div>
    </template>

    <div
      class="max-w-lg md:mx-auto mt-5 border border-gray3 rounded-lg px-5 py-8 bg-transparent mx-4"
    >
      <form @submit.prevent="submit">
        <div>
          <InputLabel value="Tipo de movimiento" class="mb-1 text-xs" />
          <div class="flex items-center mb-4">
            <div class="flex items-center mr-3">
              <input
                v-model="form.movement_is_entry"
                id="country-option-1"
                type="radio"
                name="countries"
                value="1"
                class="h-4 w-4 border-gray-300 focus:ring-2 focus:ring-primary text-primary"
                aria-labelledby="country-option-1"
                aria-describedby="country-option-1"
                checked=""
              />
              <label
                for="country-option-1"
                class="text-sm font-medium text-gray-900 ml-2 block"
              >
                Entrada
              </label>
            </div>
            <div class="flex items-center">
              <input
                v-model="form.movement_is_entry"
                id="country-option-2"
                type="radio"
                name="countries"
                value="0"
                class="h-4 w-4 border-gray-300 focus:ring-2 focus:ring-[#D20917] text-[#D20917]"
                aria-labelledby="country-option-2"
                aria-describedby="country-option-2"
              />
              <label
                for="country-option-2"
                class="text-sm font-medium text-gray-900 ml-2 block"
              >
                Salida
              </label>
            </div>
          </div>
        </div>

        <div class="mb-4">
          <InputLabel value="Tipo" class="mb-1 text-xs" />
          <select v-model="form.movement_concept_id" class="select w-full">
            <option selected>-- Seleccionar --</option>
            <option v-for="(concept) in concepts" :key="concept.id" :value="concept.id">
              {{ concept.name }}
            </option>
          </select>
        </div>

        <div>
          <InputLabel value="Productos" class="mb-1 text-xs" />
          <ProductInput
            :products="products"
            v-for="(item, index) in form.items"
            :key="item.id"
            :id="item.id"
            @deleteItem="deleteItem(index)"
            @syncItem="syncItems(index, $event)"
            class="mb-1"
          />
        </div>
        <p v-if="!form.items.length" class="text-sm text-gray-600">
          Click al botón de "+" para empezar a agregar productos
        </p>
        <div class="mt-2 mb-6 text-left">
          <button class="text-primary text-sm" type="button" @click="addNewItem">
            <i class="fa-solid fa-plus"></i>
            Agregar producto
          </button>
        </div>

        <div class="relative z-0 mb-6 w-full group">
          <InputLabel value="Observaciones o comentarios" class="mb-1 text-xs" />
          <textarea
            v-model="form.notes"
            rows="2"
            type="text"
            name="floating_description"
            autocomplete="off"
            class="textarea"
            placeholder=" "
          />
        </div>

        <div class="flex justify-start">
          <PrimaryButton :disabled="form.processing">Registrar</PrimaryButton>
        </div>
      </form>
    </div>
  </AppLayout>
</template>

<script>
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
