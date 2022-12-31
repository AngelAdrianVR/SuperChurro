<template>
    <AppLayout title="Permutas">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Permutas
            </h2>
        </template>

        <div class="flex justify-end">
            <!-- <Link :href="route('guest.create')"> -->
            <SecondaryButton class="mr-7 mt-4">Publicar permuta</SecondaryButton>
            <!-- </Link> -->
        </div>

        <div class="globe-container">
            <div class="globe">
                <div class="globe-title !justify-between">
                    <div class="flex flex-col text-left">
                        <p>Permuta para el 6-Ene-2022 - T/Matutino</p>
                        <small class="text-gray-500">Publicado el 15 Dic, 2022</small>
                    </div>
                    <i class="fa-solid fa-trash text-red-600"></i>
                </div>
                <span class="text-orange-600 mt-2 text-xs">
                    <i class="fa-solid fa-hourglass-start mr-2"></i>Esperando interesada(a).
                </span>
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
  