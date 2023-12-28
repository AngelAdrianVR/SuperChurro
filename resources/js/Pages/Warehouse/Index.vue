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
          <PrimaryButton>Registrar entrada / salida</PrimaryButton>
        </Link>
      </div>
    </div>

    <div class="border border-gray3 rounded-md inline-block mx-4 p-3 my-2">
        <p class="text-gray-800 font-bold text-left mb-2">Colaborador(es) en cocina</p>
        <div class="">
          <p v-for="employee in employees" :key="employee.id">
            <i class="fa-regular fa-circle-user"></i>
            {{ employee.name }}
          </p>
          <p v-if="Array.isArray(employees)" class="text-gray-500 text-xs text-center col-span-full mb-8">No hay colaboradores en cocina</p>
        </div>
    </div>

    <div>
        <div class="globe-container flex-col">
          <div v-for="product_id in Object.keys(warehouse.products)" :key="product_id" class="globe hover:bg-gray-200 cursor-pointer">
          <figure v-if="products.find(product => product.id == product_id )?.media.length > 0" class="justify-center pt-2">
            <img :src="products.find(product => product.id == product_id )?.media[0]?.original_url" alt="Imagen del producto" class="rounded-lg w-32 mx-auto">
          </figure>
            <Link :href="route('warehouse-movements.show-product-record', product_id)">
              <div class="globe-title !justify-center pb-2">
                {{ products.find(product => product.id == product_id )?.name }}
              </div>
              <div class="flex justify-center items-center" 
              :class="warehouse.products[product_id] <= products.find(product => product.id == product_id ).low_stock ? 'text-red-500' : 'text-green-500' ">
                <span>{{ warehouse.products[product_id] }} {{ products.find(product => product.id == product_id ).unit?.name }}</span>
              </div>
            </Link>
          </div>
        </div>
    </div>
  </AppLayout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
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
    PrimaryButton,
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
