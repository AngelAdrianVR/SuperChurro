
<template>
  <AppLayout title="Dashboard">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Inicio</h2>
    </template>
    <!-- -----------------------Registro de entrada y salida------------ -->
    <div class="py-7">
      <div class="globe-container">
        <div class="globe">
          <div v-if="checked_out" class="flex items-center">
            <i class="fa-regular fa-clock text-lg text-blue-600 mr-2"></i>
            <span class="text-blue-600">Salida registrada</span>
          </div>
          <div v-else-if="checked_in" class="flex items-center justify-between">
            <div>
              <i class="fa-regular fa-clock text-lg text-green-600 mr-2"></i>
              <span class="text-green-600">Entrada registrada.</span>
            </div>
            <Link :href="route('qr-scanner')">
            <SecondaryButton>Salida</SecondaryButton>
            </Link>
          </div>
          <div v-else class="flex items-center justify-between">
            <div>
              <i class="fa-regular fa-clock text-lg mr-2"></i>
              No has registrado entrada hoy
            </div>
            <Link :href="route('qr-scanner')">
            <SecondaryButton>Entrada</SecondaryButton>
            </Link>
          </div>
        </div>
        <!-- ------------Permutas------------- -->
        <!-- <div class="globe">
          <div class="globe-title">Permutas</div>
          <div>
            <p class="text-center">No hay información para mostrar.</p>
            <p>información de permutas.</p>
          </div>
        </div> -->
        <!-- -----------------Permisos----------------- -->
        <div class="globe">
          <div class="globe-title">Permisos</div>
          <div v-for="leave in leaves" :key="leave.id" class="flex justify-between items-center text-xs">
            <span><i class="fa-regular fa-calendar-days"></i>{{ leave.date.split('T')[0] }}</span>
            <span>{{ leave.permission_type.name }}</span>
            <span v-if="leave.status === 0" class="text-orange-600 font-bold"><i class="fa-solid fa-hourglass-start"></i>Revisando.</span>
            <span v-else-if="leave.status === 1" class="text-green-600 font-bold"><i class="fa-solid fa-check"></i>Aprobado.</span>
            <span v-else class="text-red-600 font-bold"><i class="fa-solid fa-xmark"></i>Rechazado.</span>
          </div>
          <p v-if="!leaves.length" class="text-center text-gray-500 text-xs">No hay información para mostrar.</p>
        </div>
        <!-- -----------------Préstamos----------------- -->
        <div class="globe">
          <div class="globe-title">Préstamos</div>
          <div class="flex justify-between items-center text-xs">
            <span><i class="fa-regular fa-calendar-days"></i>{{ loan.created_at.split('T')[0] }}</span>
            <span>${{ loan.amount }} solicitado</span>
            <span v-if="!loan.authorized_at" class="text-orange-600 font-bold"><i class="fa-solid fa-hourglass-start"></i>Revisando.</span>
            <span v-else-if="loan.remaining" class="text-green-600 font-bold"><i class="fa-solid fa-check"></i>Aprobado.</span>
            <span v-else class="text-red-600 font-bold"><i class="fa-solid fa-xmark"></i>Rechazado.</span>
          </div>
          <p v-if="!loan" class="text-center text-gray-500 text-xs">No hay información para mostrar.</p>
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

export default {
  data() {
    return {};
  },
  components: {
    AppLayout,
    PrimaryButton,
    SecondaryButton,
    Link,
  },
  props: {
    checked_in: Boolean,
    checked_out: Boolean,
    leaves: Array,
    loan: Object
  },
};
</script>