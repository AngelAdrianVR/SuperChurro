<template>
  <AppLayout title="Cocina">
    <!-- <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Cocina</h2>
    </template> -->

    <div class="flex flex-col space-x-3 md:flex-row justify-end md:mr-10 mr-4 mt-10 mx-4">
      <IconInput @keyup.enter="handleSearch" v-model="inputSearch" class="md:w-1/3" inputPlaceholder="Buscar producto"
        inputType="text">
        <el-tooltip content="Buscar producto" placement="top">
          <i class="fa-solid fa-magnifying-glass"></i>
        </el-tooltip>
      </IconInput>

      <div class="text-right my-3">
        <Link :href="route('warehouse-movements.create')">
        <PrimaryButton>Registrar entrada / salida</PrimaryButton>
        </Link>
      </div>
    </div>

    <div class="border border-gray3 rounded-md inline-block mx-4 p-3 my-2">
      <p class="text-gray-800 font-bold text-left mb-2">Colaborador(es) en cocina</p>
      <div class="">
        <p class="text-sm" v-for="employee in employees" :key="employee.id">
          <i class="fa-regular fa-circle-user"></i>
          {{ employee.name }}
        </p>
        <p v-if="Array.isArray(employees)" class="text-gray-500 text-xs text-center col-span-full mb-8">No hay
          colaboradores
          en cocina</p>
      </div>
    </div>

    <div>
      <div class="globe-container flex-col">
        <div v-for="product_id in filteredTableData" :key="product_id" class="globe hover:bg-gray-200 cursor-pointer">
          <Link :href="route('warehouse-movements.show-product-record', product_id)">
          <figure v-if="products.find(product => product.id == product_id)?.media.length > 0"
            class="justify-center pt-2">
            <img :src="products.find(product => product.id == product_id)?.media[0]?.original_url"
              alt="Imagen del producto" class="rounded-lg h-32 mx-auto">
          </figure>
          <div class="globe-title !justify-center pb-2">
            {{ products.find(product => product.id == product_id)?.name }}
          </div>
          <div class="flex justify-center items-center"
            :class="warehouse.products[product_id] <= products.find(product => product.id == product_id).low_stock ? 'text-red-500' : 'text-green-500'">
            <span>{{ warehouse.products[product_id] }} {{ products.find(product => product.id == product_id).unit?.name
              }}</span>
            <i v-if="warehouse.products[product_id] <= products.find(product => product.id == product_id).low_stock"
              class="fa-solid fa-triangle-exclamation ml-2 text-xs text-red-500"></i>
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
import IconInput from "@/Components/IconInput.vue";
import { Link } from "@inertiajs/inertia-vue3";

export default {
  data() {
    return {
      search: "",
      inputSearch: "",
    };
  },
  components: {
    AppLayout,
    PrimaryButton,
    SecondaryButton,
    IconInput,
    ThirthButton,
    Link
  },
  props: {
    warehouse: Object,
    products: Array,
    employees: Object,
  },
  methods: {
    handleSearch() {
      this.search = this.inputSearch;
    },
  },
  computed: {
    filteredTableData() {
      if (!this.search) {
        // Si no hay término de búsqueda, devuelve todos los IDs
        return this.products.filter(product => product.id != 29).map(product => product.id);
      } else {
        // Filtra los productos por nombre y devuelve los IDs
        return this.products
          .filter(product => product.name.toLowerCase().includes(this.search.toLowerCase()) && product.id != 29)
          .map(filteredProduct => filteredProduct.id);
      }
    },
  },
};
</script>
