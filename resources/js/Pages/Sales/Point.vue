<template>
  <AppLayout title="Punto de venta">
    <div v-if="!isOnline" class="w-2/3 ml-auto mt-3 rounded-s-[5px] px-4 py-1 bg-[#232323] text-white text-xs">
      <p class="text-sm flex items-center space-x-3 font-semibold">
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
      <p class="text-xs">
        Las ventas que realices se guardan en el dispositivo que estas utilizando y
        luego se transfieren automáticamente a la nube cuando tengas internet.
        ¡Así nunca perderán información!. <br>
        <b>Es importante que no recargues la página para poder registrar ventas</b>
      </p>
    </div>
    <div v-if="syncingData" class="w-2/3 ml-auto mt-3 rounded-s-[5px] px-4 py-1 bg-secondary text-[#333333] text-xs">
      <p class="text-sm flex items-center space-x-3 font-semibold">
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
      <p class="text-xs">
        Por favor, evita recargar la página y espera a que los datos se carguen a la nube.
      </p>
    </div>
    <div class="px-1 lg:px-6 py-7">
      <!-- header botones -->
      <div class="md:flex justify-between items-center mx-3">
        <h1 class="font-bold text-lg">Registrar venta</h1>
        <!-- Dropdown -->
        <div class="inline-block border border-primary rounded-full px-4 pt-[3px] mt-3 md:mt-0">
          <el-col :span="3">
            <el-dropdown trigger="click">
              <p class="text-sm text-primary flex items-center">
                <span>Acciones</span>
                <i class="fa-solid fa-angle-down text-[10px] ml-2 mt-px"></i>
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
      <div class="md:flex space-x-3 my-5">
        <!-- scaner de código  -->
        <section class="md:w-[70%]">
          <div class="relative lg:w-1/2 mx-auto mb-4">
            <input v-model="scannerQuery" :disabled="scanning" @keydown.enter="getProductByCode" ref="scanInput"
              class="input w-full pl-9" placeholder="Escanea o teclea el código del producto" type="text">
            <i class="fa-solid fa-barcode text-xs text-gray99 absolute top-[10px] left-4"></i>
          </div>
          <!-- Pestañas -->
          <div class="lg:mx-7">
            <el-tabs v-model="editableTabsValue" type="card" class="demo-tabs">
              <el-tab-pane v-for="tab in editableTabs" :key="tab.name" :label="tab.title" :name="tab.name">
                <el-popconfirm v-if="tab.saleProducts.length" confirm-button-text="Si" cancel-button-text="No"
                  icon-color="#C30303" title="Se eliminará todo el registro de productos ¿Deseas continuar?"
                  @confirm="clearTab()">
                  <template #reference>
                    <ThirthButton class="!text-[#F80505] !border-[#F80505] !py-1 !px-2 mb-2"><i
                        class="fa-regular fa-trash-can mr-2"></i> Limpiar registro</ThirthButton>
                  </template>
                </el-popconfirm>
                <!-- <el-radio-group v-if="tab.saleProducts.length" v-model="saleType"
                  class="!flex justify-center mb-4 mt-1 mx-2 lg:mx-14">
                  <el-radio label="publico">Venta al público</el-radio>
                  <el-radio label="empleado">Venta a empleado</el-radio>
                  <el-radio label="cortesia">Cortesias</el-radio>
                </el-radio-group> -->
                <SaleTable @delete-product="deleteProduct" :saleProducts="tab.saleProducts" :saleType="saleType" />
              </el-tab-pane>
            </el-tabs>
          </div>
        </section>

        <!-- seccion de desgloce de montos -->
        <section class="md:w-[30%]">
          <!-- buscador de productos -->
          <div class="relative">
            <input v-model="searchQuery" @focus="searchFocus = true" @blur="handleBlur" @input="searchProducts"
              ref="searchInput" class="input w-full pl-9" placeholder="Buscar código o nombre de producto"
              type="search">
            <i class="fa-solid fa-magnifying-glass text-xs text-gray99 absolute top-[10px] left-4"></i>
            <!-- Resultados de la búsqueda -->
            <div v-if="searchFocus && searchQuery"
              class="absolute mt-1 bg-white border border-gray-300 rounded shadow-lg w-full z-50 max-h-48 overflow-auto">
              <ul v-if="productsFound?.length > 0 && !loading">
                <li @click="selectProductFromList(product)" v-for="(product, index) in productsFound" :key="index"
                  class="hover:bg-gray-200 cursor-pointer text-xs px-3 py-2 flex space-x-2">
                  <span class="w-4/5">{{ product.name }}</span>
                  <span v-if="product.code" class="w-1/5 text-[10px] text-gray99">
                    {{ product.code }}
                  </span>
                </li>
              </ul>
              <p v-else-if="!loading" class="text-center text-sm text-gray-600 px-5 py-2">
                No se encontraron coincidencias
              </p>
              <!-- estado de carga -->
              <div v-if="loading" class="flex justify-center items-center py-10">
                <i class="fa-solid fa-square fa-spin text-4xl text-primary"></i>
              </div>
            </div>
          </div>
          <!-- Detalle de producto encontrado -->
          <div class="border border-grayD9 rounded-lg p-4 mt-5 text-xs lg:text-base">
            <div class="relative" v-if="productFoundSelected">
              <i @click="productFoundSelected = null"
                class="fa-solid fa-xmark cursor-pointer size-5 rounded-full flex items-center justify-center absolute right-3"></i>
              <figure class="h-36">
                <img v-if="productFoundSelected.imageUrl" :src="productFoundSelected.imageUrl"
                  :alt="productFoundSelected.name" class="object-contain h-36 mx-auto">
                <p v-else class="text-center text-xs text-gray99 pt-10 px-8">Este producto no tiene imagen registrada
                </p>
              </figure>
              <div class="flex justify-between items-center mt-2 mb-4">
                <p class="font-bold">{{ productFoundSelected.name }}</p>
                <p class="text-[#5FCB1F]">${{ productFoundSelected.public_price }}</p>
              </div>
              <div class="flex justify-between items-center">
                <p class="text-gray99">Cantidad</p>
                <el-input-number v-model="quantity" :min="0" :precision="2" />
              </div>
              <div class="text-center mt-7">
                <PrimaryButton @click="addSaleProduct(productFoundSelected); productFoundSelected = null"
                  class="!rounded-full !px-24" :disabled="quantity == 0">
                  Agregar
                </PrimaryButton>
              </div>
            </div>
            <p v-else class="text-center text-[#999999] text-sm">
              Busca el producto
              <i class="fa-regular fa-hand-point-up ml-3"></i>
            </p>
          </div>

          <!-- Total por cobrar -->
          <div v-if="editableTabs[editableTabsValue - 1]?.saleProducts?.length"
            class="border border-grayD9 rounded-lg p-4 mt-5 text-xs lg:text-base">
            <div v-if="!editableTabs[this.editableTabsValue - 1]?.paying">
              <div class="flex items-center justify-between text-lg mx-5">
                <p class="font-bold">Total</p>
                <p v-if="(calculateTotal() - editableTabs[this.editableTabsValue - 1].discount) < 0"
                  class="text-red-600 text-xs">El descuento es más grande que el total</p>
                <p v-else class="text-gray-99">$ <strong class="ml-3">{{ (calculateTotal() -
                  editableTabs[this.editableTabsValue
                    - 1].discount)?.toLocaleString('en-US', {
                      minimumFractionDigits: 2
                    }) }}</strong></p>
              </div>
              <div class="text-center mt-7">
                <PrimaryButton @click="receive()"
                  :disabled="editableTabs[this.editableTabsValue - 1]?.saleProducts?.length == 0 || (calculateTotal() - editableTabs[this.editableTabsValue - 1].discount) < 0"
                  class="!rounded-full !px-16 !bg-[#5FCB1F] disabled:!bg-[#999999]">Cobrar</PrimaryButton>
              </div>
            </div>

            <!-- cobrando -->
            <div v-else>
              <p class="text-gray-99 text-center mb-3 text-lg">Total $ <strong>{{ (calculateTotal() -
                editableTabs[this.editableTabsValue - 1].discount)?.toLocaleString('en-US', {
                  minimumFractionDigits: 2
                }) }}</strong>
              </p>
              <div class="flex items-center justify-between mx-5 space-x-10">
                <p>Entregado</p>
                <input v-model="editableTabs[this.editableTabsValue - 1].moneyReceived" @keydown.enter="store"
                  type="number" class="input !rounded-md w-1/3" ref="receivedInput" placeholder="$0.00">
              </div>
              <div class="flex items-center justify-between mx-5 my-2 relative">
                <p>Cambio</p>
                <p
                  v-if="(calculateTotal() - editableTabs[this.editableTabsValue - 1].discount) <= editableTabs[this.editableTabsValue - 1]?.moneyReceived">
                  ${{
                    (editableTabs[this.editableTabsValue - 1]?.moneyReceived - (calculateTotal() -
                      editableTabs[this.editableTabsValue - 1].discount)).toLocaleString('en-US', {
                        minimumFractionDigits: 2
                      }) }}</p>
              </div>
              <p v-if="((calculateTotal() - editableTabs[this.editableTabsValue - 1].discount) > editableTabs[this.editableTabsValue - 1]?.moneyReceived) && editableTabs[this.editableTabsValue - 1].moneyReceived"
                class="text-xs text-primary text-center mb-3">La cantidad es insuficiente. Por favor, ingrese una
                cantidad
                igual o mayor al total de compra.</p>
              <div class="flex space-x-2 justify-end">
                <CancelButton @click="editableTabs[this.editableTabsValue - 1].paying = false">Cancelar</CancelButton>
                <PrimaryButton @click="store" class="!rounded-full">Aceptar</PrimaryButton>
              </div>
            </div>
          </div>
        </section>
      </div>
    </div>
  </AppLayout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import ConfirmationModal from '@/Components/ConfirmationModal.vue';
