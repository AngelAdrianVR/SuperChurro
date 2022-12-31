<template>
    <AppLayout title="Usuarios">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Usuarios
            </h2>
        </template>

        <div class="flex justify-end">
            <!-- <Link :href="route('guest.create')"> -->
            <SecondaryButton class="mr-7 mt-4">Crear nuevo</SecondaryButton>
            <!-- </Link> -->
        </div>

        <div class="max-w-3xl w-full mx-auto z-10">
            <div class="flex flex-col">
                <div class="bg-white border border-white shadow-lg rounded-2xl p-2 m-4">
                    <div class="flex">
                        <div class="relative h-16 w-16 mr-2">
                            <img src="https://tailwindcomponents.com/storage/avatars/njkIbPhyZCftc4g9XbMWwVsa7aGVPajYLRXhEeoo.jpg"
                                class="w-16 h-16 object-cover rounded-2xl">
                        </div>
                       <section class="flex flex-col flex-1">
                        <div class="flex justify-between">
                            <h1 class="text-xs font-bold">Nombre</h1>
                            <span class="bg-green-100 text-green-700 text-xs px-2 py-px rounded-lg">Activo</span>
                        </div>
                            <p class="text-xs text-gray-500">T/Matutino | Ingresó el 17 Nov., 2022</p>
                            <p class="text-xs text-gray-500">
                                <i class="fa-solid fa-mobile-screen-button mr-1"></i>
                                33 3303 4738
                            </p>
                            <p class="text-xs text-gray-500">
                                <i class="fa-regular fa-envelope mr-1"></i>
                                miguel@gmail.com
                            </p>
                       </section>
                    </div>
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
  