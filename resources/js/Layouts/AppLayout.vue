<script setup>
import { ref } from "vue";
import { Inertia } from "@inertiajs/inertia";
import { Head, Link } from "@inertiajs/inertia-vue3";
import ApplicationMark from "@/Components/ApplicationMark.vue";
import Banner from "@/Components/Banner.vue";
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";
import NavLink from "@/Components/NavLink.vue";
import ResponsiveNavLink from "@/Components/ResponsiveNavLink.vue";

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
    label: "Solicitudes",
    route_name: "admin-requests.permits",
    is_active: route().current("admin-requests.*"),
  },
];

const menues = [
  {
    label: "Inicio",
    route_name: "dashboard",
    is_active: route().current("dashboard"),
    is_a: route().current("dashboard"),
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
    label: "Permutas",
    route_name: "barters.index",
    is_active: route().current("barters" + ".*"),
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

const showingNavigationDropdown = ref(false);

const switchToTeam = (team) => {
  Inertia.put(
    route("current-team.update"),
    {
      team_id: team.id,
    },
    {
      preserveState: false,
    }
  );
};

const logout = () => {
  Inertia.post(route("logout"));
};
</script>

<template>
  <div>
    <Head :title="title" />

    <Banner />

    <div class="min-h-screen bg-gray-200">
      <nav
        class="
          bg-gradient-to-tl
          from-stone-500
          to-stone-800
          border-b-2 border-gray-600
          shadow-md shadow-gray-500/100
        "
      >
        <!-- Primary Navigation Menu -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div class="flex justify-between h-16">
            <div class="flex">
              <!-- Logo -->
              <div class="shrink-0 flex items-center">
                <Link :href="route('dashboard')">
                  <ApplicationMark class="block h-9 w-auto" />
                </Link>
              </div>

              <!-- Navigation Links -->
              <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
               <template v-for="(menu, index) in menues" :key="index">
                <NavLink
                  v-if="menu.admin_can_see || !$page.props.user.is_admin"
                  :href="route(menu.route_name)"
                  :active="menu.is_active"
                >
                  {{ menu.label }}
                </NavLink>
               </template>
              </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ml-6">
              <div class="ml-3 relative">
                <!-- Teams Dropdown -->
                <Dropdown
                  v-if="$page.props.jetstream.hasTeamFeatures"
                  align="right"
                  width="60"
                >
                  <template #trigger>
                    <span class="inline-flex rounded-md">
                      <button
                        type="button"
                        class="
                          inline-flex
                          items-center
                          px-3
                          py-2
                          border border-transparent
                          text-sm
                          leading-4
                          font-medium
                          rounded-md
                          text-gray-500
                          bg-white
                          hover:bg-gray-50 hover:text-gray-700
                          focus:outline-none focus:bg-gray-50
                          active:bg-gray-50
                          transition
                        "
                      >
                        {{ $page.props.user.current_team.name }}

                        <svg
                          class="ml-2 -mr-0.5 h-4 w-4"
                          xmlns="http://www.w3.org/2000/svg"
                          viewBox="0 0 20 20"
                          fill="currentColor"
                        >
                          <path
                            fill-rule="evenodd"
                            d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"
                            clip-rule="evenodd"
                          />
                        </svg>
                      </button>
                    </span>
                  </template>

                  <template #content>
                    <div class="w-60">
                      <!-- Team Management -->
                      <template v-if="$page.props.jetstream.hasTeamFeatures">
                        <div class="block px-4 py-2 text-xs text-gray-400">
                          Manage Team
                        </div>

                        <!-- Team Settings -->
                        <DropdownLink
                          :href="
                            route('teams.show', $page.props.user.current_team)
                          "
                        >
                          Team Settings
                        </DropdownLink>

                        <DropdownLink
                          v-if="$page.props.jetstream.canCreateTeams"
                          :href="route('teams.create')"
                        >
                          Create New Team
                        </DropdownLink>

                        <div class="border-t border-gray-100" />

                        <!-- Team Switcher -->
                        <div class="block px-4 py-2 text-xs text-gray-400">
                          Switch Teams
                        </div>

                        <template
                          v-for="team in $page.props.user.all_teams"
                          :key="team.id"
                        >
                          <form @submit.prevent="switchToTeam(team)">
                            <DropdownLink as="button">
                              <div class="flex items-center">
                                <svg
                                  v-if="
                                    team.id == $page.props.user.current_team_id
                                  "
                                  class="mr-2 h-5 w-5 text-green-400"
                                  fill="none"
                                  stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  stroke="currentColor"
                                  viewBox="0 0 24 24"
                                >
                                  <path
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                                  />
                                </svg>
                                <div>{{ team.name }}</div>
                              </div>
                            </DropdownLink>
                          </form>
                        </template>
                      </template>
                    </div>
                  </template>
                </Dropdown>
              </div>

              <div class="mr-3 relative">
                <!-- admin menu -->
                <Dropdown
                  v-if="$page.props.user.is_admin"
                  align="right"
                  width="48"
                >
                  <template #trigger>
                    <button
                      class="text-white hover:border hover:rounded-full w-8 h-8"
                    >
                      <i class="fa-solid fa-user-gear"></i>
                    </button>
                  </template>
                  <template #content>
                    <div class="block px-4 py-2 text-xs text-gray-500">
                      Opciones de administrador
                    </div>
                    <DropdownLink
                      v-for="(admin_menu, index) in admin_menues"
                      :key="index"
                      :href="route(admin_menu.route_name)"
                    >
                      {{ admin_menu.label }}
                    </DropdownLink>
                  </template>
                </Dropdown>
              </div>
              <!-- Settings Dropdown -->
              <div class="ml-3 relative">
                <Dropdown align="right" width="48">
                  <template #trigger>
                    <button
                      v-if="$page.props.jetstream.managesProfilePhotos"
                      class="
                        flex
                        text-sm
                        border-2 border-transparent
                        rounded-full
                        focus:outline-none focus:border-gray-300
                        transition
                      "
                    >
                      <img
                        class="h-8 w-8 rounded-full object-cover"
                        :src="$page.props.user.profile_photo_url"
                        :alt="$page.props.user.name"
                      />
                    </button>

                    <span v-else class="inline-flex rounded-md">
                      <button
                        type="button"
                        class="
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
                        "
                      >
                        {{ $page.props.user.name }}

                        <svg
                          class="ml-2 -mr-0.5 h-4 w-4"
                          xmlns="http://www.w3.org/2000/svg"
                          viewBox="0 0 20 20"
                          fill="currentColor"
                        >
                          <path
                            fill-rule="evenodd"
                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                            clip-rule="evenodd"
                          />
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

                    <DropdownLink
                      v-if="$page.props.jetstream.hasApiFeatures"
                      :href="route('api-tokens.index')"
                    >
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
              <button
                class="
                  inline-flex
                  items-center
                  justify-center
                  p-2
                  rounded-md
                  text-gray-300
                  hover:text-gray-500 hover:bg-gray-100
                  focus:outline-none focus:bg-gray-100 focus:text-gray-500
                  transition
                "
                @click="showingNavigationDropdown = !showingNavigationDropdown"
              >
                <svg
                  class="h-6 w-6"
                  stroke="currentColor"
                  fill="none"
                  viewBox="0 0 24 24"
                >
                  <path
                    :class="{
                      hidden: showingNavigationDropdown,
                      'inline-flex': !showingNavigationDropdown,
                    }"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M4 6h16M4 12h16M4 18h16"
                  />
                  <path
                    :class="{
                      hidden: !showingNavigationDropdown,
                      'inline-flex': showingNavigationDropdown,
                    }"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M6 18L18 6M6 6l12 12"
                  />
                </svg>
              </button>
            </div>
          </div>
        </div>

        <!-- Responsive Navigation Menu -->
        <div
          :class="{
            block: showingNavigationDropdown,
            hidden: !showingNavigationDropdown,
          }"
          class="sm:hidden"
        >
          <div class="pt-2 pb-3 space-y-1">
            <template v-for="(menu, index) in menues" :key="index">
                <ResponsiveNavLink
                  v-if="menu.admin_can_see || !$page.props.user.is_admin"
                  :href="route(menu.route_name)"
                  :active="menu.is_active"
                >
                  {{ menu.label }}
                </ResponsiveNavLink>
               </template>

            <!-- admin menu -->
            <div
              v-if="$page.props.user.is_admin"
              class="pt-2 pb-1 border-t border-gray-200"
            >
              <p class="text-gray-200 text-xs text-center">
                <i class="fa-solid fa-user-gear mr-2"></i>
                Opciones de administrador
              </p>
              <ResponsiveNavLink
                v-for="(admin_menu, index) in admin_menues"
                :key="index"
                :href="route(admin_menu.route_name)"
                :active="admin_menu.is_active"
              >
                {{ admin_menu.label }}
              </ResponsiveNavLink>
            </div>
          </div>

          <!-- Responsive Settings Options -->
          <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="flex items-center px-4">
              <div
                v-if="$page.props.jetstream.managesProfilePhotos"
                class="shrink-0 mr-3"
              >
                <img
                  class="h-10 w-10 rounded-full object-cover"
                  :src="$page.props.user.profile_photo_url"
                  :alt="$page.props.user.name"
                />
              </div>

              <div>
                <div class="font-medium text-base text-gray-200">
                  {{ $page.props.user.name }}
                </div>
                <div class="font-medium text-sm text-gray-400">
                  {{ $page.props.user.email }}
                </div>
              </div>
            </div>

            <div class="mt-3 space-y-1">
              <ResponsiveNavLink
                :href="route('profile.show')"
                :active="route().current('profile.show')"
              >
                Perfil
              </ResponsiveNavLink>

              <ResponsiveNavLink
                v-if="$page.props.jetstream.hasApiFeatures"
                :href="route('api-tokens.index')"
                :active="route().current('api-tokens.index')"
              >
                API Tokens
              </ResponsiveNavLink>

              <!-- Authentication -->
              <form method="POST" @submit.prevent="logout">
                <ResponsiveNavLink as="button">
                  Cerrar sesión
                </ResponsiveNavLink>
              </form>

              <!-- Team Management -->
              <template v-if="$page.props.jetstream.hasTeamFeatures">
                <div class="border-t border-gray-200" />

                <div class="block px-4 py-2 text-xs text-gray-400">
                  Manage Team
                </div>

                <!-- Team Settings -->
                <ResponsiveNavLink
                  :href="route('teams.show', $page.props.user.current_team)"
                  :active="route().current('teams.show')"
                >
                  Team Settings
                </ResponsiveNavLink>

                <ResponsiveNavLink
                  v-if="$page.props.jetstream.canCreateTeams"
                  :href="route('teams.create')"
                  :active="route().current('teams.create')"
                >
                  Create New Team
                </ResponsiveNavLink>

                <div class="border-t border-gray-200" />

                <!-- Team Switcher -->
                <div class="block px-4 py-2 text-xs text-gray-400">
                  Switch Teams
                </div>

                <template
                  v-for="team in $page.props.user.all_teams"
                  :key="team.id"
                >
                  <form @submit.prevent="switchToTeam(team)">
                    <ResponsiveNavLink as="button">
                      <div class="flex items-center">
                        <svg
                          v-if="team.id == $page.props.user.current_team_id"
                          class="mr-2 h-5 w-5 text-green-400"
                          fill="none"
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          stroke="currentColor"
                          viewBox="0 0 24 24"
                        >
                          <path
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                          />
                        </svg>
                        <div>{{ team.name }}</div>
                      </div>
                    </ResponsiveNavLink>
                  </form>
                </template>
              </template>
            </div>
          </div>
        </div>
      </nav>

      <!-- Page Heading -->
      <header
        v-if="$slots.header"
        class="bg-gray-300 shadow-md shadow-gray-400 rounded-b-xl"
      >
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
