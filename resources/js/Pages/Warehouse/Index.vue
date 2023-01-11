<template>
  <AppLayout title="Cocina">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Cocina</h2>
    </template>

    <div class="flex justify-end">
      <Link :href="route('warehouse-movements.create')">
        <SecondaryButton class="mt-5 mr-2">Registrar Entrada/Salida</SecondaryButton>
      </Link>
    </div>

    <div>
        <div class="globe-container flex-col">
          <div v-for="product_id in Object.keys(warehouse.products)" :key="product_id" class="globe hover:bg-gray-200 cursor-pointer">
            <Link :href="route('warehouse-movements.show-product-record', product_id)">
              <div class="globe-title !justify-start pb-2">
                {{ products.find(product => product.id == product_id ).name }}
              </div>
              <div class="flex justify-between items-center" 
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
import { Link } from "@inertiajs/inertia-vue3";
export default {
  data() {
    return {};
  },
  components: {
    AppLayout,
    SecondaryButton,
    Link,
  },
  props: {
    warehouse: Object,
    products: Array,
  },
  methods: {},
};
</script>
