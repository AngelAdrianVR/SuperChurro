<template>
  <AppLayout title="Corte">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Hacer corte
      </h2>
    </template>

    <div class=" bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md" role="alert">
  <div class="flex">
    <div class="py-1"><svg class="fill-current h-6 w-6 text-teal-500 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"/></svg></div>
    <div>
      <p class="font-bold">Atención</p>
      <p class="text-sm">Colocar el <strong>sobrante</strong> de productos en los siguientes campos:</p>
    </div>
  </div>
</div>

    <div class="flex justify-start">
      <Link
        :href="route('carts.index')"
        class="flex items-center mt-2 text-slate-700"
      >
        <i
          class="
            fas
            fa-long-arrow-alt-left
            text-lg
            active:bg-gray-300
            bg-opacity-100
            rounded-full
            w-7
            h-7
            pl-1
            ml-2
          "
        ></i>
        <span class="ml-1 cursor-default">Atrás</span>
      </Link>
    </div>

    <!-- component -->
    <!-- This is an example component -->
    <div
      class="
        max-w-2xl
        md:mx-auto
        mt-5
        shadow-md shadow-gray-500/70
        rounded-lg
        px-5
        py-8
        bg-white
        mx-4
      "
    >
      <form @submit.prevent="store">
      <div class="grid grid-cols-2 gap-3">
      
      
        <div class="relative z-0 mb-2 w-full group">
          <input
            v-model="form.churro_relleno"
            type="number"
            name="floating_churro_relleno"
            autocomplete="off"
            required
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
            for="floating_churro_relleno"
            class="
              absolute
              text-sm text-gray-500
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
            >Curro Relleno</label
          >
          <InputError :message="$page.props?.errors.churro_relleno" />
        </div>

        <div class="relative z-0 mb-2 w-full group">
          <input
            v-model="form.churro_natural"
            type="number"
            name="floating_churro_natural"
            autocomplete="off"
            required
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
            for="floating_churro_natural"
            class="
              absolute
              text-sm text-gray-500
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
            >Churro Natural</label
          >
          <InputError :message="$page.props?.errors.churro_natural" />
        </div>

        <div class="relative z-0 mb-2 w-full group">
          <input
            v-model="form.botana"
            type="number"
            name="floating_botana"
            autocomplete="off"
            required
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
            for="floating_botana"
            class="
              absolute
              text-sm text-gray-500
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
            >Botanas</label
          >
          <InputError :message="$page.props?.errors.botana" />
        </div>

        <div class="relative z-0 mb-2 w-full group">
          <input
            v-model="form.bolis"
            type="number"
            name="floating_bolis"
            autocomplete="off"
            required
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
            for="floating_bolis"
            class="
              absolute
              text-sm text-gray-500
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
            >Bolis</label
          >
          <InputError :message="$page.props?.errors.bolis" />
        </div>

        <div class="relative z-0 mb-2 w-full group">
          <input
            v-model="form.choco_churro"
            type="number"
            name="floating_choco_churro"
            autocomplete="off"
            required
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
            for="floating_choco_churro"
            class="
              absolute
              text-sm text-gray-500
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
            >Choco Churro</label
          >
          <InputError :message="$page.props?.errors.choco_churro" />
        </div>

        <div class="relative z-0 mb-2 w-full group">
          <input
            v-model="form.lechuguilla"
            type="number"
            name="floating_lechuguilla"
            autocomplete="off"
            required
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
            for="floating_lechuguilla"
            class="
              absolute
              text-sm text-gray-500
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
            >Lechuguilla</label
          >
          <InputError :message="$page.props?.errors.lechuguilla" />
        </div>

        <div class="relative z-0 mb-2 w-full group">
          <input
            v-model="form.agua"
            type="number"
            name="floating_agua"
            autocomplete="off"
            required
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
            for="floating_agua"
            class="
              absolute
              text-sm text-gray-500
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
            >Aguas</label
          >
          <InputError :message="$page.props?.errors.agua" />
        </div>

        <div class="relative z-0 mb-2 w-full group">
          <input
            v-model="form.refresco"
            type="number"
            name="floating_refresco"
            autocomplete="off"
            required
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
            for="floating_refresco"
            class="
              absolute
              text-sm text-gray-500
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
            >Refrescos</label
          >
          <InputError :message="$page.props?.errors.refresco" />
        </div>

        <div class="relative z-0 mb-2 w-full group">
          <input
            v-model="form.plato"
            type="number"
            name="floating_plato"
            autocomplete="off"
            required
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
            for="floating_plato"
            class="
              absolute
              text-sm text-gray-500
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
            >Platos</label
          >
          <InputError :message="$page.props?.errors.plato" />
        </div>

        <div class="relative z-0 mb-2 w-full group">
          <input
            v-model="form.tostilocos"
            type="number"
            name="floating_tostilocos"
            autocomplete="off"
            required
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
            for="floating_tostilocos"
            class="
              absolute
              text-sm text-gray-500
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
            >Tostilocos</label
          >
          <InputError :message="$page.props?.errors.tostilocos" />
        </div>

        <div class="relative z-0 mb-2 w-full group">
          <input
            v-model="form.churro_nieve"
            type="number"
            name="floating_churro_nieve"
            autocomplete="off"
            required
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
            for="floating_churro_nieve"
            class="
              absolute
              text-sm text-gray-500
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
            >Churro Nieve</label
          >
          <InputError :message="$page.props?.errors.churro_nieve" />
        </div>

        <div class="relative z-0 mb-2 w-full group">
          <input
            v-model="form.hersheys"
            type="number"
            name="floating_hersheys"
            autocomplete="off"
            required
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
            for="floating_hersheys"
            class="
              absolute
              text-sm text-gray-500
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
            >Hershey's</label
          >
          <InputError :message="$page.props?.errors.hersheys" />
        </div>

        <div class="relative z-0 mb-2 w-full group">
          <input
            v-model="form.coca"
            type="number"
            name="floating_coca"
            autocomplete="off"
            required
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
            for="floating_coca"
            class="
              absolute
              text-sm text-gray-500
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
            >Cocas</label
          >
          <InputError :message="$page.props?.errors.coca" />
        </div>

        <div class="relative z-0 mb-2 w-full group">
          <input
            v-model="form.papas"
            type="number"
            name="floating_papas"
            autocomplete="off"
            required
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
            for="floating_papas"
            class="
              absolute
              text-sm text-gray-500
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
            >Papas</label
          >
          <InputError :message="$page.props?.errors.papas" />
        </div>
        
        </div>
        
        <div class="flex justify-center lg:justify-end mt-5">
          <PrimaryButton :disabled="form.processing">Hacer corte</PrimaryButton>
        </div>
      </form>
    </div>
  </AppLayout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import InputError from "@/Components/InputError.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
export default {
  data() {
    const form = useForm({
      churro_relleno: null,
      churro_natural: null,
      botana: null,
      bolis: null,
      choco_churro: null,
      lechuguilla: null,
      agua: null,
      refresco: null,
      plato: null,
      tostilocos: null,
      churro_nieve: null,
      hersheys: null,
      coca: null,
      papas: null,

    });
    return {
      form,
    };
  },
  components: {
    AppLayout,
    Link,
    useForm,
    PrimaryButton,
    InputError,
    SecondaryButton,
  },
  props: {
  },
  methods: {
    store() {
      this.form.post(this.route("sales.store"));
    },
  },
};
</script>