<template>
  <table class="w-full mx-auto text-sm mt-5">
        <thead>
            <tr class="text-center">
                <th class="font-bold pb-1 pl-2 text-left border-b border-primary">
                Producto
                </th>
                <th class="font-bold pb-1 text-left border-b border-primary">
                Cantidad
                </th>
                <th class="font-bold pb-1 text-left border-b border-primary">
                Total
                </th>
                <th class="font-bold pb-3 text-left border-b border-primary">
                </th>
            </tr>
        </thead>
        <tbody>
            <tr  v-for="(sale, index) in shiftSales" :key="sale.id"
                class="mb-4"
                :class="{ 'bg-[#EDEDED]': index % 2 == 0 }"
            >
                <td class="py-2 pl-3 rounded-l-full">
                    {{ sale.product.name }}
                </td>
                <td class="py-2 pr-2">
                    {{ sale.quantity }}
                </td>
                <td class="py-2 pr-2">
                    ${{ (sale.price * sale.quantity)?.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",") }}
                </td>
                <td class="py-2 pr-2">
                    <i @click="editSale(sale)" class="fa-solid fa-pencil text-primary text-xs cursor-pointer ml-1"></i>
                </td>
            </tr>
        </tbody>
    </table>

    <DialogModal :show="show_edit_sale_modal" @close="show_edit_sale_modal = false">
      <template #title>
        <p class="text-sm font-bold">Editar venta <span class="text-primary font-bold text-sm ml-3">{{ edit_sale.product.name }}</span></p>
      </template>
      <template #content>
        <div class="mb-3 w-full">
          <InputLabel value="Cantidad *" class="ml-3 mb-1 text-sm" />
          <input v-model="form.quantity" type="number" autocomplete="off" required class="input"
           placeholder="00" />
        </div>

      </template>
      <template #footer>
        <CancelButton class="!rounded-full" @click="show_edit_sale_modal = false">Cancelar</CancelButton>
        <PrimaryButton @click="updateSale" class="ml-2" :disabled="form.processing">Guardar</PrimaryButton>
      </template>
    </DialogModal>

</template>

<script>
import DialogModal from "@/Components/DialogModal.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import CancelButton from "@/Components/CancelButton.vue";
import InputLabel from "@/Components/InputLabel.vue";
import { useForm } from "@inertiajs/inertia-vue3";

export default {
data(){
    const form = useForm({
      quantity: null,
    });

    return {
        form,
        show_edit_sale_modal: false,
        edit_sale: null,
    }
},
components:{
DialogModal,
CancelButton,
PrimaryButton,
InputLabel
},
props:{
shiftSales: Array
},
emits:['update-sale'],
methods:{
    editSale(sale) {
    this.edit_sale = sale;
    this.form.quantity = sale.quantity;
    this.show_edit_sale_modal = true;
},
    updateSale() {
        this.form.put(route('sales.update', this.edit_sale.id), {
        onSuccess: () => {
          this.show_edit_sale_modal = false;
          let sale = this.shiftSales.find(item => this.edit_sale.id === item.id);
          if (!sale)
            sale = this.shiftSales.find(item => this.edit_sale.id === item.id);
          
          sale.quantity = this.form.quantity;
        },
      });
    }
}
}
</script>
