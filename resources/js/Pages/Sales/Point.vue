<template>
  <!-- 
    AppLayout: Asumimos que este es el layout principal.
    Cambiamos el fondo general a un gris muy claro (bg-gray-50) para un look más suave.
  -->
  <AppLayout title="Punto de venta" class="bg-gray-50">
    <!-- 
      Alertas de Conexión y Sincronización:
      - Aumentamos el padding (px-4 py-3).
      - Usamos esquinas redondeadas más pronunciadas (rounded-lg).
      - Añadimos una sombra sutil (shadow-md).
      - Estandarizamos los colores: bg-gray-900 para offline, bg-blue-100/text-blue-800 para "info" (syncing).
    -->
    <div v-if="!isOnline"
      class="w-2/3 ml-auto mt-3 rounded-lg shadow-md px-4 py-3 bg-gray-900 text-white text-sm">
      <p class="text-base flex items-center space-x-3 font-semibold">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="-0.855 -0.855 24 24"
          id="Wifi-Disabled--Streamline-Core" height="16" width="16">
          <desc>Wifi Disabled Streamline Icon: https://streamlinehq.com</desc>
          <g id="wifi-disabled--wireless-wifi-internet-server-network-disabled-off-offline-connection">
            <path id="Vector 2432" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
              d="m0.7960714285714285 0.7960714285714285 20.697857142857142 20.697857142857142" stroke-width="2.1">
            </path>
            <path id="Vector" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
              d="M11.145 21.09573364285714c1.151915357142857 0 2.0857071428571428 -0.9337917857142857 2.0857071428571428 -2.0857071428571428s-0.9337917857142857 -2.0857071428571428 -2.0857071428571428 -2.0857071428571428c-1.1518994357142855 0 -2.0857071428571428 0.9337917857142857 -2.0857071428571428 2.0857071428571428s0.9338077071428571 2.0857071428571428 2.0857071428571428 2.0857071428571428Z"
              stroke-width="2.1"></path>
            <path id="Vector_2" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
              d="M7.212454907142857 14.32936532142857c0.5177170928571428 -0.53150505 1.1366626285714285 -0.9539483142857142 1.820281007142857 -1.2423809142857143"
              stroke-width="2.1"></path>
            <path id="Vector_3" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
              d="M3.757441221428571 11.6385006c0.9691532785714285 -0.9748053857142858 2.0014509428571428 -1.5694389 2.0014509428571428 -1.5694389"
              stroke-width="2.1"></path>
            <path id="Vector_4" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
              d="M8.83744367142857 8.825040878571428s0.9409086642857143 -0.26260804285714284 2.3155170428571425 -0.26260804285714284c1.3745924571428572 0 2.7356357785714285 0.2717628642857143 4.004828378571428 0.7996378285714286 1.2691448357142856 0.5278749642857142 2.4215378357142856 1.3014812571428571 3.390675192857143 2.276286642857143"
              stroke-width="2.1"></path>
            <path id="Vector_5" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
              d="M5.543936957142857 5.503400999999999c1.775701007142857 -0.7357929 3.678980421428571 -1.1145159214285714 5.601094885714286 -1.1145159214285714 1.9221144642857142 0 3.8253938785714285 0.3787230214285714 5.601126728571429 1.1145159214285714 1.7757169285714285 0.7357929 3.389035285714286 1.8142308642857141 4.74777 3.1737298071428572"
              stroke-width="2.1"></path>
            <path id="Vector_6" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
              d="M0.7960714285714285 8.677305942857142c0.57410124 -0.5744133 1.1653052785714284 -1.0461015428571427 1.87291725 -1.5767946"
              stroke-width="2.1"></path>
          </g>
        </svg>
        <span>Sin conexión a Internet</span>
      </p>
      <p class="text-sm mt-1">
        Las ventas que realices se guardan en el dispositivo que estas utilizando y
        luego se transfieren automáticamente a la nube cuando tengas internet.
        ¡Así nunca perderán información!. <br>
        <b class="font-semibold">Es importante que no recargues la página para poder registrar ventas</b>
      </p>
    </div>
    <div v-if="syncingData || syncingIDB"
      class="w-2/3 ml-auto mt-3 rounded-lg shadow-md px-4 py-3 bg-blue-100 text-blue-800 text-sm">
      <p class="text-base flex items-center space-x-3 font-semibold">
        <svg class="animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
          id="Rotate-Right--Streamline-Sharp" height="16" width="16">
          <desc>Rotate Right Streamline Icon: https://streamlinehq.com</desc>
          <g id="rotate-right">
            <path id="Vector 2754" stroke="currentColor" d="M20.2047 0.5135V4.8893H15.8289" stroke-width="2"></path>
            <path id="Ellipse 1206" stroke="currentColor"
              d="M20.2047 4.764C18.2001 2.4929 15.2674 1.0605 12.0001 1.0605C5.9583 1.0605 1.0605 5.9583 1.0605 12C1.0605 16.194 3.4207 19.8367 6.8853 21.6726"
              stroke-width="2"></path>
            <path id="Ellipse 1207" stroke="currentColor"
              d="M9.1081 22.5533C10.0293 22.8051 10.999 22.9395 11.9999 22.9395C13.4231 22.9395 14.7826 22.6678 16.0297 22.1734"
              stroke-width="2"></path>
            <path id="Ellipse 1208" stroke="currentColor"
              d="M17.7655 21.2986C19.2694 20.3641 20.5299 19.0749 21.4301 17.548" stroke-width="2"></path>
            <path id="Ellipse 1209" stroke="currentColor" d="M22.9395 12C22.9395 13.2879 22.717 14.5237 22.3083 15.6713"
              stroke-width="2"></path>
          </g>
        </svg>
        <span>Sincronizando datos</span>
      </p>
      <p class="text-sm mt-1">
        Por favor, evita recargar la página y espera a que los datos se carguen a la nube.
      </p>
    </div>

    <!-- 
      Contenedor Principal:
      - Aumentamos el padding general (px-4 lg:px-6 py-4).
    -->
    <div class="px-4 lg:px-6 py-4 h-[85vh]">
      <section class="h-[60%] overflow-auto">
        <!-- header botones -->
        <div class="md:flex justify-between items-center mb-4">
          <!-- Título: Más grande y con más peso -->
          <h1 class="font-bold text-2xl text-gray-900">Registrar venta</h1>
          <!-- 
            Dropdown:
            - Eliminamos el borde redondeado del div contenedor.
            - Convertimos el <p> interior en un botón moderno con sombra, borde sutil y estado hover.
           -->
          <div class="inline-block mt-2 md:mt-0">
            <el-col :span="3"> <!-- Mantenemos esta estructura de Element UI -->
              <el-dropdown trigger="click">
                <p
                  class="flex items-center justify-center px-4 py-2 bg-white border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 cursor-pointer focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                  <span>Acciones</span>
                  <i class="fa-solid fa-angle-down text-xs ml-2"></i>
                </p>
                <template #dropdown>
                  <el-dropdown-menu>
                    <el-dropdown-item @click="$inertia.visit(route('product-request.create'))">
                      Solicitar mercancía
                    </el-dropdown-item>
                    <el-dropdown-item @click="$inertia.visit(route('consumable-request.create'))">
                      Solicitar consumible
                    </el-dropdown-item>
                    <el-dropdown-item @click="$inertia.visit(route('sales-to-employees.create'))">
                      Ventas a empleado / Cortesías</el-dropdown-item>
                  </el-dropdown-menu>
                </template>
              </el-dropdown>
            </el-col>
          </div>
        </div>
        <!-- cuerpo de la pagina -->
        <div class="md:flex md:space-x-6 mt-2">
          <section class="md:w-[70%]">
            <!-- 
              Pestañas:
              - Las envolvemos en una "tarjeta" (bg-white, rounded-xl, shadow-sm) para darles definición.
            -->
            <div class="bg-white rounded-xl shadow-sm p-4 h-full">
              <el-tabs v-model="editableTabsValue" type="card" class="demo-tabs">
                <el-tab-pane v-for="tab in editableTabs" :key="tab.name" :label="tab.title" :name="tab.name">
                  <el-popconfirm v-if="tab.saleProducts.length" confirm-button-text="Si" cancel-button-text="No"
                    icon-color="#C30303" title="Se eliminará todo el registro de productos ¿Deseas continuar?"
                    @confirm="clearTab()">
                    <template #reference>
                      <!-- Botón Limpiar: Estilo de "peligro" más estándar y suave -->
                      <ThirthButton
                        class="!text-red-600 !border-red-600 hover:!bg-red-50 !py-1 !px-2 mb-2 !text-xs !rounded-md"><i
                          class="fa-regular fa-trash-can mr-2"></i> Limpiar registro</ThirthButton>
                    </template>
                  </el-popconfirm>
                  <SaleTable @delete-product="deleteProduct" :saleProducts="tab.saleProducts" :saleType="saleType" />
                </el-tab-pane>
              </el-tabs>
            </div>
          </section>
          <!-- seccion de desgloce de montos -->
          <section class="md:w-[30%] space-y-4"> <!-- Añadimos space-y-4 para separar las tarjetas -->
            <!-- 
              Buscador de productos:
              - Input: Esquinas más redondeadas (rounded-lg), borde estándar (border-gray-300), y foco moderno.
              - Icono: Centrado verticalmente y color más sutil (text-gray-400).
            -->
            <div class="relative">
              <input v-model="searchQuery" @focus="searchFocus = true" @blur="handleBlur" @input="searchProducts"
                ref="searchInput"
                class="input w-full pl-10 pr-4 py-2 rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm"
                placeholder="Buscar código o nombre de producto" type="search">
              <i
                class="fa-solid fa-magnifying-glass text-sm text-gray-400 absolute top-1/2 -translate-y-1/2 left-3"></i>
              <!-- 
                Resultados de la búsqueda:
                - Sombra más pronunciada (shadow-lg) y esquinas (rounded-md).
                - Hover con color primario sutil (hover:bg-indigo-50).
              -->
              <div v-if="searchFocus && searchQuery"
                class="absolute mt-1 bg-white border border-gray-200 rounded-md shadow-lg w-full z-50 max-h-48 overflow-auto">
                <ul v-if="productsFound?.length > 0 && !loading">
                  <li @click="selectProductFromList(product)" v-for="(product, index) in productsFound" :key="index"
                    class="hover:bg-indigo-50 cursor-pointer text-sm px-4 py-2 flex space-x-2">
                    <span class="w-4/5 font-medium text-gray-800">{{ product.name }}</span>
                    <span v-if="product.code" class="w-1/5 text-xs text-gray-500">
                      {{ product.code }}
                    </span>
                  </li>
                </ul>
                <p v-else-if="!loading" class="text-center text-sm text-gray-500 px-5 py-3">
                  No se encontraron coincidencias
                </p>
                <!-- estado de carga -->
                <div v-if="loading" class="flex justify-center items-center py-10">
                  <i class="fa-solid fa-square fa-spin text-4xl text-indigo-600"></i> <!-- Color primario -->
                </div>
              </div>
            </div>
            <!-- 
              Detalle de producto encontrado:
              - Convertido en "tarjeta" (bg-white, rounded-xl, shadow-sm).
              - Bordes sutiles (border-gray-200).
              - Mejoramos la tipografía y el color de precio (text-green-600).
              - Botón "Agregar": Ancho completo (w-full) y esquinas (rounded-lg).
            -->
            <div class="border border-gray-200 bg-white rounded-xl shadow-sm p-4">
              <div class="relative" v-if="productFoundSelected">
                <i @click="productFoundSelected = null"
                  class="fa-solid fa-xmark cursor-pointer size-6 rounded-full flex items-center justify-center absolute -top-1 -right-1 text-gray-600 hover:bg-gray-100"></i>
                <figure class="h-32"> <!-- Un poco más de altura para la imagen -->
                  <img v-if="productFoundSelected.imageUrl" :src="productFoundSelected.imageUrl"
                    :alt="productFoundSelected.name" class="object-contain h-32 mx-auto">
                  <p v-else class="text-center text-sm text-gray-400 pt-12 px-8">Este producto no tiene imagen
                    registrada
                  </p>
                </figure>
                <div class="flex justify-between items-center mt-3 mb-4">
                  <p class="font-semibold text-lg text-gray-900">{{ productFoundSelected.name }}</p>
                  <p class="text-green-600 font-bold text-lg">${{ productFoundSelected.public_price }}</p>
                </div>
                <div class="flex justify-between items-center">
                  <p class="text-gray-600">Cantidad</p>
                  <el-input-number v-model="quantity" :min="0" :precision="2" />
                </div>
                <div class="text-center mt-4">
                  <PrimaryButton @click="addSaleProduct(productFoundSelected); productFoundSelected = null"
                    class="w-full !rounded-lg !py-3 !text-base !bg-indigo-600 hover:!bg-indigo-700"
                    :disabled="quantity == 0">
                    Agregar
                  </PrimaryButton>
                </div>
              </div>
              <p v-else class="text-center text-gray-500 text-base py-12"> <!-- Más padding vertical -->
                Busca el producto
                <i class="fa-regular fa-hand-point-up ml-3"></i>
              </p>
            </div>

            <!-- 
              Total por cobrar:
              - Convertido en "tarjeta".
              - Tipografía de "Total" más grande y clara.
              - Botón "Cobrar": Ancho completo y color verde (bg-green-600).
            -->
            <div v-if="editableTabs[editableTabsValue - 1]?.saleProducts?.length"
              class="border border-gray-200 bg-white rounded-xl shadow-sm p-4">
              <div v-if="!editableTabs[this.editableTabsValue - 1]?.paying">
                <div class="flex items-center justify-between text-xl mx-2">
                  <p class="font-bold text-gray-900">Total</p>
                  <p v-if="(calculateTotal() - editableTabs[this.editableTabsValue - 1].discount) < 0"
                    class="text-red-600 text-sm">El descuento es más grande que el total</p>
                  <p v-else class="text-gray-500">$ <strong class="ml-2 font-bold text-gray-900 text-2xl">{{
                    (calculateTotal() -
                      editableTabs[this.editableTabsValue
                        - 1].discount)?.toLocaleString('en-US', {
                          minimumFractionDigits: 2
                        }) }}</strong></p>
                </div>
                <div class="text-center mt-3">
                  <PrimaryButton @click="receive()"
                    :disabled="editableTabs[this.editableTabsValue - 1]?.saleProducts?.length == 0 || (calculateTotal() - editableTabs[this.editableTabsValue - 1].discount) < 0"
                    class="w-full !rounded-lg !py-3 !text-base !bg-green-600 hover:!bg-green-700 disabled:!bg-gray-400">
                    Cobrar</PrimaryButton>
                </div>
              </div>

              <!-- cobrando -->
              <div v-else class="space-y-3">
                <p class="text-gray-600 text-center text-xl">Total $ <strong
                    class="font-bold text-gray-900 text-2xl">{{ (calculateTotal() -
                      editableTabs[this.editableTabsValue - 1].discount)?.toLocaleString('en-US', {
                        minimumFractionDigits: 2
                      }) }}</strong>
                </p>
                <div class="flex items-center justify-between">
                  <p class="font-medium">Entregado</p>
                  <input v-model="editableTabs[this.editableTabsValue - 1].moneyReceived" @keydown.enter="store"
                    type="number" class="input !rounded-lg w-1/2 !text-right" ref="receivedInput" placeholder="$0.00">
                </div>
                <div class="flex items-center justify-between text-lg">
                  <p class="font-medium">Cambio</p>
                  <p class="font-bold"
                    v-if="(calculateTotal() - editableTabs[this.editableTabsValue - 1].discount) <= editableTabs[this.editableTabsValue - 1]?.moneyReceived">
                    ${{
                      (editableTabs[this.editableTabsValue - 1]?.moneyReceived - (calculateTotal() -
                        editableTabs[this.editableTabsValue - 1].discount)).toLocaleString('en-US', {
                          minimumFractionDigits: 2
                        }) }}</p>
                </div>
                <p v-if="((calculateTotal() - editableTabs[this.editableTabsValue - 1].discount) > editableTabs[this.editableTabsValue - 1]?.moneyReceived) && editableTabs[this.editableTabsValue - 1].moneyReceived"
                  class="text-sm text-red-600 text-center">La cantidad es insuficiente.</p>
                <div class="flex space-x-2 justify-end pt-2">
                  <CancelButton @click="editableTabs[this.editableTabsValue - 1].paying = false" class="!rounded-lg">
                    Cancelar</CancelButton>
                  <PrimaryButton @click="store" class="!rounded-lg !bg-indigo-600 hover:!bg-indigo-700">Aceptar
                  </PrimaryButton>
                </div>
              </div>
            </div>
          </section>
        </div>
      </section>
      <!-- 
        lista de productos:
        - Borde superior más sutil (border-t border-gray-200).
        - Título más grande.
        - Contenedor de grid como "tarjeta" (bg-white, rounded-xl, shadow-sm, p-3).
        - Botones de producto: Bordes suaves (border-gray-200), estados hover y focus modernos (hover:shadow-md, hover:border-indigo-300, focus:ring-2).
      -->
      <section class="border-t border-gray-200 h-[40%] pt-4 mt-4">
        <h1 class="ml-1 text-lg font-semibold text-gray-800">Selecciona los productos</h1>
        <div
          class="bg-white border mt-2 p-3 rounded-xl shadow-sm border-gray-200 grid grid-cols-4 md:grid-cols-6 gap-3 overflow-auto h-[92%]">
          <button @click="addSaleProduct(item)" type="button" v-for="(item, index) in allProducts" :key="index"
            class="border border-gray-200 rounded-lg p-2 text-center transition-all duration-150 hover:shadow-md hover:border-indigo-300 hover:bg-indigo-50 focus:outline-none focus:ring-2 focus:ring-indigo-500">
            <h2 class="text-xs text-center font-medium text-gray-700 h-8">{{ item.name }}</h2>
            <figure class="flex items-center justify-center h-16 mt-1"> <!-- Altura de imagen aumentada -->
              <img v-if="item.image_url" :src="item.image_url" :alt="item.name" class="object-contain h-16 mx-auto">
              <svg v-else xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-9 text-gray-400"> <!-- Color de placeholder más oscuro -->
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
              </svg>
            </figure>
          </button>
        </div>
      </section>
    </div>

    <!-- 
      Modal:
      - Los estilos de los botones (CancelButton, PrimaryButton) se heredarán si los has modernizado globalmente.
      - Si no, puedes añadir !rounded-lg aquí también.
    -->
    <DialogModal :show="showCourtesyModal" @close="showCourtesyModal = false">
      <template #title>
        <h1 class="text-xl font-semibold text-gray-900">Cortesias a "viene viene"</h1>
      </template>
      <template #content>
        <form @submit.prevent="storeCourtesies" class="space-y-3 p-2">
          <div class="flex items-center space-x-6">
            <span class="text-sm text-gray-600 w-1/4">Bolis</span>
            <el-input-number v-model="courtesyForm.bolis" :min="0" :max="10" />
          </div>
          <div class="flex items-center space-x-6">
            <span class="text-sm text-gray-600 w-1/4">Botana</span>
            <el-input-number v-model="courtesyForm.botana" :min="0" :max="10" />
          </div>
        </form>
      </template>
      <template #footer>
        <div class="space-x-2">
          <CancelButton @click="showCourtesyModal = false" :disabled="storingCourtesies" class="!rounded-lg">Cancelar
          </CancelButton>
          <PrimaryButton @click="storeCourtesies" :disabled="storingCourtesies"
            class="!rounded-lg !bg-indigo-600 hover:!bg-indigo-700">Registrar cortesias</PrimaryButton>
        </div>
      </template>
    </DialogModal>
  </AppLayout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import ConfirmationModal from '@/Components/ConfirmationModal.vue';
