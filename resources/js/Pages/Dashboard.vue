<template>
  <AppLayout title="Dashboard">
    <template #header>
      <h1 class="font-bold text-center text-lg dar:text-gray-200">Panel de Inicio</h1>
    </template>

    <!-- Modernized: Mensaje de bienvenida (Toast) con transición más rápida -->
   <transition
  enter-active-class="transition ease-out duration-200"
  enter-from-class="opacity-0 translate-y-4"
  enter-to-class="opacity-100 translate-y-0"
  leave-active-class="transition ease-in duration-150"
  leave-from-class="opacity-100 translate-y-0"
  leave-to-class="opacity-0 translate-y-4"
>
  <div
    v-if="showWelcomeMessage"
    class="fixed top-5 right-5 z-50 flex items-start gap-3 bg-green-50 dark:bg-green-900 border border-green-300 dark:border-green-700 text-green-800 dark:text-green-100 shadow-lg rounded-lg p-4 max-w-xs"
  >
    <!-- Ícono estilo sol -->
    <div class="flex-shrink-0 mt-0.5">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7 text-orange-400">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386-1.591 1.591M21 12h-2.25m-.386 6.364-1.591-1.591M12 18.75V21m-4.773-4.227-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z" />
      </svg>

    </div>

    <!-- Contenido del toast -->
    <div>
      <h3 class="text-sm font-semibold">
        ¡Bienvenida/o, {{ $page.props.user.name }}!
      </h3>
      <p class="text-xs mt-1">
        ¡Que tengas un excelente día!
      </p>
    </div>
  </div>
