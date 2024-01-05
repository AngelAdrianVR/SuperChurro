<template>
<LoadingIndicator v-if="loading" />
    <table @click="showOptions = false" class="w-full mx-auto text-sm mt-5">
        <thead>
            <tr class="text-center">
                <th class="font-bold pb-3 pl-2 text-left">
                    Creado por
                </th>
                <th class="font-bold pb-3 text-left">
                    F. registro
                </th>
                <th class="font-bold pb-3 text-left">
                    Conceptos
                </th>
                <th class="font-bold pb-3 text-left">
                    Egreso
                </th>
                <th class="font-bold pb-3 text-left">
                </th>
            </tr>
        </thead>
        <tbody>
            <tr @click="$inertia.get(route('outcomes.show', outcome[0].id))"
                v-for="(outcome, index) in outcomes" :key="outcome.id" class="mb-4 border border-gray3 cursor-pointer hover:bg-gray-100">
                <td class="py-3 pl-3 rounded-l-full">
                    {{ outcome[0].user.name }}
                </td>
                <td class="py-3 pr-2">
                    {{ outcome[0].created_at.split('T')[0] }}
                </td>
                <td class="py-3 pr-2">
                    {{ outcome.length }}
                </td>
                <td class="py-3 pr-2">
                    ${{ calculateTotal(outcome)?.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",") }}
                </td>
                <td class="py-3 pr-2 relative">
                    <i @click.stop="showOptions = !showOptions; indexSelected = index" class="fa-solid fa-ellipsis-vertical text-primary p-1"></i>
                    <div v-if="showOptions && indexSelected == index" class="w-20 border border-gray3 rounded-md py-2 absolute top-9 right-5 bg-gray-50 z-10">
                        <!-- <p @click.stop="$inertia.get(route('outcomes.edit', outcome[0].id))" class="px-2 py-1 hover:bg-gray4">Editar</p> -->
                        <p @click.stop="delete_confirm = true; itemToDelete = outcome" class="px-2 py-1 hover:bg-gray4">Eliminar</p>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>

    <ConfirmationModal :show="delete_confirm" @close="delete_confirm = false">
      <template #title>
        <div>¿Deseas continuar?</div>
      </template>
      <template #content>
        <div>
          Estás a punto de eliminar un registro de egresos. Una vez realizado ya no se podrá
          recuperar.
        </div>
      </template>
      <template #footer>
        <div class="flex justify-end">
          <button @click="deleteItems(itemToDelete)"
            class="px-2 py-1 font-semibold border rounded border-red-500 text-red-500 hover:bg-red-500 hover:text-white transition duration-200 mr-2">Eliminar</button>
          <button
            class="px-2 py-1 font-semibold border rounded border-gray-500 text-gray-500 hover:bg-gray-100 transition duration-200"
            @click="delete_confirm = false">
            Cancelar
          </button>
        </div>
      </template>
    </ConfirmationModal>
</template>

<script>
import LoadingIndicator from "@/Components/MyComponents/LoadingIndicator.vue";
import ConfirmationModal from "@/Components/ConfirmationModal.vue";
import axios from 'axios';

export default {
data(){
    return {
        loading: false,
        showOptions: false,
        delete_confirm: false,
        itemToDelete: null,
        indexSelected: null,
    }
},
components:{
LoadingIndicator,
ConfirmationModal
},
props:{
outcomes: Object
},
methods:{
    calculateTotal(outcomeItems) {
      // Calcular el total multiplicando quantity por cost y sumándolos
      return outcomeItems.reduce((total, item) => {
        return total + item.quantity * item.cost;
      }, 0);
    },
    async deleteItems(outcomes) {
        this.loading = true;
        this.delete_confirm = false;
    try {
        const response = await axios.delete(route('outcomes.destroy', outcomes[0].id), {
            data: {
                outcomesArray: outcomes.map(outcome => outcome.id)
            }
        });

        if (response.status === 200) {

            this.$notify({
                title: "Correcto",
                message: "Se han eliminado los egresos",
                type: "success",
            });

            location.reload();
        }
    } catch (error) {
        console.log(error);
        this.$notify({
            title: "Algo salió mal",
            message: "No se pudo eliminar el registro de egresos. Intente más tarde",
            type: "error",
        });
    }
}
}
}
</script>
