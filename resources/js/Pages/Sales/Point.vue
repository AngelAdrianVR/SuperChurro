<template>
    <AppLayout title="Punto de venta">
        <div class="px-1 lg:px-6 py-7">
            <!-- header botones -->
            <div class="md:flex justify-between items-center mx-3">
                <h1 class="font-bold text-lg">Registrar venta</h1>
                <!-- Dinero en caja -->
                <!-- <div class="mt-4 lg:mt-0 flex items-center justify-center space-x-3 text-gray-400">
                <svg @click="showCashRegisterMoney = !showCashRegisterMoney" v-if="showCashRegisterMoney"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                    class="h-4 w-4 cursor-pointer">
                    <path stroke-linecap="round" stroke-linejoin="round"
                    d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                </svg>
                <svg @click="showCashRegisterMoney = !showCashRegisterMoney" v-else xmlns="http://www.w3.org/2000/svg"
                    fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4 cursor-pointer">
                    <path stroke-linecap="round" stroke-linejoin="round"
                    d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                </svg>
                <p class="text-sm flex items-center space-x-2">
                    Efectivo en caja:
                    <b :class="(localCurrentCash >= cash_register.max_cash) && isMaxCashOn ? 'text-red-600' : ''" class="ml-2">
                    {{ showCashRegisterMoney ? '$' + localCurrentCash?.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",") :
                        '*****' }}
                    </b>
                    <el-tooltip v-if="(localCurrentCash >= cash_register.max_cash) && isMaxCashOn && showCashRegisterMoney"
                    content="Se llegó al límite de dinero permitido en caja. Es recomendable hacer corte" placement="bottom">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-4 text-red-600">
                        <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                    </svg>
                    </el-tooltip>
                </p>
                </div> -->
                <!-- Dropdown -->
                <div class="inline-block border border-primary rounded-full px-4 pt-[3px] mt-3 md:mt-0">
                <el-col :span="3">
                    <el-dropdown trigger="click">
                    <p class="text-sm text-primary w-24 flex items-center">
                        <svg class="mr-2" width="12" height="12" viewBox="0 0 12 12" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <mask id="mask0_9380_424" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="0" y="0" width="12"
                            height="12">
                            <rect width="12" height="12" fill="#D9D9D9" />
                        </mask>
                        <g mask="url(#mask0_9380_424)">
                            <path
                            d="M2.5 10.5C2.225 10.5 1.98958 10.4021 1.79375 10.2063C1.59792 10.0104 1.5 9.775 1.5 9.5V2.5C1.5 2.225 1.59792 1.98958 1.79375 1.79375C1.98958 1.59792 2.225 1.5 2.5 1.5H9.5C9.775 1.5 10.0104 1.59792 10.2063 1.79375C10.4021 1.98958 10.5 2.225 10.5 2.5V9.5C10.5 9.775 10.4021 10.0104 10.2063 10.2063C10.0104 10.4021 9.775 10.5 9.5 10.5H2.5ZM6 8C6.31667 8 6.60417 7.90833 6.8625 7.725C7.12083 7.54167 7.3 7.3 7.4 7H9.5V2.5H2.5V7H4.6C4.7 7.3 4.87917 7.54167 5.1375 7.725C5.39583 7.90833 5.68333 8 6 8Z"
                            fill="#F68C0F" />
                        </g>
                        </svg>
                        <span>Acciones</span>
                        <i class="fa-solid fa-angle-down text-[10px] ml-2 mt-px"></i>
                    </p>
                    <template #dropdown>
                        <el-dropdown-menu>
                        <el-dropdown-item @click="$inertia.visit(route('product-request.create'))">Solicitar mercancía</el-dropdown-item>
                        <el-dropdown-item @click="$inertia.visit(route('sales-to-employees.create'))">Ventas internas/Cortesías</el-dropdown-item>
                        <el-dropdown-item @click="handleCashCut">Hacer corte</el-dropdown-item>
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
                            <SaleTable @delete-product="deleteProduct" :saleProducts="tab.saleProducts" />
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
                            <li @click="productFoundSelected = product; searchQuery = null"
                            v-for="(product, index) in productsFound" :key="index"
                            class="hover:bg-gray-200 cursor-default text-sm px-5 py-2">{{ product.name }}</li>
                        </ul>
                        <p v-else-if="!loading" class="text-center text-sm text-gray-600 px-5 py-2">No se encontraron
                            coincidencias
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
                            <img class="object-contain h-36 mx-auto rounded-lg"
                            :src="productFoundSelected?.media[0]?.original_url">
                        </figure>
                        <div class="flex justify-between items-center mt-2 mb-4">
                            <p class="font-bold">{{ productFoundSelected?.name }}</p>
                            <p class="text-[#5FCB1F]">${{ productFoundSelected?.current_price?.price?.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",") }}</p>
                        </div>
                        <div class="flex justify-between items-center">
                            <p class="text-gray99">Cantidad</p>
                            <el-input-number v-model="quantity" :min="0" :precision="2" />
                        </div>
                        <div class="text-center mt-7">
                            <PrimaryButton @click="addSaleProduct(this.productFoundSelected); productFoundSelected = null"
                            class="!rounded-full !px-24">Agregar
                            </PrimaryButton>
                        </div>
                        </div>
                        <p v-else class="text-center text-gray99 text-sm">
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