</transition>


    <!-- Modernized: Contenedor principal con padding -->
    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        
        <!-- Modernized: Grid layout para el dashboard -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

          <!-- Columna 1: Registro de Asistencia -->
          <div class="lg:col-span-1 bg-white dar:bg-gray-800 shadow-xl rounded-lg overflow-hidden">
            <div class="p-5 border-b border-gray-200 dar:border-gray-700">
              <h3 class="text-lg font-medium text-gray-900 dar:text-white">
                Registro de Asistencia
              </h3>
            </div>
            <div class="p-6 space-y-4">
              
              <!-- Estado: Salida Registrada -->
              <div v-if="checked_out" class="flex items-center p-4 bg-blue-50 dar:bg-blue-900/20 rounded-lg">
                <i class="fa-regular fa-clock text-xl text-blue-500 dar:text-blue-400 mr-3"></i>
                <span class="text-blue-700 dar:text-blue-300 font-medium">Salida registrada por hoy.</span>
              </div>

              <!-- Estado: Entrada Registrada -->
              <div v-else-if="checked_in" class="space-y-4">
                <div class="flex items-center p-4 bg-green-50 dar:bg-green-900/20 rounded-lg">
                  <i class="fa-regular fa-clock text-xl text-green-500 dar:text-green-400 mr-3"></i>
                  <span class="text-green-700 dar:text-green-300 font-medium">Entrada registrada.</span>
                </div>
                <SecondaryButton @click="getPosition" class="w-full justify-center">
                  Registrar Salida
                </SecondaryButton>
              </div>

              <!-- Estado: Sin Registrar -->
              <div v-else class="space-y-4">
                 <p class="text-sm text-gray-600 dar:text-gray-400 text-center">
                   No has registrado tu entrada de hoy.
                 </p>
                <PrimaryButton @click="getPosition" class="w-full justify-center">
                  Registrar Entrada
                </PrimaryButton>
              </div>

              <!-- Modernized: Reemplazo de 'alert()' para mensajes de geolocalización -->
              <div v-if="geolocation_message.text" 
                   class="p-3 rounded-md text-sm font-medium"
                   :class="{ 
                     'bg-green-100 dar:bg-green-900/30 text-green-800 dar:text-green-200': geolocation_message.type === 'success', 
                     'bg-red-100 dar:bg-red-900/30 text-red-800 dar:text-red-200': geolocation_message.type === 'error' 
                   }">
                {{ geolocation_message.text }}
              </div>

            </div>
          </div>

          <!-- Columna 2: Avisos -->
          <div class="lg:col-span-2 bg-white dar:bg-gray-800 shadow-xl rounded-lg overflow-hidden">
            <div class="p-5 border-b border-gray-200 dar:border-gray-700">
              <h3 class="text-lg font-medium text-gray-900 dar:text-white">
                Avisos
              </h3>
            </div>
            <div class="p-6">
              <div v-if="notices.length" class="space-y-4">
                <div v-for="notice in notices" :key="notice.id" class="border-b border-gray-200 dar:border-gray-700 pb-3 last:border-b-0">
                  <h4 class="font-semibold text-gray-800 dar:text-gray-200">{{ notice.title }}</h4>
                  <p class="text-sm text-gray-600 dar:text-gray-400 mt-1">{{ notice.content }}</p>
                </div>
              </div>
              <!-- Modernized: Estado vacío -->
              <div v-else class="text-center text-gray-500 dar:text-gray-400 py-10">
                <i class="fa-regular fa-bell-slash text-4xl text-gray-400"></i>
                <h3 class="mt-2 text-sm font-medium text-gray-900 dar:text-white">No hay avisos</h3>
                <p class="mt-1 text-sm text-gray-500 dar:text-gray-400">No hay avisos nuevos para mostrar.</p>
              </div>
            </div>
          </div>

          <!-- Columna 3: Permisos -->
          <div class="lg:col-span-2 bg-white dar:bg-gray-800 shadow-xl rounded-lg overflow-hidden">
            <div class="p-5 border-b border-gray-200 dar:border-gray-700">
              <h3 class="text-lg font-medium text-gray-900 dar:text-white">
                Mis Permisos Recientes
              </h3>
            </div>
            <div class="p-6">
              <div v-if="leaves.length" class="space-y-3">
                <div v-for="leave in leaves" :key="leave.id" class="flex justify-between items-center">
                  <div>
                    <p class="font-medium text-gray-800 dar:text-gray-200">{{ leave.permission_type.name }}</p>
                    <p class="text-sm text-gray-500 dar:text-gray-400">{{ leave.date.split('T')[0] }}</p>
                  </div>
                  <!-- Modernized: Badges de Estado -->
                  <span v-if="leave.status === 1" class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800 dar:bg-yellow-900 dar:text-yellow-200">
                    Revisando
                  </span>
                  <span v-else-if="leave.status === 2" class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium bg-green-100 text-green-800 dar:bg-green-900 dar:text-green-200">
                    Aprobado
                  </span>
                  <span v-else class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium bg-red-100 text-red-800 dar:bg-red-900 dar:text-red-200">
                    Rechazado
                  </span>
                </div>
              </div>
              <!-- Modernized: Estado vacío -->
              <div v-else class="text-center text-gray-500 dar:text-gray-400 py-10">
                <i class="fa-regular fa-calendar-xmark text-4xl text-gray-400"></i>
                <h3 class="mt-2 text-sm font-medium text-gray-900 dar:text-white">No hay permisos</h3>
                <p class="mt-1 text-sm text-gray-500 dar:text-gray-400">No tienes solicitudes de permiso recientes.</p>
              </div>
            </div>
          </div>

          <!-- Columna 4: Préstamos -->
          <div class="lg:col-span-1 bg-white dar:bg-gray-800 shadow-xl rounded-lg overflow-hidden">
            <div class="p-5 border-b border-gray-200 dar:border-gray-700">
              <h3 class="text-lg font-medium text-gray-900 dar:text-white">
                Mi Préstamo
              </h3>
            </div>
            <div class="p-6">
              <div v-if="loan" class="space-y-3">
                <div>
                  <p class="text-sm text-gray-500 dar:text-gray-400">Monto Solicitado</p>
                  <p class="text-xl font-semibold text-gray-900 dar:text-white">${{ loan.amount }}</p>
                </div>
                <div>
                  <p class="text-sm text-gray-500 dar:text-gray-400">Fecha de Solicitud</p>
                  <p class="text-sm text-gray-700 dar:text-gray-300">{{ loan.created_at.split('T')[0] }}</p>
                </div>
                <!-- Modernized: Badges de Estado -->
                <div class="pt-2">
                  <span v-if="!loan.authorized_at" class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800 dar:bg-yellow-900 dar:text-yellow-200">
                    Revisando
                  </span>
                  <span v-else-if="loan.remaining" class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium bg-green-100 text-green-800 dar:bg-green-900 dar:text-green-200">
                    Aprobado
                  </span>
                  <span v-else class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium bg-red-100 text-red-800 dar:bg-red-900 dar:text-red-200">
                    Rechazado
                  </span>
                </div>
              </div>
              <!-- Modernized: Estado vacío -->
              <div v-else class="text-center text-gray-500 dar:text-gray-400 py-10">
                <i class="fa-solid fa-file-invoice-dollar text-4xl text-gray-400"></i>
                <h3 class="mt-2 text-sm font-medium text-gray-900 dar:text-white">No hay préstamo</h3>
                <p class="mt-1 text-sm text-gray-500 dar:text-gray-400">No tienes un préstamo activo.</p>
              </div>
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

