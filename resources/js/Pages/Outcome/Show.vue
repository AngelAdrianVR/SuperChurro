<template>
  <AppLayout title="Mostrar Egreso">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Detalles de egreso
      </h2>
    </template>

    <div class="flex justify-start">
      <Link :href="route('outcomes.index')" class="flex items-center mt-2 text-slate-700">
        <i
          class="fas fa-long-arrow-alt-left text-lg active:bg-gray-300 bg-opacity-100 rounded-full w-7 h-7 pl-1 ml-2"
        ></i>
        <span class="ml-1 cursor-default">Atrás</span>
      </Link>
    </div>

    <div
      class="max-w-2xl md:mx-auto mt-5 shadow-md shadow-gray-500/70 rounded-lg px-5 pt-4 pb-5 bg-white mx-4"
    >
      <h1 class="text-sky-500 font-bold mb-2">Productos comprados</h1>
      <ul>
        <li
          v-for="outcome in outcomes"
          :key="outcome.id"
          class="text-sm list-disc ml-2"
        >
          {{ outcome.concept }}
          <i class="fa-solid fa-arrow-right mx-3 text-green-600"></i>
          ${{ outcome.cost }} X
          {{ outcome.quantity }} = ${{ outcome.quantity * outcome.cost}} 
          <i @click="editOutcome(outcome)" class="fa-solid fa-pencil text-blue-400 text-xs cursor-pointer ml-1"></i>   
        </li>
      </ul>
      <br>
      Total= ${{getTotal()}} <br>
    </div>
    
    <DialogModal :show="show_edit_outcome_modal" @close="show_edit_outcome_modal = false">
      <template #title>
        Editar Egreso <span class="text-sky-600 font-bold">{{ edit_outcome.concept }}</span>
      </template>
      <template #content>
          <div class="relative z-0 mb-6 w-full group">
            <input v-model="form.concept" type="text" name="floating_time_requested" autocomplete="off" required class="
                block
                py-2.5
                px-0
                w-full
                text-sm text-gray-900
                bg-transparent
                border-0 border-b-2 border-gray-300
                appearance-none
                dark:text-gray-700 dark:border-gray-600 dark:focus:border-stone-500
                focus:outline-none focus:ring-0 focus:border-stone-600
                peer
              " placeholder=" " />
            <label for="floating_name" class="
                absolute
                text-sm text-gray-500
                dark:text-gray-700
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
              ">Concepto *</label>
          </div>

          <div class="relative z-0 mb-6 w-full group">
            <input v-model="form.quantity" type="number" name="floating_time_requested" autocomplete="off" required class="
                block
                py-2.5
                px-0
                w-full
                text-sm text-gray-900
                bg-transparent
                border-0 border-b-2 border-gray-300
                appearance-none
                dark:text-gray-700 dark:border-gray-600 dark:focus:border-stone-500
                focus:outline-none focus:ring-0 focus:border-stone-600
                peer
              " placeholder=" " />
            <label for="floating_name" class="
                absolute
                text-sm text-gray-500
                dark:text-gray-700
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
              ">Cantidad *</label>
          </div>

          <div class="relative z-0 mb-6 w-full group">
            <input v-model="form.cost" type="number" name="floating_time_requested" autocomplete="off" required class="
                block
                py-2.5
                px-0
                w-full
                text-sm text-gray-900
                bg-transparent
                border-0 border-b-2 border-gray-300
                appearance-none
                dark:text-gray-700 dark:border-gray-600 dark:focus:border-stone-500
                focus:outline-none focus:ring-0 focus:border-stone-600
                peer
              " placeholder=" " />
            <label for="floating_name" class="
                absolute
                text-sm text-gray-500
                dark:text-gray-700
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
              ">Costo *</label>
          </div>
      </template>
      <template #footer>
        <SecondaryButton @click="show_edit_outcome_modal = false">Cancelar</SecondaryButton>
        <PrimaryButton @click="updateOutcome" class="ml-2" :disabled="form.processing">Guardar</PrimaryButton>
      </template>
    </DialogModal>
  </AppLayout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import DialogModal from "@/Components/DialogModal.vue";
import { Link, useForm } from "@inertiajs/inertia-vue3";

export default {
  data() {
    const form = useForm({
      concept: "",
      quantity: null,
      cost: "",
    });
    return {
      outcomes_reversed: null,
      show_edit_outcome_modal: false,
      edit_outcome: null,
      form
    };
  },
  components: {
    AppLayout,
    Link,
    SecondaryButton,
    PrimaryButton,
    DialogModal
  },
  props: {
    outcomes: Array,
  },
  methods: {
    getTotal() {
        let total = 0;
        this.outcomes.forEach(outcome => {
           total += outcome.quantity * outcome.cost;
        });
        return total;
    },
    editOutcome(item){
      this.edit_outcome = item; 
      console.log(item);
      this.form.concept = item.concept;
      this.form.quantity = item.quantity;
      this.form.cost = item.cost;
      this.show_edit_outcome_modal = true;
    },
    updateOutcome(){
      this.form.put(route('outcomes.update', this.edit_outcome.id), {
        onSuccess: () => {
          this.show_edit_outcome_modal = false;
        },
      });
    },

  },
};
</script>
