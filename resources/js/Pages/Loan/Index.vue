<template>
  <AppLayout title="Préstamos">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 dar:text-gray-200 leading-tight">
        Mis Préstamos
      </h2>
    </template>

    <!-- Modernized: Contenedor principal con padding y ancho máximo -->
    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        <!-- Modernized: Alerta con diseño actualizado y más sutil (border-l-4) -->
        <div class="bg-yellow-50 dar:bg-yellow-900/20 border-l-4 border-yellow-400 dar:border-yellow-600 p-4 rounded-lg shadow-md mb-8" role="alert">
          <div class="flex">
            <div class="flex-shrink-0">
              <svg class="fill-current h-6 w-6 text-yellow-500 dar:text-yellow-400 mr-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"/></svg>
            </div>
            <div class="text-yellow-800 dar:text-yellow-200">
              <p class="font-bold">ATENCIÓN</p>
              <p class="text-sm">
                Los préstamos se pagan vía nómina y se liquidan en un plazo de 2 semanas.
                Si ya tienes un préstamo activo, no podrás solicitar otro.
              </p>
            </div>
          </div>
        </div>

        <!-- Contenedor del botón y mensaje de error -->
        <div class="flex justify-between items-center mb-6 px-4 sm:px-0">
          <div v-if="user_has_active_loan.length" class="text-red-500 dar:text-red-400 text-sm font-medium"> 
            Actualmente tienes un préstamo activo. 
          </div>
          <div v-else>
            <!-- Espaciador para mantener el botón a la derecha -->
          </div>
          
          <Link :href="route('loans.create')">
            <PrimaryButton :disabled="user_has_active_loan.length">
              Solicitar Préstamo
            </PrimaryButton>
          </Link>
        </div>

        <!-- Modernized: Rejilla (Grid) de tarjetas para las solicitudes -->
        <div v-if="loans.data.length" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
          
          <!-- Modernized: Tarjeta de Préstamo -->
          <div v-for="loan in loans.data" :key="loan.id" class="bg-white dar:bg-gray-800 shadow-lg rounded-lg overflow-hidden transition-shadow duration-300 hover:shadow-xl">
            
            <!-- Cabecera de la Tarjeta -->
            <div class="flex justify-between items-center p-4 border-b border-gray-200 dar:border-gray-700">
              <p class="text-sm text-gray-600 dar:text-gray-400">Solicitado el: {{loan.created_at}}</p>
              
              <!-- Botón de eliminar (sólo si status == 1) -->
              <button 
                v-if="loan.status == 1" 
                @click="delete_confirm = true; item_to_delete = loan;" 
                class="text-gray-400 dar:text-gray-500 hover:text-red-500 dar:hover:text-red-400 transition duration-150"
                title="Cancelar Solicitud"
              >
                <i class="fa-solid fa-trash"></i>
              </button>
            </div>
            
            <!-- Cuerpo de la Tarjeta -->
            <div class="p-5 space-y-4">
              <div>
                <p class="text-sm text-gray-500 dar:text-gray-400">Cantidad Solicitada</p>
                <p class="text-2xl font-bold text-gray-900 dar:text-white">${{loan.amount}}</p>
              </div>
              
              <div>
                <p class="text-sm text-gray-500 dar:text-gray-400">Saldo Restante</p>
                <p class="text-lg font-semibold text-gray-700 dar:text-gray-300">${{ loan.remaining }}</p>
              </div>

              <div v-if="loan.description">
                <p class="text-sm text-gray-500 dar:text-gray-400">Notas</p>
                <p class="text-sm text-gray-700 dar:text-gray-300 italic">"{{ loan.description }}"</p>
              </div>

              <!-- Modernized: Insignias (Badges) de Estado -->
              <div class="pt-2">
                <span v-if="loan.remaining == loan.amount && !loan.authorized_at" 
                      class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800 dar:bg-yellow-900 dar:text-yellow-200">
                  <i class="fa-solid fa-hourglass-start mr-2"></i>Revisando...
                </span>
                <span v-else-if="loan.amount <= loan.remaining && loan.authorized_at && loan.remaining != 0" 
                      class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium bg-green-100 text-green-800 dar:bg-green-900 dar:text-green-200">
                  <i class="fa-solid fa-check mr-2"></i>Aprobado
                </span>
                <span v-else-if="loan.remaining == 0 && !loan.authorized_at" 
                      class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium bg-red-100 text-red-800 dar:bg-red-900 dar:text-red-200">
                  <i class="fa-solid fa-xmark mr-2"></i>Rechazado
                </span>
                <span v-else-if="loan.remaining == 0 && loan.authorized_at" 
                      class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium bg-blue-100 text-blue-800 dar:bg-blue-900 dar:text-blue-200">
                  <i class="fa-solid fa-handshake mr-2"></i>Pagado
                </span>
              </div>
            </div>
          </div>
        </div>

        <!-- Modernized: Estado vacío -->
        <div v-else class="text-center text-gray-500 dar:text-gray-400 py-16">
          <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
            <path vector-effect="non-scaling-stroke" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
          </svg>
          <h3 class="mt-2 text-sm font-medium text-gray-900 dar:text-white">No hay préstamos</h3>
          <p class="mt-1 text-sm text-gray-500 dar:text-gray-400">Aún no has solicitado ningún préstamo.</p>
        </div>

      </div>
    </div>

    <!-- Modal de Confirmación (Estilos de botones internos modernizados) -->
    <ConfirmationModal :show="delete_confirm" @close="delete_confirm = false">
      <template #title>
        <span class="dar:text-white">¿Deseas continuar?</span>
      </template>
      <template #content>
        <p class="dar:text-gray-300">
          Estás a punto de eliminar una solicitud de préstamo. Una vez realizado ya no se podrá
          recuperar y la solicitud quedará cancelada.
        </p>
      </template>
      <template #footer>
        <div class="flex justify-end space-x-3">
          <!-- Modernized: Botón de cancelar -->
          <button @click="delete_confirm = false"
                  class="inline-flex justify-center rounded-md border border-gray-300 dar:border-gray-600 bg-white dar:bg-gray-700 px-4 py-2 text-base font-medium text-gray-700 dar:text-gray-300 shadow-sm hover:bg-gray-50 dar:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:text-sm">
            Cancelar
          </button>
          <!-- Modernized: Botón de eliminar (destructivo) -->
          <button @click="this.delete()" 
                  class="inline-flex justify-center rounded-md border border-transparent bg-red-600 px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 sm:text-sm">
            Eliminar
          </button>
        </div>
      </template>
    </ConfirmationModal>
  </AppLayout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { Link } from "@inertiajs/inertia-vue3";
import ConfirmationModal from "@/Components/ConfirmationModal.vue";

export default {
  data() {
    return {
      delete_confirm: false,
      item_to_delete: {},
    };
  },
  components: {
    AppLayout,
    ConfirmationModal,
    PrimaryButton,
    Link,
  },
  props: {
    loans: Object,
    user_has_active_loan: Array,
  },
  methods: {
    delete() {
      this.$inertia.delete(
        this.route("loans.destroy", this.item_to_delete), {
          onFinish: () => {
            this.delete_confirm = false; // Asegurarse de cerrar el modal
          }
        }
      );
    },
  },
};
</script>
