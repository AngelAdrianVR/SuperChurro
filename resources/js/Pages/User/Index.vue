<template>
  <AppLayout title="Usuarios">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
        Usuarios
      </h2>
    </template>

    <div class="flex justify-end mb-3">
      <Link :href="route('users.create')">
        <PrimaryButton class="mr-7 mt-1"
          ><i class="fa-solid fa-plus mr-2"></i> Nuevo</PrimaryButton
        >
      </Link>
    </div>

    <div class="max-w-3xl w-full mx-auto z-10">
      <h2 class="text-gray1 mx-5">Usuarios activos</h2>
      <div class="flex flex-col">
        <UserCard  v-for="user in getActiveUsers()" :key="user" :user="user" />
      </div>
      <h2 class="text-gray1 mx-5 mt-4">Usuarios inactivos</h2>
      <div class="flex flex-col">
        <UserCard  v-for="user in getInactiveUsers()" :key="user" :user="user" />
      </div>
    </div>
  </AppLayout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import PayRollTable from "@/Components/PayRollTable.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import UserCard from "@/Components/MyComponents/User/UserCard.vue";
import { Link } from "@inertiajs/inertia-vue3";
export default {
  data() {
    return {};
  },
  components: {
    AppLayout,
    PayRollTable,
    PrimaryButton,
    UserCard,
    Link
  },
  methods: {
    getActiveUsers() {
      return this.users.data.filter(user => user.is_active);
    },
    getInactiveUsers() {
      return this.users.data.filter(user => !user.is_active);
    },
  },
  props: {
    users: Object,
  },
};
</script>
