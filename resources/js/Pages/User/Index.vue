<template>
  <AppLayout title="Usuarios">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 dar:text-gray-200 leading-tight text-center">
        Usuarios
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        
        <!-- Botón de Nuevo Usuario -->
        <div class="flex justify-end mb-6 px-4 sm:px-0">
          <Link :href="route('users.create')">
            <PrimaryButton>
              <i class="fa-solid fa-plus mr-2"></i> Nuevo Usuario
            </PrimaryButton>
          </Link>
        </div>

        <!-- Tarjeta de Usuarios Activos -->
        <div class="bg-white dar:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
          <div class="p-6 sm:px-8 bg-white dar:bg-gray-800 border-b border-gray-200 dar:border-gray-700">
            <h3 class="text-lg font-medium text-gray-900 dar:text-gray-100">
              Usuarios activos
            </h3>
          </div>
          <div class="flex flex-col divide-y divide-gray-200 dar:divide-gray-700">
            <UserCard v-for="user in getActiveUsers()" :key="user.id" :user="user" />
            <div v-if="getActiveUsers().length === 0" class="px-6 sm:px-8 py-6 text-center text-gray-500 dar:text-gray-400">
              No se encontraron usuarios activos.
            </div>
          </div>
        </div>

        <!-- Tarjeta de Usuarios Inactivos -->
        <div class="mt-8 bg-white dar:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
          <div class="p-6 sm:px-8 bg-white dar:bg-gray-800 border-b border-gray-200 dar:border-gray-700">
            <h3 class="text-lg font-medium text-gray-900 dar:text-gray-100">
              Usuarios inactivos
            </h3>
          </div>
          <div class="flex flex-col divide-y divide-gray-200 dar:divide-gray-700">
            <UserCard v-for="user in getInactiveUsers()" :key="user.id" :user="user" />
            <div v-if="getInactiveUsers().length === 0" class="px-6 sm:px-8 py-6 text-center text-gray-500 dar:text-gray-400">
              No se encontraron usuarios inactivos.
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
import UserCard from "@/Components/MyComponents/User/UserCard.vue";
import { Link } from "@inertiajs/inertia-vue3";

// El componente PayRollTable no se usa en el template, se podría quitar si no es necesario.
// import PayRollTable from "@/Components/PayRollTable.vue"; 

export default {
  data() {
    return {};
  },
  components: {
    AppLayout,
    // PayRollTable,
    PrimaryButton,
    UserCard,
    Link,
  },
  methods: {
    getActiveUsers() {
      // Asegurarse de que users.data exista antes de filtrar
      return this.users?.data?.filter((user) => user.is_active) || [];
    },
    getInactiveUsers() {
      return this.users?.data?.filter((user) => !user.is_active) || [];
    },
  },
  props: {
    users: Object,
  },
};
</script>

