<template>
  <AppLayout title="Nuevo producto">
    <template #header>
      <div class="flex items-center mt-2 relative">
        <Back class="absolute left-0" />
        <h2 class="font-semibold text-xl text-gray-800 dar:text-gray-200 leading-tight text-center w-full">
          Nuevo producto
        </h2>
      </div>
    </template>

    <div class="py-12">
      <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dar:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6 sm:p-8">
          <form @submit.prevent="store" class="space-y-6">

            <!-- Nombre del producto -->
            <div>
              <InputLabel for="name" value="Nombre del producto *" class="dar:text-gray-300" />
              <input 
                id="name"
                v-model="form.name" 
                type="text" 
                autocomplete="off" 
                required
                class="mt-1 block w-full border-gray-300 dar:border-gray-700 dar:bg-gray-900 dar:text-gray-300 focus:border-indigo-500 dar:focus:border-indigo-600 focus:ring-indigo-500 dar:focus:ring-indigo-600 rounded-md shadow-sm"
                placeholder="Escribe el nombre del producto" 
              />
              <InputError :message="$page.props?.errors.name" class="mt-2" />
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
              <!-- Stock mínimo -->
              <div>
                <InputLabel for="low_stock" value="Stock mínimo *" class="dar:text-gray-300" />
                <input 
                  id="low_stock"
                  v-model="form.low_stock" 
                  type="number" 
                  autocomplete="off" 
                  required
                  class="mt-1 block w-full border-gray-300 dar:border-gray-700 dar:bg-gray-900 dar:text-gray-300 focus:border-indigo-500 dar:focus:border-indigo-600 focus:ring-indigo-500 dar:focus:ring-indigo-600 rounded-md shadow-sm"
                  placeholder="Ej. 10" 
                />
                <InputError :message="$page.props?.errors.low_stock" class="mt-2" />
              </div>

              <!-- Stock de apertura -->
              <div>
                <InputLabel for="initial_stock" value="Stock de apertura *" class="dar:text-gray-300" />
                <input 
                  id="initial_stock"
                  v-model="form.initial_stock" 
                  type="number" 
                  autocomplete="off" 
                  required
                  class="mt-1 block w-full border-gray-300 dar:border-gray-700 dar:bg-gray-900 dar:text-gray-300 focus:border-indigo-500 dar:focus:border-indigo-600 focus:ring-indigo-500 dar:focus:ring-indigo-600 rounded-md shadow-sm"
                  placeholder="Ej. 100" 
                />
                <InputError :message="$page.props?.errors.initial_stock" class="mt-2" />
              </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
              <!-- Precio -->
              <div>
                <InputLabel for="price" value="Precio *" class="dar:text-gray-300" />
                <div class="relative mt-1 rounded-md shadow-sm">
                  <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                    <span class="text-gray-500 dar:text-gray-400 sm:text-sm">$</span>
                  </div>
                  <input 
                    id="price"
                    v-model="form.price" 
                    type="number" 
                    step="0.01"
                    autocomplete="off" 
                    required
                    class="block w-full rounded-md border-gray-300 dar:border-gray-700 dar:bg-gray-900 dar:text-gray-300 pl-7 focus:border-indigo-500 dar:focus:border-indigo-600 focus:ring-indigo-500 dar:focus:ring-indigo-600"
                    placeholder="0.00" 
                  />
                </div>
                <InputError :message="$page.props?.errors.price" class="mt-2" />
              </div>

              <!-- Precio a empleados -->
              <div>
                <InputLabel for="employee_price" value="Precio a empleados *" class="dar:text-gray-300" />
                <div class="relative mt-1 rounded-md shadow-sm">
                  <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                    <span class="text-gray-500 dar:text-gray-400 sm:text-sm">$</span>
                  </div>
                  <input 
                    id="employee_price"
                    v-model="form.employee_price" 
                    type="number" 
                    step="0.01"
                    autocomplete="off" 
                    required
                    class="block w-full rounded-md border-gray-300 dar:border-gray-700 dar:bg-gray-900 dar:text-gray-300 pl-7 focus:border-indigo-500 dar:focus:border-indigo-600 focus:ring-indigo-500 dar:focus:ring-indigo-600"
                    placeholder="0.00" 
                  />
                </div>
                <InputError :message="$page.props?.errors.employee_price" class="mt-2" />
              </div>
            </div>

            <!-- Unidad de medida -->
            <div>
              <InputLabel for="unit_id" value="Unidad de medida *" class="dar:text-gray-300" />
              <select 
                id="unit_id"
                v-model="form.unit_id" 
                required
                class="mt-1 block w-full border-gray-300 dar:border-gray-700 dar:bg-gray-900 dar:text-gray-300 focus:border-indigo-500 dar:focus:border-indigo-600 focus:ring-indigo-500 dar:focus:ring-indigo-600 rounded-md shadow-sm"
              >
                <option value="" disabled>-- Seleccione --</option>
                <option v-for="unit in units" :key="unit.id" :value="unit.id">
                  {{ unit.name }}
                </option>
              </select>
              <InputError :message="$page.props?.errors.unit_id" class="mt-2" />
            </div>

            <!-- Código del producto -->
            <div>
              <InputLabel for="code" value="Código del producto (opcional)" class="dar:text-gray-300" />
              <div class="relative mt-1 rounded-md shadow-sm">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                  <i class="fa-solid fa-barcode text-gray-400 dar:text-gray-500" aria-hidden="true"></i>
                </div>
                <input 
                  id="code"
                  v-model="form.code" 
                  type="text" 
                  autocomplete="off" 
                  class="block w-full rounded-md border-gray-300 dar:border-gray-700 dar:bg-gray-900 dar:text-gray-300 pl-10 focus:border-indigo-500 dar:focus:border-indigo-600 focus:ring-indigo-500 dar:focus:ring-indigo-600"
                  placeholder="Escribe el código de producto" 
                />
              </div>
              <InputError :message="form.errors.code" class="mt-2" />
            </div>

            <!-- Foto del producto -->
            <div>
              <InputLabel value="Foto del producto" class="dar:text-gray-300" />
              <InputFilePreview @imagen="saveImage" class="mt-1" />
            </div>

            <!-- Botón de Enviar -->
            <div class="flex justify-end pt-4">
              <PrimaryButton :disabled="form.processing">
                Agregar producto
              </PrimaryButton>
            </div>
          </form>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import InputFilePreview from '@/Components/MyComponents/InputFilePreview.vue';
