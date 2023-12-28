<template>
    <div class="
      flex
      space-y-0 flex-row justify-between items-center
      px-3
      common-container
    ">
        <div>
            <select @change="syncItem" v-model="selection" class="select w-full lg:w-full" required>
                <option value="x">-- Seleccionar producto --</option>
                <option v-for="product in products" :key="product.id" :value="product.id">
                    {{ product.name }} {{ show_price ? '($' + product.current_employee_price?.price + '/unidad)' : '' }}
                </option>
            </select>
            <p v-if="error_validation" class="text-red-400 text-xs">Favor de seleccionar el producto</p>
        </div>
        <div class="relative z-0 mb-6 w-1/4 group">
            <input @change="syncItem" v-model.number="quantity" min="1" type="number"
                autocomplete="off" class="input w-1/2 ml-2" placeholder=" " />
        </div>
        <!-- <span>{{ product.unit.name }}</span> -->
        <!-- <span>${{ getTotal }}</span> -->
        <button type="button" @click="$emit('deleteItem')">
            <i class="
          fa-regular fa-trash-can
          text-sm
          text-primary
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
        show_price: {
            type: Boolean,
            default: false
        }
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
                ? (this.quantity * this.products.find(product => { return product.id === this.selection }).price)?.toFixed(2) +
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