export default {
  data() {
    return {
      // Modernized: Para el mensaje de bienvenida
      showWelcomeMessage: false, 
      // Modernized: Para reemplazar los 'alert()'
      geolocation_message: { type: '', text: '' }, 

      geolocation_options: {
        enableHighAccuracy: true,
        timeout: 8000,
        maximumAge: 0
      },
      valid_areas: [
        {
          label: "Audycarr",
          latitudes: [20.71190, 20.73212],
          longitudes: [-103.38888, -103.37857]
        },
        {
          label: "Carrito",
          latitudes: [20.70000, 20.75000],
          longitudes: [-103.39000, -103.35000]
        },
        {
          label: "Casa",
          latitudes: [20.76441, 20.76641],
          longitudes: [-103.42651, -103.40651]
        },
        // {
        //   label: "LocalHost test",
        //   latitudes: [20.16441, 20.96641],
        //   longitudes: [-103.92651, -103.10651]
        // }
      ],
    };
  },
  components: {
    AppLayout,
    PrimaryButton,
    SecondaryButton,
    Link,
  },
  // Modernized: Hook mounted para la transición de bienvenida
  mounted() {
    this.showWelcomeMessage = true;
    setTimeout(() => {
      this.showWelcomeMessage = false;
    }, 4000); // Modernized: El mensaje desaparecerá después de 3 segundos
  },
  methods: {
    getPosition() {
      // Limpiar mensaje anterior
      this.geolocation_message = { type: '', text: '' }; 

      if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(this.analyzePosition, this.error, this.geolocation_options);
      } else {
        // Modernized: Reemplazo de alert()
        this.geolocation_message = { type: 'error', text: 'Geolocalización no soportada por navegador.' };
      }
    },
    error(e) {
      // Modernized: Reemplazo de alert()
      this.geolocation_message = { type: 'error', text: `ERROR (${e.code}): ${e.message}` };
    },
    analyzePosition(current_position) {
      const validated_area = this.valid_areas.find(
        valid_area => this.isCurrentPositionInsideArea(valid_area, current_position
        ));

      if (validated_area !== undefined) {
        // Modernized: Reemplazo de alert()
        this.geolocation_message = { type: 'success', text: `Registro exitoso en: ${validated_area.label}` };
        this.$inertia.post(route('payroll.store-attendance'));
      } else {
        // Modernized: Reemplazo de alert()
        this.geolocation_message = { type: 'error', text: 'Ubicación no válida para registrar.' };
        // Opcional: Log para depuración
        console.error('Ubicación no válida: ', current_position.coords.latitude + ', ' + current_position.coords.longitude);
      }
    },
    isCurrentPositionInsideArea(valid_area, current_position) {
      var current_latitude = current_position.coords.latitude;
      var current_longitude = current_position.coords.longitude;

      if (
        this.between(current_latitude, valid_area.latitudes) &&
        this.between(current_longitude, valid_area.longitudes)
      )
        return valid_area;
      else
        return 0;
    },
    between(x, range) {
      return x >= range[0] && x <= range[1];
    },
  },
  props: {
    checked_in: Boolean,
    checked_out: Boolean,
    leaves: Array,
    notices: Array,
    loan: Object
  },
};
</script>

