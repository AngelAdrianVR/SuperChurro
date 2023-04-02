<template>
  <AppLayout title="Agregar Egresos">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Agregar Egreso
      </h2>
    </template>

    <div class="flex justify-start">
      <Link
        :href="route('outcomes.index')"
        class="flex items-center mt-2 text-slate-700"
      >
        <i
          class="fas fa-long-arrow-alt-left text-lg active:bg-gray-300 bg-opacity-100 rounded-full w-7 h-7 pl-1 ml-2"
        ></i>
        <span class="ml-1 cursor-default">Atrás</span>
      </Link>
    </div>

    <div class="
        max-w-2xl
        md:mx-auto
        mt-5
        shadow-md shadow-gray-500/70
        rounded-lg
        px-5
        pt-4
        pb-5
        bg-white
        mx-4
      ">
      <p v-if="validation_message" class="text-red-400 text-xs mb-2" v-html="validation_message"></p>
      <form @submit.prevent="store">
        <div>
          <OutcomeInput v-for="(item, index) in form.items" :key="item.id" :id="item.id"
            @deleteItem="deleteItem(index)" @syncItem="syncItems(index, $event)" class="mb-5" />
        </div>
        <p v-if="!form.items.length" class="text-sm text-gray-600"> Click al botón de "+" para empezar a agregar
          productos </p>
        <div class="my-2 text-center">
          <button type="button" @click="addNewItem">
            <i class="fa-solid fa-circle-plus text-2xl text-blue-400"></i>
          </button>
        </div>
               <div class="relative z-0 mb-6 w-full group">
            <textarea v-model="form.notes" min="1" name="floating_description"
                autocomplete="off" class="
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
            <label for="floating_description" class="
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
            ">Notas</label>
        </div>
        <PrimaryButton :disabled="form.processing">Agregar</PrimaryButton>
      </form>
    </div>

   
  </AppLayout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { Link, useForm } from "@inertiajs/inertia-vue3";
import OutcomeInput from "@/Components/OutcomeInput.vue";


export default {
  data() {
    const form = useForm({
      items: [
        {
          id: 1,
          concept: null,
          quantity: 1,
          cost: null,
        }
      ],
      notes: "",
    })
    return {
    validation_message: "",
    next_item_id: 2,
    form,
    }
  },
  components: {
    AppLayout,
    SecondaryButton,
    PrimaryButton,
    Link,
    OutcomeInput,
  },
  props: {

  },

  methods: {
    addNewItem() {
      this.form.items.push({ id: this.next_item_id++, quantity: null, });
    },
    deleteItem(index) {
      if (this.form.items.length > 1) {
        this.form.items.splice(index, 1);
      }
    },
    syncItems(index, concept_obj) {
      this.form.items[index] = concept_obj;
    },
    store() {
    //   this.quantityValidated();
    //   if (this.validation_message == "") {
        this.form.post(this.route("outcomes.store"));
    //   }
    },
    // quantityValidated() {
    //   this.validation_message = "";
    //   this.form.items.forEach(product => {
    //     const available_quantity = this.cart_stock[product.product_id];
    //     if (available_quantity < product.quantity) {
    //       this.validation_message += `- Sólo hay disponible <strong>${available_quantity}</strong> unidades del producto <strong>` +
    //         this.products.find(item => item.id == product.product_id).name + '</strong> en carrito</br>';
    //     }
    //   });
    // },
  },
};
</script>
