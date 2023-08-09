<template>
  <AppLayout title="Cocina">
    <!-- <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Cocina</h2>
    </template> -->

    <div class="flex flex-col space-x-3 md:flex-row justify-end md:mr-10 mr-4 mt-10">
      <IconInput v-model="s" class="md:w-1/3" inputPlaceholder="Buscar producto" inputType="text">
        <el-tooltip content="Razon social" placement="top">
          <i class="fa-solid fa-magnifying-glass"></i>
        </el-tooltip>
      </IconInput>
      <!-- <InputError :message="form.errors.business_name" /> -->

      <div class="text-right ">
        <Link :href="route('warehouse-movements.create')">
          <ThirthButton>Registrar entrada / salida</ThirthButton>
        </Link>
      </div>
    </div>

    <div>
      <p class="text-gray-800 text-left ml-10 my-3">Colaborador(es) en cocina</p>
      <div class="grid grid-cols-2 lg:grid-cols-4">
        <p v-for="employee in employees" :key="employee.id" class="mx-3">
          <i class="fa-solid fa-user text-primary"></i>
          {{ employee.name }}
        </p>
        <p v-if="Array.isArray(employees)" class="text-gray-500 text-xs text-center col-span-full mb-8">No hay colaboradores en cocina</p>
      </div>
    </div>

    <div>
        <div class="globe-container flex-col">
          <div v-for="product_id in Object.keys(warehouse.products)" :key="product_id" class="globe hover:bg-gray-200 cursor-pointer">
          <figure class="justify-center">
            <img src="" alt="Imagen del producto">
          </figure>
            <Link :href="route('warehouse-movements.show-product-record', product_id)">
              <div class="globe-title !justify-center pb-2">
                {{ products.find(product => product.id == product_id ).name }}
              </div>
              <div class="flex justify-center items-center" 
              :class="warehouse.products[product_id] <= products.find(product => product.id == product_id ).low_stock ? 'text-red-500' : 'text-green-500' ">
                <span>{{ warehouse.products[product_id] }} {{ products.find(product => product.id == product_id ).unit.name }}</span>
              </div>
            </Link>
          </div>
        </div>
    </div>
  </AppLayout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import ThirthButton from "@/Components/ThirthButton.vue";
import { Link } from "@inertiajs/inertia-vue3";
import IconInput from "@/Components/IconInput.vue";

export default {
  data() {
    return {};
  },
  components: {
    AppLayout,
    SecondaryButton,
    Link,
    IconInput,
    ThirthButton
  },
  props: {
    warehouse: Object,
    products: Array,
    employees: Object,
  },
  methods: {},
};
</script>
