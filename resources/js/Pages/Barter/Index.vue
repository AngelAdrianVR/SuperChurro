<template>
    <AppLayout title="Permutas">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Permutas
            </h2>
        </template>

        <div class="flex items-center justify-between ml-4">
            <div class="relative z-0 mb-6 w-1/2 mt-7">
          <input
            v-model="form.date"
            type="date"
            name="floating_date"
            autocomplete="off"
            class="
              block
              py-2.5
              px-0
              w-full
              text-sm text-gray-900
              bg-transparent
              border-0 border-b-2 border-gray-300
              appearance-none
              dark:text-white dark:border-gray-600 dark:focus:border-stone-500
              focus:outline-none focus:ring-0 focus:border-stone-600
              peer
            "
            placeholder=" "
          />
          <label
            for="floating_date"
            class="
              absolute
             text-gray-500
              dark:text-gray-400
              duration-300
              transform
              -translate-y-6
              scale-75
              top-3
              -z-10
              origin-[0]
              peer-focus:left-0
              peer-focus:text-stone-600
              peer-focus:dark:text-stone-500
              peer-placeholder-shown:scale-100
              peer-placeholder-shown:translate-y-0
              peer-focus:scale-75 peer-focus:-translate-y-6
            "
            >Fecha de permuta</label
          >
        </div>

            <SecondaryButton @click="store" class="mr-7 mt-4">Publicar</SecondaryButton>
        </div>

        <div class="globe-container">
            <div class="globe">
                <div class="globe-title !justify-between">
                    <div class="flex flex-col text-left">
                        <p>Permuta para el {{'6-Ene-2022'}} - T/Matutino</p>
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
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
export default {
    data() {
        const form = useForm({
      date: null,
    });
        return {
            form,
        };
    },
    components: {
        AppLayout,
        PayRollTable,
        SecondaryButton,
        Link,
        useForm,
    },
    props: {

    },
    methods:{
        store(){
            this.form.post(this.route("barters.store"));
        }
    }
};
</script>
  