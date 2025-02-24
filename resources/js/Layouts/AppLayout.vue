<script setup>
import { ref, onMounted, onUnmounted } from "vue";
import { Inertia } from "@inertiajs/inertia";
import { Head, Link } from "@inertiajs/inertia-vue3";
import ApplicationMark from "@/Components/ApplicationMark.vue";
import Banner from "@/Components/Banner.vue";
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";
import NavLink from "@/Components/NavLink.vue";
import ResponsiveNavLink from "@/Components/ResponsiveNavLink.vue";
import { syncIDBProducts } from '@/dbService.js';

defineProps({
  title: String,
});

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
  // {
  //   label: "Permutas",
  //   route_name: "barters.index",
  //   is_active: route().current("barters" + ".*"),
  //   admin_can_see: false,
  // },
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
  // {
  //   label: "Egresos",
  //   route_name: "outcomes.index",
  //   is_active: route().current("outcomes.*"),
  //   admin_can_see: false,
  // },

];

const showingNavigationDropdown = ref(false);
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

    <div class="min-h-screen bg-gray-50">
      <nav class="
          bg-transparent border-b pb-4
        ">
        <!-- Primary Navigation Menu -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-12">
          <div class="flex justify-between h-16">
            <div class="flex justify-between">
              <!-- Logo -->
              <div class="shrink-0 flex items-center pt-8">
                <Link :href="route('dashboard')">
                <ApplicationMark class="block h-9 w-auto" />
                </Link>
              </div>

              <!-- Navigation Links -->
              <div class="hidden space-x-3 sm:-my-px sm:ml-24 sm:flex">
                <template v-for="(menu, index) in menues" :key="index">
                  <NavLink v-if="menu.admin_can_see || !$page.props.user.is_admin" :href="route(menu.route_name)"
                    :active="menu.is_active">
                    {{ menu.label }}
                  </NavLink>
                </template>
              </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ml-6">
              <div class="mr-3 relative">
                <!-- admin menu -->
                <Dropdown v-if="$page.props.user.is_admin" align="right" width="48">
                  <template #trigger>
                    <button class="text-white hover:bg-gray4 hover:rounded-full w-8 h-8">
                      <i class="fa-solid fa-user-gear text-gray-500"></i>
                    </button>
                  </template>
                  <template #content>
                    <div class="block px-4 py-2 text-xs text-gray-500">
                      Opciones de administrador
                    </div>
                    <DropdownLink v-for="(admin_menu, index) in admin_menues" :key="index"
                      :href="route(admin_menu.route_name)">
                      {{ admin_menu.label }}
                    </DropdownLink>
                  </template>
                </Dropdown>
              </div>
              <!-- Settings Dropdown -->
              <div class="ml-3 relative">
                <Dropdown align="right" width="48">
                  <template #trigger>
                    <button v-if="$page.props.jetstream.managesProfilePhotos" class="
                        flex
                        text-sm
                        border-2 border-transparent
                        rounded-full
                        focus:outline-none focus:border-gray-300
                        transition
                      ">
                      <img class="h-8 w-8 rounded-full object-cover" :src="$page.props.user.profile_photo_url"
                        :alt="$page.props.user.name" />
                    </button>

                    <span v-else class="inline-flex rounded-md">
                      <button type="button" class="
                          inline-flex
                          items-center
                          px-3
                          py-2
                          border border-transparent
                          text-sm
                          leading-4
                          font-medium
                          rounded-md
                          text-gray-600
                          bg-gray-300
                          hover:text-gray-900
                          focus:outline-none
                          transition
                        ">
                        {{ $page.props.user.name }}

                        <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                          fill="currentColor">
                          <path fill-rule="evenodd"
                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                            clip-rule="evenodd" />
                        </svg>
                      </button>
                    </span>
                  </template>

                  <template #content>
                    <!-- Account Management -->
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

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
              <button class="
                  inline-flex
                  items-center
                  justify-center
                  p-2
                  rounded-md
                  text-gray-500
                  focus:outline-none focus:bg-gray4 focus:text-gray-500
                  transition ease-in-out delay-150
                " @click="showingNavigationDropdown = !showingNavigationDropdown">
                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                  <path :class="{
                    hidden: showingNavigationDropdown,
                    'inline-flex': !showingNavigationDropdown,
                  }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                  <path :class="{
                    hidden: !showingNavigationDropdown,
                    'inline-flex': showingNavigationDropdown,
                  }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
              </button>
            </div>
          </div>
        </div>

        <!-- Responsive Navigation Menu -->
        <div :class="{
          block: showingNavigationDropdown,
          hidden: !showingNavigationDropdown,
        }"
          class="sm:hidden z-40 rounded-tl-[6px] rounded-bl-[6px] bg-gray-50 w-4/6 absolute right-0 top-14 min-h-[50%] max-h-[90%] overflow-y-scroll overflow-x-hidden shadow-lg border border-gray4 pt-4">

          <!-- User info -->
          <div class="pb-4 mb-4 border-b border-gray-200">
            <div @click="$inertia.get(route('profile.show'))" class="flex flex-col items-center justify-center mx-4">
              <img class="h-14 w-14 rounded-full object-cover mx-auto" :src="$page.props.user.profile_photo_url"
                :alt="$page.props.user.name">
              <div class="font-semibold text-center text-base text-gray-600 w-full truncate">
                {{ $page.props.user.name }}
              </div>
              <div class="font-medium text-center text-sm text-gray-500 w-full truncate">
                {{ $page.props.user.email }}
              </div>
            </div>
          </div>

          <div class="pt-2 pb-3 space-y-1">
            <template v-for="(menu, index) in menues" :key="index">
              <ResponsiveNavLink v-if="menu.admin_can_see || !$page.props.user.is_admin" :href="route(menu.route_name)"
                :active="menu.is_active">
                {{ menu.label }}
              </ResponsiveNavLink>
            </template>

            <!-- admin menu -->
            <div v-if="$page.props.user.is_admin" class="pt-2 pb-1 border-t border-primary">
              <p class="text-gray-400 text-xs text-center">
                <i class="fa-solid fa-user-gear mr-2"></i>
                Opciones de administrador
              </p>
              <ResponsiveNavLink v-for="(admin_menu, index) in admin_menues" :key="index"
                :href="route(admin_menu.route_name)" :active="admin_menu.is_active">
                {{ admin_menu.label }}
              </ResponsiveNavLink>
            </div>
          </div>

          <!-- Responsive Settings Options -->
          <div class="pb-1 border-t border-gray4">

            <div class="my-1">
              <!-- Authentication -->
              <form method="POST" @submit.prevent="logout" class="text-red-500 text-right px-2">
                <button>
                  <i class="fa-solid fa-arrow-right-from-bracket mr-[7px]"></i> Cerrar sesión
                </button>
              </form>
            </div>
          </div>
        </div>
      </nav>

      <!-- Page Heading -->
      <header v-if="$slots.header" class="bg-transparent rounded-b-xl">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
          <slot name="header" />
        </div>
      </header>

      <!-- Page Content -->
      <main>
        <slot />
      </main>
    </div>
  </div>
</template>
