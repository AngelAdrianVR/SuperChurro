<template>
  <AppLayout title="Venta a empleado / cortesias">
    <template #header>
      <div class="flex items-center mt-2">
        <Back />
        <h2 class="font-semibold text-xl text-gray-800 text-center ml-5 lg:ml-28">
          Venta a empleado / cortesias
        </h2>
      </div>
    </template>

    <div class="mx-2 md:mx-48 mt-5 px-4 pt-5 pb-4 rounded-lg border border-gray3 bg-transparent">
      <form @submit.prevent="submit">
        <div>
          <el-radio-group v-model="form.is_sell_to_employee" @change="handleChangeType"
            class="!flex justify-center mb-4 mt-1">
            <el-radio label="1">Venta a empleado</el-radio>
            <el-radio label="0">Cortesías</el-radio>
          </el-radio-group>
          <!-- <div class="flex items-center mb-4">
            <div class="flex items-center mr-3">
              <input  v-model="form.is_sell_to_employee" id="sell-option-1" type="radio" name="sell_type" value="1"
                class="h-4 w-4 border-gray-400 focus:ring-2 focus:ring-primary text-primary bg-transparent"
                aria-labelledby="sell-option-1" aria-describedby="sell-option-1" checked="" />
              <label for="sell-option-1" class="text-sm font-medium text-gray-900 ml-2 block">
                Venta a empleado
              </label>
            </div>
            <div class="flex items-center">
              <input v-model="form.is_sell_to_employee" id="sell-option-2" type="radio" name="sell_type" value="0"
                class="h-4 w-4 border-gray-400 focus:ring-2 focus:ring-primary text-primary bg-transparent"
                aria-labelledby="sell-option-2" aria-describedby="sell-option-2" />
              <label for="sell-option-2" class="text-sm font-medium text-gray-900 ml-2 block">
                Cortesías
              </label>
            </div>
          </div> -->
        </div>
        <div>
          <ProductInput :products="products" show_price v-for="(item, index) in form.items" :key="item.id" :id="item.id"
            @deleteItem="deleteItem(index)" @syncItem="syncItems(index, $event)" class="mb-1" />
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
        <div v-if="form.is_sell_to_employee == 0" class="relative z-0 mb-6 w-full group">
          <label class="text-sm mb-1 ml-2">Motivo *</label>
          <textarea v-model="form.notes" rows="2" type="text" autocomplete="off" class="textarea"
            placeholder="Ej. Rocío me dió permiso de tomar una botella de agua" />
          <InputError :message="form.errors.notes" />
        </div>

        <PrimaryButton :disabled="form.processing">Registrar</PrimaryButton>
      </form>
    </div>
  </AppLayout>
</template>

<script>
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
