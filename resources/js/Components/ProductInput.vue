<template>
    <div class="
      flex
      space-y-0 flex-row justify-between items-center
      px-3
      common-container
    ">
        <div>
            <select @change="syncItem" v-model="selection" class="select w-2/3 lg:w-3/4" required>
                <option value="x">-- Seleccionar producto --</option>
                <option v-for="product in products" :key="product.id" :value="product.id">
                    {{ product.name }}
                </option>
            </select>
            <p v-if="error_validation" class="text-red-400 text-xs">Favor de seleccionar el producto</p>
        </div>
        <div class="relative z-0 mb-6 w-1/4 group">
            <input @change="syncItem" v-model.number="quantity" min="1" type="number" name="floating_description"
                autocomplete="off" class="
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
            " placeholder=" " />
            <label for="floating_description" class="
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
            ">Cantidad</label>
        </div>
        <!-- <span>{{ product.unit.name }}</span> -->
        <!-- <span>${{ getTotal }}</span> -->
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
            selection: "x",
            quantity: 1,
            error_validation: false,
        };
    },
    emits: ['deleteItem', 'syncItem'],
    props: {
        products: Array,
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
            return this.selection != "x"
                ? (this.quantity * this.products.find(product => { return product.id === this.selection }).price).toFixed(2) +
                " " +
                this.products.find(product => { return product.id === this.selection }).currency
                : 0;
        },
        getPrice() {
            return this.selection != "x"
                ? this.products.find(product => { return product.id === this.selection }).price + ' ' +
                this.products.find(product => { return product.id === this.selection }).currency +
                " / Unidad"
                : 0;
        },
        syncItem() {
            if (this.selection != 'x' && this.quantity) {
                this.$emit('syncItem', {
                    id: this.id,
                    product_id: this.selection,
                    quantity: this.quantity,
                });
                this.error_validation = false;
            } else {
                this.error_validation = true;
            }
        },
    },
};
</script>