import Back from "@/Components/Back.vue";
import { Link, useForm } from "@inertiajs/inertia-vue3";
import { addOrUpdateItem } from "@/dbService.js";
// PayRollTable no se usa en este template, se podría quitar
// import PayRollTable from "@/Components/PayRollTable.vue"; 

export default {
  data() {
    const form = useForm({
      name: null,
      low_stock: null,
      unit_id: null, // Asignar null o un valor por defecto
      price: null,
      employee_price: null,
      initial_stock: null,
      code: null,
      media: null,
    });
    return {
      form,
    };
  },
  components: {
    AppLayout,
    // PayRollTable,
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
    async store() {
      try {
        this.form.post(route("products.store", {
          onSuccess: async () => {
            // guardar nuevo producto a IndexedDB
            // Obtener producto mas reciente agregado
            const response = await axios.get(route('products.get-all-for-indexedDB'));
            const product = response.data.products[0];

            // agregar a indexedDB
            await addOrUpdateItem('products', product);

            // toast
            this.$notify({
              title: "Correcto",
              message: "Producto agregado",
              type: "success",
            });
          },
        }));

      } catch (error) {
        console.error(error);
        this.$notify({
          title: "Error",
          message: "No se pudo agregar el producto",
          type: "error",
        });
      }
    },
    saveImage(image) {
      this.form.media = image;
    }
  },
};
</script>

