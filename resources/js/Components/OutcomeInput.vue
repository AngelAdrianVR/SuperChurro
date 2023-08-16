<template>
    <div class="
      flex
      space-y-0 flex-row justify-between items-center
      px-3
      common-container
    ">
        <div class="relative z-0 w-1/4 group">
            <input @change="syncItem" v-model="concept" type="text" name="floating_description"
                autocomplete="off" class="
              block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-400 appearance-none dark:text-gray-700 dark:border-gray-600 dark:focus:border-stone-500 focus:outline-none focus:ring-0 focus:border-stone-600 peer
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
            ">Concepto *</label>
        </div>
        <div class="relative z-0 mb-6 w-1/4 group">
            <input @change="syncItem" v-model.number="quantity" min="1" type="number" name="floating_description"
                autocomplete="off" class="
              block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-400 appearance-none dark:text-gray-700 dark:border-gray-600 dark:focus:border-stone-500 focus:outline-none focus:ring-0 focus:border-stone-600 peer
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
            ">Cantidad</label>
        </div>
        <div class="relative z-0 mb-6 w-1/4 group">
            <input @change="syncItem" v-model="cost" min="1" step="0.1" type="number" name="floating_description"
                autocomplete="off" class="
              block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-400 appearance-none dark:text-gray-700 dark:border-gray-600 dark:focus:border-stone-500 focus:outline-none focus:ring-0 focus:border-stone-600 peer
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
            ">$Costo/unidad</label>
        </div>
        <button type="button" @click="$emit('deleteItem')">
            <i class="
          fa-solid fa-xmark
          text-gray-300
          hover:text-red-300
          cursor-pointer
        "></i>
        </button>
    </div>
</template>

<script>

export default {
    data() {
        return {
            concept: null,
            quantity: 1,
            cost: null,
        };
    },
    emits: ['deleteItem', 'syncItem'],
    props: {
        id: Number,
        init_state: {
            type: Object,
            default: null,
        },
    },
    mounted() {
        if (this.init_state != null) {
            this.selection = this.init_state.product_id;
            this.quantity = this.init_state.quantity;
        }
    },
    computed: {
        getTotal() {
            return this.concept != null
                ? (this.quantity * this.cost)
                : 0;
        },
        syncItem() {
            if (this.selection != 'x' && this.quantity) {
                this.$emit('syncItem', {
                    id: this.id,
                    concept: this.concept,
                    quantity: this.quantity,
                    cost: this.cost,
                });
                this.error_validation = false;
            } else {
                this.error_validation = true;
            }
        },
    },
};
</script>