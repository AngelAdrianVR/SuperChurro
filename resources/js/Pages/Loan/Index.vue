<template>
  <AppLayout title="Préstamos">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Préstamos
      </h2>
    </template>

    <div class="flex justify-end">
      <!-- <Link :href="route('guest.create')"> -->
      <SecondaryButton class="mr-7 mt-4">Solicitar Préstamo</SecondaryButton>
      <!-- </Link> -->
    </div>

    <div class="globe-container">
      <div class="globe">
        <div class="globe-title !justify-between">
          <p>6-Ene-2022</p>
          <i class="fa-solid fa-trash text-red-600"></i>
        </div>
        <div class="flex flex-col">
           <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptatibus a
            ipsum qui, nisi laboriosam quas sint laborum sed minima, nihil
            voluptatem nemo velit at numquam necessitatibus voluptatum magni facere
            illum.
            </p>
            <span class="text-orange-600 mt-2"><i class="fa-solid fa-hourglass-start mr-2"></i>Revisando.</span>  
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import PayRollTable from "@/Components/PayRollTable.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import { Link } from "@inertiajs/inertia-vue3";
export default {
  data() {
    return {};
  },
  components: {
    AppLayout,
    PayRollTable,
    SecondaryButton,
    Link,
  },
  props: {},
};
</script>
