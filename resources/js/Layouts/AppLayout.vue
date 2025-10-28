<script setup>
import { ref, onMounted, onUnmounted } from "vue";
import { Inertia } from "@inertiajs/inertia";
import { Head, Link } from "@inertiajs/inertia-vue3";
import ApplicationMark from "@/Components/ApplicationMark.vue";
import Banner from "@/Components/Banner.vue";
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";
// Importamos el nuevo Sidebar
import Sidebar from "@/Components/MyComponents/Sidebar.vue";
// NavLink y ResponsiveNavLink ya no se usarán aquí, el Sidebar maneja sus links
import { syncIDBProducts } from '@/dbService.js';

defineProps({
  title: String,
});

// --- Estado del Sidebar ---
// Inicia abierto en desktop, cerrado en móvil (controlado por CSS)
const sidebarOpen = ref(false);

// (El resto de tu lógica de <script setup> se mantiene)

const admin_menues = [
  {
    label: "Historial de ventas",
    route_name: "sales.index",
    is_active: route().current("sales" + ".*"),
  },
  {
    label: "Configuraciones",
    route_name: "settings.index",
    is_active: route().current("settings" + ".*"),
  },
  {
    label: "Usuarios",
    route_name: "users.index",
    is_active: route().current("users.*"),
  },
  {
    label: "Productos",
    route_name: "products.index",
    is_active: route().current("products.*"),
  },
  {
    label: "Consumibles",
    route_name: "consumables.index",  
    is_active: route().current("consumables.*"),
  },
  {
    label: "Permisos",
    route_name: "admin-requests.permits",
    is_active: route().current("admin-permits.*"),
  },
  {
    label: "Préstamos",
    route_name: "admin-requests.loans",
    is_active: route().current("admin-loans.*"),
  },
  {
    label: "Nóminas",
    route_name: "payroll-admin.index",
    is_active: route().current("payroll-admin.*"),
  },
  {
    label: "Avisos",
    route_name: "notices.index",
    is_active: route().current("notices.*"),
  },
  {
    label: "Bonos",
    route_name: "bonuses.index",
    is_active: route().current("bonuses.*"),
  },
  {
    label: "Egresos",
    route_name: "outcomes.index",
    is_active: route().current("outcomes.*"),
  },
];

const menues = [
  {
    label: "Inicio",
    route_name: "dashboard",
    is_active: route().current("dashboard"),
    admin_can_see: true,
  },
  {
    label: "Punto de venta",
    route_name: "sales.point",
    is_active: route().current("sales.point"),
    admin_can_see: true,
  },
  {
    label: "Nóminas",
    route_name: "payrolls.index",
    is_active: route().current("payrolls" + ".*"),
    admin_can_see: false,
  },
  {
    label: "Permisos",
    route_name: "work-permits.index",
    is_active: route().current("work-permits" + ".*"),
    admin_can_see: false,
  },
  {
    label: "Préstamos",
    route_name: "loans.index",
    is_active: route().current("loans" + ".*"),
    admin_can_see: false,
  },
  {
    label: "Cocina",
    route_name: "warehouses.index",
    is_active: route().current("warehouses" + ".*"),
    admin_can_see: true,
  },
  {
    label: "Carrito",
    route_name: "carts.index",
    is_active: route().current("carts" + ".*"),
    admin_can_see: true,
  },
];

const syncInterval = ref(null);

const logout = () => {
  Inertia.post(route("logout"));
};

onMounted(() => {
    // sincronizacion periodica de IDB para todos los usuarios autenticados
    syncInterval.value = setInterval(() => {
        syncIDBProducts();
    }, 300000); // 5 minutos
});

onUnmounted(() => {
    // Limpiar el intervalo cuando el componente se desmonte
    clearInterval(syncInterval.value);
});

</script>

<template>
  <div>
    <Head :title="title" />
    <Banner />

    <!-- 
      NUEVA ESTRUCTURA:
      1. Sidebar (fijo)
      2. Overlay (fijo, solo móvil)
      3. Contenedor Principal (con margen dinámico)
    -->

    <!-- 1. Sidebar -->
    <Sidebar 
      :menues="menues" 
      :admin-menues="admin_menues" 
      :user="$page.props.user" 
      :sidebar-open="sidebarOpen"
      @close-sidebar="sidebarOpen = false"
    />

    <!-- 2. Overlay para móvil -->
    <!-- Aparece cuando el sidebar está abierto en pantallas < md -->
    <div
      v-if="sidebarOpen"
      class="fixed inset-0 z-30 bg-black/50 md:hidden"
      @click="sidebarOpen = false"
    />

    <!-- 3. Contenedor Principal -->
    <div
      :class="[
        'flex min-h-screen flex-col bg-gray-50 transition-all duration-300 ease-in-out',
        { 'md:ml-64': sidebarOpen } // Aplica margen en desktop si el sidebar está abierto
      ]"
    >
      <!-- Barra de Navegación Superior (Header) -->
      <nav class="sticky top-0 z-20 border-b border-gray-100 bg-white shadow-sm">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <div class="flex h-16 justify-between">

            <!-- Izquierda: Botón Hamburguesa -->
            <div class="flex items-center">
              <button
                class="rounded-md p-2 text-gray-500 transition hover:bg-gray-100 hover:text-gray-600 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500"
                @click="sidebarOpen = !sidebarOpen"
              >
                <span class="sr-only">Abrir/Cerrar menú</span>
                <!-- Icono Hamburguesa -->
                <svg vNext="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" class="h-6 w-6">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                </svg>
              </button>
            </div>

            <!-- Derecha: Dropdowns de Admin y Usuario -->
            <div class="ml-6 flex items-center">
              <!-- Settings Dropdown -->
              <div class="relative ml-3">
                <Dropdown align="right" width="48">
                  <template #trigger>
                    <button v-if="$page.props.jetstream.managesProfilePhotos" class="flex rounded-full border-2 border-transparent text-sm transition focus:border-gray-300 focus:outline-none">
                      <img class="h-8 w-8 rounded-full object-cover" :src="$page.props.user.profile_photo_url" :alt="$page.props.user.name">
                    </button>
                    <span v-else class="inline-flex rounded-md">
                      <button type="button" class="inline-flex items-center rounded-md border border-transparent bg-white px-3 py-2 text-sm font-medium leading-4 text-gray-600 transition hover:text-gray-900 focus:outline-none">
                        {{ $page.props.user.name }}
                        <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                          <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                      </button>
                    </span>
                  </template>

                  <template #content>
                    <div class="block px-4 py-2 text-xs text-gray-500">
                      Administrador de cuenta
                    </div>
                    <DropdownLink :href="route('profile.show')">
                      Perfil
                    </DropdownLink>
                    <DropdownLink v-if="$page.props.jetstream.hasApiFeatures" :href="route('api-tokens.index')">
                      API Tokens
                    </DropdownLink>
                    <div class="border-t border-gray-100" />
                    <!-- Authentication -->
                    <form @submit.prevent="logout">
                      <DropdownLink as="button"> Cerrar sesión </DropdownLink>
                    </form>
                  </template>
                </Dropdown>
              </div>
            </div>
          </div>
        </div>
      </nav>

      <!-- Page Heading -->
      <header v-if="$slots.header" class="bg-white">
        <div class="mx-auto max-w-7xl py-6 px-4 sm:px-6 lg:px-8">
          <slot name="header" />
        </div>
      </header>

      <!-- Page Content -->
      <main class="flex-1">
        <!-- El padding/margen del contenido principal debe ir en las vistas hijas -->
        <slot />
      </main>
    </div>
  </div>
</template>
