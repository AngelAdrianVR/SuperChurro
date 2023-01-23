
<template>
  <AppLayout title="Dashboard">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Inicio</h2>
    </template>
    <h1 class="text-gray-600 text-center py-6 text-6xl"> En desarrollo </h1>
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