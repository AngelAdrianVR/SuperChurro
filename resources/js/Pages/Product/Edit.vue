<template>
  <AppLayout title="Editar Producto">
    <template #header>
      <div class="flex items-center mt-2 relative">
        <Back class="absolute left-0" />
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight text-center w-full">
          Editar producto:
          <strong class="ml-2 text-indigo-600 dark:text-indigo-400">{{ product.name }}</strong>
        </h2>
      </div>
    </template>

    <div class="py-12">
      <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6 sm:p-8">
          <form @submit.prevent="update" class="space-y-6">

            <!-- Nombre del producto -->
            <div>
              <InputLabel for="name" value="Nombre del producto *" class="dark:text-gray-300" />
              <input 
                id="name"
                v-model="form.name" 
                type="text" 
                autocomplete="off" 
                required
                class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                placeholder="Escribe el nombre del producto" 
              />
              <InputError :message="$page.props?.errors.name" class="mt-2" />
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
              <!-- Stock mínimo -->
              <div>
                <InputLabel for="low_stock" value="Stock mínimo *" class="dark:text-gray-300" />
                <input 
                  id="low_stock"
                  v-model="form.low_stock" 
                  type="number" 
                  autocomplete="off" 
                  required
                  class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                  placeholder="Ej. 10" 
                />
                <InputError :message="$page.props?.errors.low_stock" class="mt-2" />
              </div>

              <!-- Stock de apertura -->
              <div>
                <InputLabel for="initial_stock" value="Stock de apertura *" class="dark:text-gray-300" />
                <input 
                  id="initial_stock"
                  v-model="form.initial_stock" 
                  type="number" 
                  autocomplete="off" 
                  required
                  class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                  placeholder="Agrega el stock inicial" 
                />
                <InputError :message="$page.props?.errors.initial_stock" class="mt-2" />
              </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
              <!-- Precio -->
              <div>
                <InputLabel for="price" value="Precio *" class="dark:text-gray-300" />
                <div class="relative mt-1 rounded-md shadow-sm">
                  <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                    <span class="text-gray-500 dark:text-gray-400 sm:text-sm">$</span>
                  </div>
                  <input 
                    id="price"
                    v-model="form.price" 
                    type="number" 
                    step="0.01"
                    autocomplete="off" 
                    required
                    class="block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 pl-7 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600"
                    placeholder="0.00" 
                  />
                </div>
                <InputError :message="$page.props?.errors.price" class="mt-2" />
              </div>

              <!-- Precio a empleados -->
              <div>
                <InputLabel for="employee_price" value="Precio a empleados *" class="dark:text-gray-300" />
                <div class="relative mt-1 rounded-md shadow-sm">
                  <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                    <span class="text-gray-500 dark:text-gray-400 sm:text-sm">$</span>
                  </div>
                  <input 
                    id="employee_price"
                    v-model="form.employee_price" 
                    type="number" 
                    step="0.01"
                    autocomplete="off" 
                    required
                    class="block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 pl-7 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600"
                    placeholder="0.00" 
                  />
                </div>
                <InputError :message="$page.props?.errors.employee_price" class="mt-2" />
              </div>
            </div>

            <!-- Unidad de medida -->
            <div>
              <InputLabel for="unit_id" value="Unidad de medida *" class="dark:text-gray-300" />
              <select 
                id="unit_id"
                v-model="form.unit_id" 
                required
                class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
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
              <InputLabel for="code" value="Código del producto (opcional)" class="dark:text-gray-300" />
              <div class="relative mt-1 rounded-md shadow-sm">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                  <i class="fa-solid fa-barcode text-gray-400 dark:text-gray-500" aria-hidden="true"></i>
                </div>
                <input 
                  id="code"
                  v-model="form.code" 
                  type="text" 
                  autocomplete="off" 
                  class="block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 pl-10 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600"
                  placeholder="Escribe el código de producto" 
                />
              </div>
              <InputError :message="form.errors.code" class="mt-2" />
            </div>

            <!-- Foto del producto -->
            <div>
              <InputLabel value="Foto del producto" class="dark:text-gray-300" />
              <InputFilePreview 
                :imageUrl="product.media[0]?.original_url" 
                @imagen="saveImage" 
                @cleared="clearMedia()" 
                class="mt-1"
              />
            </div>

            <!-- Botón de Enviar -->
            <div class="flex justify-end pt-4">
              <PrimaryButton :disabled="form.processing">
                Guardar cambios
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
// import PayRollTable from "@/Components/PayRollTable.vue"; // No se usa
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputError from "@/Components/InputError.vue";
import Back from "@/Components/Back.vue";
import InputLabel from "@/Components/InputLabel.vue";
import InputFilePreview from '@/Components/MyComponents/InputFilePreview.vue';
import { Link, useForm } from "@inertiajs/inertia-vue3";
import { addOrUpdateItem } from "@/dbService.js";

export default {
  data() {
    const form = useForm({
      name: this.product.name,
      low_stock: this.product.low_stock,
      unit_id: this.product.unit?.id,
      price: this.product.current_price?.price,
      employee_price: this.product.current_employee_price?.price,
      // Se mantiene 'initial_stock' como en el original, aunque no estaba en la data()
      initial_stock: this.product.initial_stock, 
      code: this.product.code,
      media: this.product.media[0],
      media_cleared: false,
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
    product: Object,
    units: Array,
  },
  methods: {
    clearMedia() {
      this.form.media_cleared = true;
      this.form.media = null;
    },
    update() {
      // La lógica de 'update' con y sin media es compleja pero funcional,
      // así que se mantiene intacta como pediste.
      if (this.form.media == null) {
        this.form.put(route("products.update", this.product.id), {
          onSuccess: async () => {
            // guardar nuevo producto a IndexedDB
            const response = await axios.get(route('products.get-all-for-indexedDB'));
            const product = response.data.products.find(item => item.id == this.product.id);
            // actualizar a indexedDB
            if (product) {
              addOrUpdateItem('products', product);
            }

            this.$notify({
              title: "Correcto",
              message: 'Se ha editado el producto ' + this.product.name,
              type: "success",
            });
          },
        });
      } else {
        this.form.post(route("products.update-with-media", this.product.id), {
          method: '_put',
          onSuccess: async () => {
            // guardar nuevo producto a IndexedDB
            const response = await axios.get(route('products.get-all-for-indexedDB'));
            const product = response.data.products.find(item => item.id == this.product.id);
            // actualizar a indexedDB
            if (product) {
              addOrUpdateItem('products', product);
            }

            this.$notify({
              title: "Correcto",
              message: 'Se ha editado el producto ' + this.product.name,
              type: "success",
            });
          },
        });
      }
    },
    saveImage(image) {
      this.form.media = image;
    }
  },
};
</script>
