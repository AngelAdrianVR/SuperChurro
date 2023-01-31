<template>
  <AppLayout title="Movimientos de mercancia">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Movimientos de mercancía
      </h2>
    </template>

    <div class="flex justify-start">
      <Link
        :href="route('warehouses.index')"
        class="flex items-center mt-2 text-slate-700"
      >
        <i
          class="fas fa-long-arrow-alt-left text-lg active:bg-gray-300 bg-opacity-100 rounded-full w-7 h-7 pl-1 ml-2"
        ></i>
        <span class="ml-1 cursor-default">Atrás</span>
      </Link>
    </div>

    <div
      class="max-w-2xl md:mx-auto mt-5 shadow-md shadow-gray-500/70 rounded-lg px-5 py-8 bg-white mx-4"
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
                class="h-4 w-4 border-gray-300 focus:ring-2 focus:ring-blue-300"
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
                class="h-4 w-4 border-gray-300 focus:ring-2 focus:ring-blue-300"
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
          <InputLabel value="Concepto" class="mb-1 text-xs" />
          <select v-model="form.movement_concept_id" class="select w-full">
            <option value="" selected>-- Seleccionar --</option>
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
            class="mb-5"
          />
        </div>
        <p v-if="!form.items.length" class="text-sm text-gray-600">
          Click al botón de "+" para empezar a agregar productos
        </p>
        <div class="mt-2 mb-6 text-center">
          <button type="button" @click="addNewItem">
            <i class="fa-solid fa-circle-plus text-2xl text-blue-400"></i>
          </button>
        </div>

        <div class="relative z-0 mb-6 w-full group">
          <input
            v-model="form.notes"
            type="text"
            name="floating_description"
            autocomplete="off"
            class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-gray-700 dark:border-gray-600 dark:focus:border-stone-500 focus:outline-none focus:ring-0 focus:border-stone-600 peer"
            placeholder=" "
          />
          <label
            for="floating_description"
            class="absolute text-sm text-gray-500 dark:text-gray-700 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-stone-600 peer-focus:dark:text-stone-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
            >Notas o comentarios</label
          >
        </div>

        <div class="flex justify-center lg:justify-end">
          <PrimaryButton :disabled="form.processing">Solicitar</PrimaryButton>
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
    Link,
    InputError,
    InputLabel,
    ProductInput,
    PrimaryButton,
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
      this.form.post(route("warehouse-movements.store"));
    },
  },
};
</script>
