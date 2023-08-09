<template>
  <AppLayout title="Carrito">
    <!-- <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Carrito</h2>
    </template> -->
    <div class="md:mx-10 mx-1">
      <div class="md:flex justify-between items-center space-y-5 my-9">
        <Link :href="route('sales-to-employees.create')">
          <ThirthButton class="">Venta a empleado / Cortesías</ThirthButton>
        </Link>
        <div
          class="flex space-x-3 md:flex-row justify-between md:justify-end md:mr-10 items-center"
        >
          <IconInput
            v-model="s"
            class="md:w-2/3 w-1/2"
            inputPlaceholder="Buscar producto"
            inputType="text"
          >
            <el-tooltip content="Razon social" placement="top">
              <i class="fa-solid fa-magnifying-glass"></i>
            </el-tooltip>
          </IconInput>
          <!-- <InputError :message="form.errors.business_name" /> -->

          <div>
            <Link :href="route('product-request.create')">
              <ThirthButton class="">Solicitar mercancía</ThirthButton>
            </Link>
          </div>
        </div>
      </div>

      <div
        class="md:grid grid-cols-2 my-7 border border-gray-300 p-4 rounded-lg"
      >
        <div class="">
          <p class="text-gray-700 text-center ml-3 my-3 font-semibold">
            Colaboradores en carrito
          </p>
          <div class="grid grid-cols-2 lg:grid-cols-4">
            <p v-for="employee in employees" :key="employee.id" class="mx-3">
              <i class="fa-solid fa-user text-gray-700"></i>
              <span class="text-primary">{{ employee.name }}</span>
            </p>
            <p
              v-if="Array.isArray(employees)"
              class="text-gray-500 text-xs text-center col-span-full mt-4"
            >
              No hay colaboradores en carrito
            </p>
          </div>
        </div>

        <div class="mb-4 mt-14 md:my-1 text-center">
          <p class="text-gray-700 ml-3 my-3 font-semibold">Cortes</p>

          <ul class="o">
            <li class="flex items-center justify-center space-x-4">
              <p class="text-primary">Primer turno</p>
              <i class="fa-solid fa-check text-green-600"></i>
              <i class="fa-solid fa-minus text-gray-700"></i>
            </li>
            <li class="flex items-center justify-center space-x-4">
              <p class="text-primary">Segundo turno</p>
              <i class="fa-solid fa-check text-green-600"></i>
              <i class="fa-solid fa-minus text-gray-700"></i>
            </li>
          </ul>

          <div class="globe-container flex-col">
            <div v-for="sale in sales" :key="sale.id" class="globe">
              <p class="text-sm flex justify-between">
                {{ sale }}
                <i class="fa-solid fa-circle-check text-lg text-green-600"></i>
              </p>
            </div>
            <p
              v-if="!sales.length"
              class="text-center text-xs text-gray-500 col-span-full"
            >
              No se ha registrado ningún corte
            </p>
          </div>
          <Link :href="route('sales.create')">
            <PrimaryButton class="mt-2">Hacer corte</PrimaryButton>
          </Link>
        </div>
      </div>

      <div>
        <p class="text-gray-700 text-left mx-4 my-3 font-semibold flex items-center">
          Solicitudes de mercancía (Hoy)
          <Link :href="route('product-request.history')">
            <PrimaryButton class="md:ml-7 ml-2" v-if="$page.props.user.is_admin"
              >Ver historial</PrimaryButton
            >
          </Link>
        </p>

        <div class="globe-container flex-col">
          <Link
            :href="route('product-request.show', request)"
            v-for="request in requests"
            :key="request.id"
            class="globe hover:bg-gray-200 cursor-pointer"
          >
            <div class="globe-title !justify-between pb-2">
              <span class="text-gray-500"
                ><i class="fa-solid fa-user mr-1"></i>
                {{ request.user.name }}</span
              >
              <!-- <small class="text-gray-400">{{ timeFormatter(request.created_at) }}</small> -->
            </div>
            <div class="flex justify-between items-center">
              <span>
                {{ request.products.length }} producto(s) - (click para
                ver)</span
              >
            </div>
          </Link>
          <p
            v-if="!requests.length"
            class="text-center text-xs text-gray-500 col-span-full"
          >
            No hay solicitudes aún
          </p>
        </div>
      </div>

      <div class="mt-20">
        <div class="flex items-center justify-between">
          <p class="text-gray-700 text-left ml-3  font-semibold">
            Inventario Actual
          </p>
          <div class="flex justify-center">
            <Link :href="route('cart.remove-products')">
              <ThirthButton>Remover mercancía</ThirthButton>
            </Link>
          </div>
        </div>

        <div class="globe-container flex-col">
          <div
            v-for="cart_product_id in Object.keys(cart_products[0].products)"
            :key="cart_product_id"
            class="globe"
          >
            <div class="globe-title pb-2">
              {{
                products.find((product) => product.id == cart_product_id).name
              }}
            </div>
            <div class="flex justify-between items-center">
              <span
                >{{ cart_products[0].products[cart_product_id] }}
                {{
                  products.find((product) => product.id == cart_product_id).unit
                    .name
                }}</span
              >
            </div>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import { Link } from "@inertiajs/inertia-vue3";
import ConfirmationModal from "@/Components/ConfirmationModal.vue";
import ThirthButton from "@/Components/ThirthButton.vue";
import IconInput from "@/Components/IconInput.vue";

export default {
  data() {
    return {};
  },
  components: {
    AppLayout,
    SecondaryButton,
    Link,
    ConfirmationModal,
    ThirthButton,
    IconInput,
    PrimaryButton,
  },
  props: {
    products: Array,
    requests: Array,
    cart_products: Object,
    employees: Object,
    sales: Array,
  },
  methods: {
    timeFormatter(timestamp) {
      const date_n_time = timestamp.split("T");
      return " a las " + date_n_time[1].split(".")[0];
    },
  },
};
</script>
