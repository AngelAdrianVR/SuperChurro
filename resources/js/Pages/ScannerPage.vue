<template>
  <div class="flex flex-col">
    <div>
      <QrScanner />
    </div>
    <div class="mt-36 mx-auto">
        <a :href="route('dashboard')">
      <PrimaryButton>Cancelar</PrimaryButton>
        </a>   
    </div>
  </div>
</template>

<script>
import PrimaryButton from "@/Components/PrimaryButton.vue";
import QrScanner from "@/Components/QrScanner.vue";
import { Link } from "@inertiajs/inertia-vue3";
export default {
  data() {
    return {};
  },
  components: {
    QrScanner,
    PrimaryButton,
    Link,
  },
  props: {},
};
</script>
