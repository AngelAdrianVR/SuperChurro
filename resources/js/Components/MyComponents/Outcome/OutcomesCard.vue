<template>
  <div
      class="max-w-2xl md:mx-auto mt-5 rounded-lg px-3 pt-4 pb-5 bg-transparent border border-gray3 mx-2"
    >
      <div class="flex items-center justify-between">
        <p class="font-bold text-sm flex items-center">Categoría: <span class="mx-2 text-primary">{{ outcomes[0].category }}</span>
        </p>
        <!-- <div class="flex items-center space-x-1">
          <i class="fa-solid fa-pencil text-sm rounded-full py-1 px-[7px] hover:bg-gray5 cursor-pointer text-primary"></i>
          <i class="fa-regular fa-trash-can text-sm rounded-full py-1 px-[7px] hover:bg-gray5 cursor-pointer text-primary"></i>
        </div> -->
      </div>

      <div class="grid grid-cols-4 lg:mx-4 mt-2 space-y-2 py-2 overflow-auto">
        <p class="text-sm font-bold col-span-1">Método de pago:</p>
        <p class="text-sm col-span-3">{{ outcomes[0].payment_method ?? '--' }}</p>
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
                <tr @click="editOutcome(outcome)"
                    v-for="outcome in outcomes" :key="outcome.id" class="mb-4 cursor-pointer">
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
        <p class="text-sm col-span-3">{{ outcomes[0].notes ?? '--' }}</p>
      </div>
    </div>


    <DialogModal :show="show_edit_outcome_modal" @close="show_edit_outcome_modal = false">
      <template #title>
        <p class="text-sm font-bold">Editar Egreso <span class="text-primary ml-2">{{ edit_outcome.concept }}</span></p>
      </template>
      <template #content>

        <div class="mb-2 w-full">
          <InputLabel value="Concepto *" class="ml-3 mb-1 text-sm" />
          <input v-model="form.concept" type="text" required autocomplete="off" class="input"
           placeholder="Escribe el concepto" />
        </div>

        <div class="flex items-center space-x-2">
          <div class="mb-2 w-full">
            <InputLabel value="Cantidad *" class="ml-3 mb-1 text-sm" />
            <input v-model="form.quantity" type="number" required autocomplete="off" step="0.1" class="input"
            placeholder="0" />
          </div>

          <div class="mb-2 w-full relative">
            <InputLabel value="Costo *" class="ml-3 mb-1 text-sm" />
            <input v-model="form.cost" type="number" min="1" required step="0.1" autocomplete="off" class="input pl-7" placeholder="0" />
            <p class="text-sm text-gray-500 absolute top-[26px] left-2 border-r border-gray2 pr-[5px] py-[5px]">$</p>
          </div>
        </div>

      </template>
      <template #footer>
        <CancelButton class="!rounded-full" @click="show_edit_outcome_modal = false">Cancelar</CancelButton>
        <PrimaryButton @click="updateOutcome" class="ml-2" :disabled="form.processing">Guardar</PrimaryButton>
      </template>
    </DialogModal>
</template>

<script>
import DialogModal from "@/Components/DialogModal.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputLabel from "@/Components/InputLabel.vue";
import CancelButton from "@/Components/CancelButton.vue";
import { useForm } from "@inertiajs/inertia-vue3";

export default {
data(){
    const form = useForm({
      concept: "",
      quantity: null,
      cost: "",
    });
    return {
        form,
        outcomes_reversed: null,
        show_edit_outcome_modal: false,
        edit_outcome: null,
    }
},
components:{
DialogModal,
InputLabel,
CancelButton,
PrimaryButton
},
props:{
outcomes: Array
},
methods:{
getTotal() {
        let total = 0;
        this.outcomes.forEach(outcome => {
            total += outcome.quantity * outcome.cost;
        });
        return total;
    },
    editOutcome(item){
      this.edit_outcome = item; 
      this.form.concept = item.concept;
      this.form.quantity = item.quantity;
      this.form.cost = item.cost;
      this.show_edit_outcome_modal = true;
    },
    updateOutcome(){
      this.form.put(route('outcomes.update', this.edit_outcome.id), {
        onSuccess: () => {
          this.show_edit_outcome_modal = false;
          location.reload();
        },
      });
    },
}
}
</script>