export default {
data() {
    const form = useForm({
      cashRegisterMovementType: null, //que tipo de movimiento es
      registerAmount: null, //Dinero ingresado o sacado de caja
      registerNotes: null, //notas al entrar o sacar dinero
    });

    return {
        form,
        showCashRegisterMoney: false,
        loading: false, //cargando la busqueda de productos
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
    }   
},
components:{
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
props:{
products: Array,
// cash_register: Object
},
methods:{
    async store() {
      try {
        this.storeProcessing = true;
        const response = await axios.post(route('sales.store'), {
          data: {
            saleProducts: this.editableTabs[this.editableTabsValue - 1]?.saleProducts
          }
        });
        if (response.status === 200) {
          this.$notify({
            title: "Correcto",
            text: "Se ha registrado la venta con éxito!",
            type: "success",
          });
          this.storeProcessing = false;
          this.clearTab();
          // this.fetchCashRegister(); //actualiza el monto que hay en caja.

          // resetear variable de local storage a false
          localStorage.setItem('pendentProcess', false);
        }
      } catch (error) {
        console.log(error);
      }
    },
    async getProductByCode() {
      this.scanning = true;
      //buscar primero en productos transferidos del catalogo con el codigo escaneado
      let productScaned = this.products.find(item => item.code === this.scannerQuery);

      // si no se encontró el producto escaneado aparece un mensaje y no busca en la bd para no tardar más
      if (productScaned != null) {
        try {
            const response = await axios.get(route('products.get-product-scaned', productScaned.id ));

            if (response.status === 200 && response.data && response.data.item) {
              this.productSelected = response.data.item;
              this.addSaleProduct(this.productSelected);
            } else {
              console.error('La respuesta no tiene el formato esperado.');
            }
        } catch (error) {
          console.error('Error al realizar la solicitud:', error);
        } finally {
          this.scanning = false;
        }
      } else {
        this.$notify({
          title: "Poducto no encontrado",
          message: "El producto escaneado no esta registrado en la base de datos",
          type: "warning"
        });
        console.error('El producto escaneado no tiene la propiedad "id".');
        this.scannerQuery = null;
        this.scanning = false;
      }
    },
    async searchProducts() {
      try {
        this.loading = true;
        const response = await axios.get(route('products.search'), { params: { query: this.searchQuery } });
        if (response.status === 200) {
          this.productsFound = response.data.items;
          this.loading = false;
        }
      } catch (error) {
        console.log(error);
      }
    },
    addSaleProduct(product) {
      //revisa si el producto escaneado ya esta dentro del arreglo
      const existingIndex = this.editableTabs[this.editableTabsValue - 1].saleProducts.findIndex(sale => {
        if (product.global_product_id) {
          return sale.product.global_product_id == product.global_product_id;
        } else {
          return sale.product.id == product.id && !sale.product.global_product_id;
        }
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
    calculateTotal() {
      // Suma de los productos del precio y la cantidad para cada elemento en saleProducts
      const total = this.editableTabs[this.editableTabsValue - 1]?.saleProducts?.reduce((accumulator, sale) => {
        return accumulator + sale.product.current_price?.price * sale.quantity;
      }, 0);

      // Formatear el resultado al final
      // return total?.toLocaleString('en-US', { minimumFractionDigits: 2 }); formatea el total con comas pero me manda a NaN despues de 1000
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
}
}
</script>
