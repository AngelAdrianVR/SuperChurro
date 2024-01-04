<template>
  <AppLayout title="Mostrar Egreso">
    <template #header>
      <div class="flex items-center mt-2">
        <Back />
        <h2 class="font-semibold text-xl text-gray-800 text-center ml-5 lg:ml-28">
          Detalles de egresos
        </h2>
      </div>
    </template>

    <div
      class="max-w-2xl md:mx-auto mt-5 rounded-lg px-5 pt-4 pb-5 bg-transparent border border-gray3 mx-4"
    >
      <div class="flex items-center justify-between">
        <p class="font-bold text-sm">Categoría: <span>{{ outcomes.category }}</span></p>
        <div class="flex items-center space-x-1">
          <i class="fa-solid fa-pencil text-sm rounded-full py-1 px-[7px] hover:bg-gray5 cursor-pointer text-primary"></i>
          <i class="fa-regular fa-trash-can text-sm rounded-full py-1 px-[7px] hover:bg-gray5 cursor-pointer text-primary"></i>
        </div>
      </div>

      <div class="grid grid-cols-4 lg:mx-4 mt-2 space-y-2 overflow-auto">
        <p class="text-sm font-bold col-span-1">Método de pago:</p>
        <p class="text-sm col-span-3">{{ outcomes.payment_method ?? '--' }}</p>
        <p class="text-sm font-bold col-span-1">Monto:</p>
        <p class="text-sm col-span-3">{{ getTotal().toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",") }}</p>
        <p class="text-sm font-bold col-span-1">Descripción:</p>

        <table @click="showOptions = false" class="w-full mx-auto text-sm mt-5 col-span-3">
            <thead class="bg-gray4">
                <tr class="text-center">
                    <th class="font-bold pb-1 pl-2 text-left rounded-l-full">
                        Concepto
                    </th>
                    <th class="font-bold pb-1 pl-2 text-left">
                        Costo
                    </th>
                    <th class="font-bold pb-1 px-1 text-left">
                        Cantidad
                    </th>
                    <th class="font-bold pb-1 px-1 text-left rounded-r-full"> 
                        Total
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr
                    v-for="outcome in outcomes" :key="outcome.id" class="mb-4">
                    <td class="py-1 pl-3">
                        {{ outcome.concept }}
                    </td>
                    <td class="py-1 pr-2">
                        ${{ outcome.cost?.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",")}}
                    </td>
                    <td class="py-1 pr-2">
                        {{ outcome.quantity }}
                    </td>
                    <td class="py-1 pr-2">
                        ${{ (outcome.quantity * outcome.cost)?.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",") }}
                    </td>
                </tr>
            </tbody>
        </table>
        <p class="text-sm font-bold col-span-1">Comentarios:</p>
        <p class="text-sm col-span-3">{{ outcomes.notes ?? '--' }}</p>
      </div>
    </div>
      <p class="text-right mx-4 font-bold text-sm mt-5 mb-5">Total= ${{getTotal().toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",")}} </p>
    
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
                block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-[#BF532A]
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
                block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-[#BF532A]
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
                block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-[#BF532A]
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
import Back from "@/Components/Back.vue";
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
    SecondaryButton,
    PrimaryButton,
    DialogModal,
    Back,
    Link
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
