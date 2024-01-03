<template>
    <div class="
        flex
        space-x-1 flex-row justify-between items-center
        common-container">

    <div class="w-2/3">
        <InputLabel value="Concepto" class="ml-3 mb-1 text-sm" />
        <input @change="syncItem" v-model="concept" type="text" autocomplete="off" class="input mt-1" />
    </div>

    <div class="w-1/4 relative">
        <InputLabel value="Costo*" class="ml-3 mb-1 text-sm" />
        <input @change="syncItem"  v-model="cost" type="number" min="1" step="0.1" autocomplete="off" class="input pl-6" />
        <p class="text-sm text-gray-500 absolute top-[26px] left-2 border-r border-gray2 pr-[4px] py-[5px]">$</p>
    </div>

    <div class="w-12">
        <InputLabel value="Cant." class="ml-3 mb-1 text-sm" />
        <input @change="syncItem" v-model.number="quantity" type="number" min="1" autocomplete="off" class="input" />
    </div>

    <div class="w-1/3 relative">
        <InputLabel value="Total" class="ml-3 mb-1 text-sm" />
        <input @change="syncItem"  :value="cost * quantity" type="number" min="1" step="0.1" autocomplete="off" class="input pl-6" />
        <p class="text-sm text-gray-500 absolute top-[26px] left-2 border-r border-gray2 pr-[4px] py-[5px]">$</p>
    </div>

        <button type="button" @click="$emit('deleteItem')">
            <i class="
          fa-regular fa-trash-can
          ml-2
          mt-5
          text-sm
          text-primary
          cursor-pointer
        "></i>
        </button>
    </div>
</template>

<script>
import InputLabel from "@/Components/InputLabel.vue";

export default {
    data() {
        return {
            concept: null,
            quantity: 1,
            cost: null,
        };
    },
    components:{
        InputLabel,
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