<template>
  <AppLayout title="Historial de ventas">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Historial de ventas
      </h2>
    </template>

  </AppLayout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import { Link } from "@inertiajs/inertia-vue3";
import ConfirmationModal from "@/Components/ConfirmationModal.vue";
export default {
  data() {
    return {

      }
  },
  components: {
    AppLayout,
    SecondaryButton,
    Link,
    ConfirmationModal,
  },
  props: {

  },
  methods: {
    
},
};
</script>
