<template>
  <AppLayout title="Solicitudes">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
        Préstamos
      </h2>
    </template>

    <!-- Contenedor principal con padding estándar -->
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">

      <!-- Cuadrícula (Grid) responsiva para las tarjetas -->
      <div v-if="loans.data.length" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

        <!-- Tarjeta de Préstamo -->
        <div v-for="loan in loans.data" :key="loan.id"
          class="bg-white rounded-lg shadow-lg overflow-hidden flex flex-col justify-between relative group">

          <!-- Contenido principal de la tarjeta -->
          <div class="p-6">
            <p class="text-lg font-semibold text-gray-900 flex items-center mb-2">
              <i class="fa-regular fa-circle-user mr-2"></i>
              {{ loan.user.name }}
            </p>

            <p class="text-2xl font-bold text-gray-800">${{ loan.amount }}</p>
            <p class="text-sm text-gray-600">Saldo restante: ${{ loan.remaining }}</p>

            <p v-if="loan.description" class="text-sm text-gray-700 bg-gray-50 p-2 rounded-md mt-4">
              <strong>Notas:</strong> {{ loan.description }}
            </p>

            <!-- Badge de Estado -->
            <div class="mt-4">
              <span v-if="loan.remaining == loan.amount && !loan.authorized_at"
                class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-orange-100 text-orange-600">
                <i class="fa-solid fa-hourglass-start mr-2"></i>Revisando...
              </span>
              <span v-else-if="(loan.amount <= loan.remaining) && loan.authorized_at && loan.remaining != 0"
                class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-600">
                <i class="fa-solid fa-check mr-2"></i>Aprobado
              </span>
              <span v-else-if="loan.remaining == 0 && !loan.authorized_at"
                class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-600">
                <i class="fa-solid fa-xmark mr-2"></i>Rechazado
              </span>
              <span v-else-if="loan.remaining == 0 && loan.authorized_at"
                class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-indigo-100 text-indigo-600">
                <i class="fa-solid fa-handshake mr-2"></i>Pagado
              </span>
            </div>
          </div>

          <!-- Pie de la tarjeta (Acciones y Timestamp) -->
          <div>
            <!-- Botones de Acción -->
            <div v-if="loan.remaining == loan.amount && !loan.authorized_at"
              class="flex justify-center items-center p-6 pt-0 space-x-2">
              <PrimaryButton @click="$inertia.put(route('loan.accept', loan.id))" class="bg-green-400 hover:bg-green-500 w-full justify-center">Aprobar</PrimaryButton>
              <PrimaryButton @click="$inertia.put(route('loan.reject', loan.id))" class="bg-red-400 hover:bg-red-500 w-full justify-center">Rechazar</PrimaryButton>
            </div>
            <!-- Timestamp -->
            <div class="px-6 pb-4 text-xs text-gray-400">
              Solicitado el: {{ loan.created_at }}
            </div>
          </div>

          <!-- Botón de eliminar (Absoluto) -->
          <button v-if="loan.status == 1"
            class="absolute top-2 right-2 z-10 p-2 rounded-full bg-white/70 text-red-500 hover:bg-red-100 hover:text-red-700 transition-all duration-200 opacity-0 group-hover:opacity-100"
            @click="delete_confirm = true; item_to_delete = loan;">
            <i class="fa-regular fa-trash-can text-lg"></i>
          </button>
        </div>
      </div>

      <!-- Mensaje si no hay datos -->
      <div v-else class="text-center text-gray-500 py-12">
        <p>No hay información para mostrar</p>
      </div>

      <!-- Paginación -->
      <Pagination class="py-5" :pagination="loans" />
    </div>

    <!-- El modal de confirmación no se ha referenciado en el template, pero lo mantengo por si se usa en el futuro -->
    <!-- <ConfirmationModal :show="delete_confirm" @close="delete_confirm = false"> ... </ConfirmationModal> -->

  </AppLayout>
</template>

<script>
// El script se mantiene idéntico
import AppLayout from "@/Layouts/AppLayout.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import ConfirmationModal from "@/Components/ConfirmationModal.vue";
import Pagination from "@/Components/Pagination.vue";
import { Link } from "@inertiajs/inertia-vue3";
export default {
  data() {
    return {
    }
  },
  components: {
    AppLayout,
    SecondaryButton,
    ConfirmationModal,
    PrimaryButton,
    Pagination,
    Link
  },
  props: {
    loans: Object,
  },
  methods: {

  },
};
</script>
