<template>
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
            <tr  v-for="(outcome, index) in outcomes" :key="outcome.id" class="mb-4 border border-gray3 rounded-lg">
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
                        <p @click="$inertia.get(route('outcomes.edit', outcome.id))" class="px-2 py-1 hover:bg-gray4">Editar</p>
                        <p @click="deleteItem" class="px-2 py-1 hover:bg-gray4">Eliminar</p>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</template>

<script>
export default {
data(){
    return {
        showOptions: false,
        indexSelected: null,
    }
},
components:{

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
    deleteItem() {
        console.log('Eliminado')
    }
}
}
</script>