import ThirthButton from '@/Components/ThirthButton.vue';
import InputLabel from "@/Components/InputLabel.vue";
import CancelButton from "@/Components/CancelButton.vue";
import SaleTable from '@/Components/MyComponents/Point/SaleTable.vue';
import InputError from "@/Components/InputError.vue";
import Modal from "@/Components/Modal.vue";
import { useForm } from "@inertiajs/inertia-vue3";
import axios from 'axios';
import { getItemByPartialAttributes, getItemByAttributes, addOrUpdateBatchOfItems } from '@/dbService.js';

export default {
  data() {
    const form = useForm({
      cashRegisterMovementType: null, //que tipo de movimiento es
      registerAmount: null, //Dinero ingresado o sacado de caja
      registerNotes: null, //notas al entrar o sacar dinero
    });

    return {
      form,
      saleType: 'publico',
      showCashRegisterMoney: false,
      loading: false, //cargando la busqueda de productos
      storeProcessing: false, //cargando store de venta
      scanning: false, //cargando la busqueda de productos por escaner
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
    Modal
  },
  props: {
    products: Array,
  },
  methods: {
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
      this.inputFocus();

      // indicar al navegador mediante el local storage que hay proceso pendiente
      const pendentProcess = JSON.parse(localStorage.getItem('pendentProcess'));
      if (!pendentProcess) {
        // guardar el valor en el localStorage
        localStorage.setItem('pendentProcess', true);
      }
    },
    // async getProductByCode() {
    //   this.scanning = true;
    //   //buscar primero en productos transferidos del catalogo con el codigo escaneado
    //   let productScaned = this.products.find(item => item.code === this.scannerQuery);

    //   // si no se encontró el producto escaneado aparece un mensaje y no busca en la bd para no tardar más
    //   if (productScaned != null) {
    //     try {
    //       const response = await axios.get(route('products.get-product-scaned', productScaned.id));

    //       if (response.status === 200 && response.data && response.data.item) {
    //         this.productSelected = response.data.item;
    //         this.addSaleProduct(this.productSelected);
    //       } else {
    //         console.error('La respuesta no tiene el formato esperado.');
    //       }
    //     } catch (error) {
    //       console.error('Error al realizar la solicitud:', error);
    //     } finally {
    //       this.scanning = false;
    //     }
    //   } else {
    //     this.$notify({
    //       title: "Poducto no encontrado",
    //       message: "El producto escaneado no esta registrado en la base de datos",
    //       type: "warning"
    //     });
    //     console.error('El producto escaneado no tiene la propiedad "id".');
    //     this.scannerQuery = null;
    //     this.scanning = false;
    //   }
    // },
    // async searchProducts() {
    //   try {
    //     this.loading = true;
    //     const response = await axios.get(route('products.search'), { params: { query: this.searchQuery } });
    //     if (response.status === 200) {
    //       this.productsFound = response.data.items;
    //       this.loading = false;
    //     }
    //   } catch (error) {
    //     console.log(error);
    //   }
    // },
    selectProductFromList(product) {
      // crear link virtual de imagen blob si es que tiene imagen el producto
      if (product.image && !product.imageUrl) {
        const imageUrl = URL.createObjectURL(product.image);
        product = { ...product, imageUrl };
      }

      this.productFoundSelected = product;
      this.searchQuery = null;
    },
    // addSaleProduct(product) {
    //   //revisa si el producto escaneado ya esta dentro del arreglo
    //   const existingIndex = this.editableTabs[this.editableTabsValue - 1].saleProducts.findIndex(sale => {
    //     if (product.global_product_id) {
    //       return sale.product.global_product_id == product.global_product_id;
    //     } else {
    //       return sale.product.id == product.id && !sale.product.global_product_id;
    //     }
    //   });
    //   if (existingIndex !== -1) {
    //     this.editableTabs[this.editableTabsValue - 1].saleProducts[existingIndex] = {
    //       ...this.editableTabs[this.editableTabsValue - 1].saleProducts[existingIndex],
    //       quantity: this.editableTabs[this.editableTabsValue - 1].saleProducts[existingIndex].quantity + this.quantity
    //     };
    //   } else {
    //     // Si el producto no existe, agrégalo al array
    //     this.editableTabs[this.editableTabsValue - 1].saleProducts.push({
    //       product: product,
    //       quantity: this.quantity
    //     });
    //   }
    //   this.scannerQuery = null;
    //   this.quantity = 1;
    //   this.scanning = false;
    //   this.inputFocus();

    //   // indicar al navegador mediante el local storage que hay proceso pendiente
    //   const pendentProcess = JSON.parse(localStorage.getItem('pendentProcess'));
    //   if (!pendentProcess) {
    //     // guardar el valor en el localStorage
    //     localStorage.setItem('pendentProcess', true);
    //   }
    // },
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
      this.inputFocus();
    },
    // getPrice(product) {
    //   if (this.saleType == 'publico') {
    //     return product.current_price?.price ?? 0;
    //   } else if (this.saleType == 'empleado') {
    //     return product.current_employee_price?.price ?? 0;
    //   } else if (this.saleType == 'cortesia') {
    //     return 0;
    //   }
    // },
    calculateTotal() {
      // Suma de los productos del precio y la cantidad para cada elemento en saleProducts
      const total = this.editableTabs[this.editableTabsValue - 1]?.saleProducts?.reduce((accumulator, sale) => {
        return accumulator + sale.product.public_price * sale.quantity;
      }, 0);

      return total;
    },
    inputFocus() {
      this.$nextTick(() => {
        this.$refs.scanInput.focus();
      });
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
  },
  mounted() {
    // enfocar input de scaner al abrir la vista
    this.$refs.scanInput.focus();

    // resetear variable de local storage a false
    localStorage.setItem('pendentProcess', false);

    // Agregar escuchadores de eventos online/offline
    window.addEventListener('online', this.handleOnline);
    window.addEventListener('offline', this.handleOffline);
  },
  beforeUnmount() {
    // Eliminar los escuchadores de eventos al desmontar el componente
    window.removeEventListener('online', this.handleOnline);
    window.removeEventListener('offline', this.handleOffline);
  },
}
</script>
