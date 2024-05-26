<template>
    <div class="flex space-y-0 flex-row justify-between items-center common-container">
        <div>
            <select @change="syncItem" v-model="selection" class="select w-full lg:w-full" required>
                <option value="x">-- Seleccionar consumible --</option>
                <option v-for="consumable in consumables" :key="consumable.id" :value="consumable.id">
                    {{ consumable.name }}
                </option>
            </select>
            <p v-if="error_validation" class="text-red-400 text-xs">Favor de seleccionar el consumible</p>
        </div>
        <div class="relative z-0 mb-6 group">
            <input @change="syncItem" v-model.number="quantity" min="1" type="number" autocomplete="off"
                class="input w-1/2 lg:w-full ml-2" placeholder="" />
        </div>
        <!-- <span>{{ consumable.unit.name }}</span> -->
        <button type="button" @click="$emit('deleteItem')">
            <i class="fa-regular fa-trash-can text-sm text-primary cursor-pointer"></i>
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
        consumables: Array,
        id: Number,
        init_state: {
            type: Object,
            default: null,
        },
    },
    mounted() {
        if (this.init_state != null) {
            this.selection = this.init_state.consumable_id;
            this.quantity = this.init_state.quantity;
        }
    },
    computed: {
        syncItem() {
            if (this.selection != 'x' && this.quantity) {
                this.$emit('syncItem', {
                    id: this.id,
                    consumable_id: this.selection,
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