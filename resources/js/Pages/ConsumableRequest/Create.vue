<template>
  <AppLayout title="Solicitar consumibles">
    <template #header>
      <div class="flex items-center mt-2">
        <Back />
        <h2 class="font-semibold text-xl text-gray-800 text-center ml-5 lg:ml-28">
          Solicitud de consumibles
        </h2>
      </div>
    </template>

    <div class="max-w-lg md:mx-auto mt-5 rounded-lg px-5 pt-4 pb-5 border border-gray3 bg-transparent mx-4">
      <!-- <p v-if="validation_message" class="text-red-600 text-xs mb-2" v-html="validation_message"></p> -->
      <form @submit.prevent="store">
        <div>
          <header class="flex items-center">
            <label class="w-1/2 font-bold ml-2 text-sm">Consumible</label>
            <label class="font-bold ml-4 text-sm">Cantidad</label>
          </header>
          <ConsumableInput :consumables="consumables" v-for="(item, index) in form.items" :key="item.id" :id="item.id"
            @deleteItem="deleteItem(index)" @syncItem="syncItems(index, $event)" class="mb-1" />
        </div>
        <p v-if="!form.items.length" class="text-sm text-gray-600">
          Click al botón de "+" para empezar a agregar consumibles
        </p>
        <div class="mt-2 mb-6 text-left">
          <button class="text-primary text-sm" type="button" @click="addNewItem">
            <i class="fa-solid fa-plus"></i>
            Agregar consumible
          </button>
        </div>
        <div class="mt-2`">
          <label class="font-bold ml-2 text-sm">Comentarios</label>
          <textarea v-model="form.notes" rows="3" class="textarea"></textarea>
        </div>
        <PrimaryButton :disabled="form.processing" class="mt-4">Solicitar</PrimaryButton>
      </form>
    </div>
  </AppLayout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import ConsumableInput from "@/Components/ConsumableInput.vue";
import InputError from "@/Components/InputError.vue";
import Back from "@/Components/Back.vue";
import { Link, useForm } from "@inertiajs/inertia-vue3";
export default {
  data() {
    const form = useForm({
      items: [
        {
          id: 1,
          consumable_id: null,
          quantity: null,
          notes: null,
        },
      ],
    });
    return {
      validation_message: "",
      next_item_id: 2,
      form,
    };
  },
  components: {
    AppLayout,
    PrimaryButton,
    InputError,
    SecondaryButton,
    ConsumableInput,
    Back,
    Link,
  },
  props: {
    consumables: Array,
    warehouse_stock: Object,
  },
  methods: {
    addNewItem() {
      this.form.items.push({ id: this.next_item_id++, consumable_id: null, quantity: null });
    },
    deleteItem(index) {
      if (this.form.items.length > 1) {
        this.form.items.splice(index, 1);
      }
    },
    syncItems(index, consumable_obj) {
      this.form.items[index] = consumable_obj;
    },
    store() {
      // this.quantityValidated();
      if (this.validation_message == "") {
        this.form.post(this.route("consumable-request.store"), {
          onSuccess: () => {
            this.$notify({
              title: "Solicitado",
              message: "",
              type: "success",
            });
          }
        });
      }
    },
    // quantityValidated() {
    //   this.validation_message = "";
    //   this.form.items.forEach((consumable) => {
    //     const available_quantity = this.warehouse_stock[consumable.consumable_id];
    //     if (available_quantity < consumable.quantity) {

    //       this.validation_message += `- Sólo hay disponible <strong>${available_quantity}</strong> unidades del consumible <strong>` +
    //         this.consumables.find(item => item.id == consumable.consumable_id).name + '</strong> en cocina</br>';

    //     }
    //   });
    // },
  },
};
</script>