import DialogModal from '@/Components/DialogModal.vue';
import ThirthButton from '@/Components/ThirthButton.vue';
import InputLabel from "@/Components/InputLabel.vue";
import CancelButton from "@/Components/CancelButton.vue";
import SaleTable from '@/Components/MyComponents/Point/SaleTable.vue';
import InputError from "@/Components/InputError.vue";
import Modal from "@/Components/Modal.vue";
import { useForm } from "@inertiajs/inertia-vue3";
import axios from 'axios';
import { getItemByPartialAttributes, getItemByAttributes, getAll, syncIDBProducts } from '@/dbService.js';
import { format } from 'date-fns';

export default {
  data() {
    const form = useForm({
      cashRegisterMovementType: null, //que tipo de movimiento es
      registerAmount: null, //Dinero ingresado o sacado de caja
      registerNotes: null, //notas al entrar o sacar dinero
    });

    const courtesyForm = useForm({
      bolis: 0,
      botana: 0,
    });

    return {
      form,
      courtesyForm,
      saleType: 'publico',
      showCourtesyModal: false,
      showCashRegisterMoney: false,
      allProducts: [],
      // cargas
      loading: false, //cargando la busqueda de productos
      storingCourtesies: false,
      storeProcessing: false, //cargando store de venta
      scanning: false, //cargando la busqueda de productos por escaner
      syncingIDB: false,
      // buscador
      scannerQuery: null, //input para scanear el codigo de producto
      searchQuery: null, //buscador
      searchFocus: false, //buscador
      productsFound: null, //buscador
      productSelected: null, //producto escaneado agergado a la lista de compras
      productFoundSelected: null, //producto seleccionado desde barra de busqueda
      quantity: 1, //cantidad para agregar del producto escaneado o buscado
      editableTabsValue: "1", //tab seleccionado - componente de tabs
      editableTabs: [ //Informacion del tab - componente de tabs
        {
          title: "Registro 1",
          name: "1",
          saleProducts: [],
          paying: false,
          discount: 0,
          moneyReceived: null,
        },
        {
          title: "Registro 2",
          name: "2",
          saleProducts: [],
          paying: false,
          discount: 0,
          moneyReceived: null,
        },
        {
          title: "Registro 3",
          name: "3",
          saleProducts: [],
          paying: false,
          discount: 0,
          moneyReceived: null,
        },
      ],
      // conexion a internet
      isOnline: navigator.onLine, // Verificar el estado de conexión al cargar el componente
      syncingData: false,
    }
  },
  components: {
    AppLayout,
    ConfirmationModal,
    PrimaryButton,
    CancelButton,
    ThirthButton,
    InputError,
    InputLabel,
    SaleTable,
    Modal,
    DialogModal,
  },
  props: {
    products: Array,
  },
  methods: {
    addSaleProduct(product) {
      //revisa si el producto a agregar ya esta dentro del arreglo
      const existingIndex = this.editableTabs[this.editableTabsValue - 1].saleProducts.findIndex(sale => {
        return sale.product.id == product.id;
      });
      if (existingIndex !== -1) {
        this.editableTabs[this.editableTabsValue - 1].saleProducts[existingIndex] = {
          ...this.editableTabs[this.editableTabsValue - 1].saleProducts[existingIndex],
          quantity: this.editableTabs[this.editableTabsValue - 1].saleProducts[existingIndex].quantity + this.quantity
        };
      } else {
        // Si el producto no existe, agrégalo al array
        this.editableTabs[this.editableTabsValue - 1].saleProducts.push({
          product: product,
          quantity: this.quantity
        });
      }
      this.scannerQuery = null;
      this.quantity = 1;
      this.scanning = false;

      // indicar al navegador mediante el local storage que hay proceso pendiente
      const pendentProcess = JSON.parse(localStorage.getItem('pendentProcess'));
      if (!pendentProcess) {
        // guardar el valor en el localStorage
        localStorage.setItem('pendentProcess', true);
      }
    },
    selectProductFromList(product) {
      // crear link virtual de imagen blob si es que tiene imagen el producto
      if (product.image && !product.imageUrl) {
        const imageUrl = URL.createObjectURL(product.image);
        product = { ...product, imageUrl };
      }

      this.productFoundSelected = product;
      this.searchQuery = null;
    },
    deleteProduct(productId) {
      const indexToDelete = this.editableTabs[this.editableTabsValue - 1].saleProducts.findIndex(sale => sale.product.id === productId);
      this.editableTabs[this.editableTabsValue - 1].saleProducts.splice(indexToDelete, 1);
    },
    clearTab() {
      this.searchQuery = null;
      this.scannerQuery = null;
      this.searchFocus = false;
      this.productsFound = null;
      this.productSelected = null;
      this.editableTabs[this.editableTabsValue - 1].saleProducts = [];
      this.editableTabs[this.editableTabsValue - 1].paying = false;
      this.editableTabs[this.editableTabsValue - 1].discount = 0;
      this.editableTabs[this.editableTabsValue - 1].moneyReceived = null;
      // this.inputFocus();
    },
    calculateTotal() {
      // Suma de los productos del precio y la cantidad para cada elemento en saleProducts
      const total = this.editableTabs[this.editableTabsValue - 1]?.saleProducts?.reduce((accumulator, sale) => {
        return accumulator + sale.product.public_price * sale.quantity;
      }, 0);

      return total;
    },
    handleBlur() {
      // Introducir un retraso para dar tiempo al evento click de ejecutarse antes del blur
      setTimeout(() => {
        this.searchFocus = false;
      }, 100);
    },
    receive() {
      this.editableTabs[this.editableTabsValue - 1].paying = true;
      this.receivedInputFocus();
    },
    receivedInputFocus() {
      this.$nextTick(() => {
        this.$refs.receivedInput.focus(); // Enfocar el input de código cuando se abre el modal
      });
    },
    handleOnline() {
      const storedData = JSON.parse(localStorage.getItem('sales')) || [];
      this.isOnline = true;
      if (storedData.length) {
        this.syncData();
      }
    },
    handleOffline() {
      this.isOnline = false;
    },
    saveToLocalStorage() {
      // Obtén los datos actuales almacenados en el Local Storage
      let storedData = JSON.parse(localStorage.getItem('sales')) || [];

      const dataToStore = {
        created_at: format(new Date(), 'yyyy-MM-dd HH:mm'),
        saleProducts: this.editableTabs[this.editableTabsValue - 1]?.saleProducts
      };

      // Agrega el nuevo objeto al arreglo
      storedData.push(dataToStore);

      // Vuelve a guardar el arreglo en el Local Storage
      localStorage.setItem('sales', JSON.stringify(storedData));
      this.form.reset();

      this.$notify({
        title: 'Correcto',
        message: 'Se registró la venta en almacenamiento local. Cuando tengas conexión a internet se guardarán en la nube',
        type: 'success'
      });
    },
    async syncData() {
      this.syncingData = true;
      try {
        const localStorageItems = JSON.parse(localStorage.getItem('sales'));
        const response = await axios.post(route('sales.sync-localstorage'), {
          sales: localStorageItems,
        });

        if (response.status === 200) {
          // eliminar datos en almacenamiento local
          localStorage.removeItem('sales');
        }
      } catch (error) {
        console.log(error);
      } finally {
        this.syncingData = false;
      }
    },
    async store() {
      if (!this.storeProcessing) {
        this.storeProcessing = true;
        if (this.isOnline) {
          try {
            const response = await axios.post(route('sales.store'), {
              saleType: this.saleType,
              saleProducts: this.editableTabs[this.editableTabsValue - 1]?.saleProducts
            });
            if (response.status === 200) {
              this.$notify({
                title: "Correcto",
                text: "Se ha registrado la venta con éxito!",
                type: "success",
              });
              this.clearTab();

              // resetear variable de local storage a false
              localStorage.setItem('pendentProcess', false);
            }
          } catch (error) {
            console.log(error);
          } finally {
            this.storeProcessing = false;
          }
        } else {
          this.saveToLocalStorage();
          this.storeProcessing = false;
          this.clearTab();
        }
      }
    },
    async searchProducts() {
      try {
        this.productsFound = await getItemByPartialAttributes('products', { name: this.searchQuery, code: this.searchQuery });
      } catch (error) {
        console.log(error);
      }
    },
    async getProductByCode() {
      this.scanning = true;

      if (this.scannerQuery == 999) {
        this.showCourtesyModal = true;
        this.scannerQuery = null;
        this.scanning = false;
        return;
      }

      let foundProducts = await getItemByAttributes('products', { code: this.scannerQuery });
      let productScaned = foundProducts[0];

      // si no se encontró el producto escaneado aparece un mensaje y no busca en la bd para no tardar más
      if (productScaned != null) {
        // agregar la imagen al producto si es que no la tiene
        if (productScaned.image && !productScaned.imageUrl) {
          const imageUrl = URL.createObjectURL(productScaned.image);
          productScaned = { ...productScaned, imageUrl };
        }

        this.addSaleProduct(productScaned);
      } else {
        this.$notify({
          title: "Producto no encontrado",
          message: "El producto escaneado no esta registrado en la base de datos",
          type: "warning"
        });
        this.scannerQuery = null;
        this.scanning = false;
      }
    },
    async storeCourtesies() {
      this.storingCourtesies = true;

      this.courtesyForm.post(route('sales-to-employees.store-special-courtesies'), {
        onSuccess: () => {
          this.$notify({
            title: "Cortesías registradas",
            message: "",
            type: "success"
          });

          this.courtesyForm.reset();
          this.showCourtesyModal = false;
        },
        onFinish: () => {
          this.storingCourtesies = false;
        }
      });
    },
  },
  async mounted() {
    this.syncingIDB = true;
    await syncIDBProducts();
    this.syncingIDB = false;

    // resetear variable de local storage a false
    localStorage.setItem('pendentProcess', false);

    // Agregar escuchadores de eventos online/offline
    window.addEventListener('online', this.handleOnline);
    window.addEventListener('offline', this.handleOffline);

    // obtener todos los productos de inexedDB
    this.allProducts = await getAll('products');
  },
  beforeUnmount() {
    // Eliminar los escuchadores de eventos al desmontar el componente
    window.removeEventListener('online', this.handleOnline);
    window.removeEventListener('offline', this.handleOffline);
  },
}
</script>
