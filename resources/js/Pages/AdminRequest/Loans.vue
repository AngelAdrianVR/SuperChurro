<template>
  <AppLayout title="Solicitudes">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Solicitudes de Empleados
      </h2>
    </template>

    <Tabs :tabs="tabs" />

    Préstamos.

  </AppLayout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import { Link } from "@inertiajs/inertia-vue3";
import ConfirmationModal from "@/Components/ConfirmationModal.vue";
import Tabs from "@/Components/Tabs.vue";
export default {
  data() {
    return {
        tabs: [
        {
          label: "Permisos",
          url: "admin-requests.permits",
        },
        {
          label: "Préstamos",
          url: "admin-requests.loans",
        },
      ],
      }
  },
  components: {
    AppLayout,
    SecondaryButton,
    Link,
    ConfirmationModal,
    Tabs,
  },
  props: {

  },
  methods: {
    
},
};
</script>
