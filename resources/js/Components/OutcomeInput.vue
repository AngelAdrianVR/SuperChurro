<template>
    <div class="
        flex
        space-x-1 flex-row justify-between items-center
        common-container">

    <!-- MEJORA: Se usa v-model. El watch se encargará de emitir los cambios. -->
    <div class="w-2/3">
        <InputLabel value="Concepto" class="ml-3 mb-1 text-sm" />
        <input v-model="concept" type="text" autocomplete="off" class="input mt-1" />
    </div>

    <!-- MEJORA: Se usa v-model.number. El watch se encargará de emitir los cambios. -->
    <div class="w-1/4 relative">
        <InputLabel value="Costo*" class="ml-3 mb-1 text-sm" />
        <input v-model.number="cost" type="number" min="0" required step="0.01" autocomplete="off" class="input pl-6" placeholder="0" />
        <p class="text-sm text-gray-500 absolute top-[26px] left-2 border-r border-gray2 pr-[4px] py-[5px]">$</p>
    </div>

    <!-- MEJORA: Se usa v-model.number. El watch se encargará de emitir los cambios. -->
    <div class="w-12">
        <InputLabel value="Cant." class="ml-3 mb-1 text-sm" />
        <input v-model.number="quantity" type="number" required min="1" autocomplete="off" class="input" placeholder="0" />
    </div>

    <!-- MEJORA: El total ya no es un input, es un div de solo lectura. -->
    <div class="w-1/3 relative">
        <InputLabel value="Total" class="ml-3 mb-1 text-sm" />
        <!-- Se estiliza como un input pero no lo es. Muestra el total formateado. -->
        <div class="input pl-6 bg-gray-100 flex items-center">
            {{ formattedTotal }}
        </div>
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
        InputLabel
    },
    emits: ['deleteItem', 'syncItem'],
    props: {
        id: Number,
        // MEJORA: Renombrado de init_state a initialData para mayor claridad
        initialData: {
            type: Object,
            default: null,
        },
    },
    computed: {
        /**
         * MEJORA: Objeto computado que agrupa el estado.
         * El 'watch' observará este objeto.
         */
        itemState() {
            return {
                concept: this.concept,
                quantity: this.quantity,
                cost: this.cost,
            };
        },
        /**
         * MEJORA: Propiedad computada para el cálculo del total.
         */
        total() {
            // Aseguramos que sean números para evitar NaN
            const q = Number(this.quantity) || 0;
            const c = Number(this.cost) || 0;
            return q * c;
        },
        /**
         * MEJORA: Propiedad computada para formatear el total.
         */
        formattedTotal() {
            return this.total.toFixed(2);
        }
    },
    watch: {
        /**
         * MEJORA: Observa el objeto 'itemState' y llama a 'emitSync' cuando cambia.
         * Esto reemplaza a los @change en cada input.
         */
        itemState(newState) {
            this.emitSync(newState);
        }
    },
    methods: {
        /**
         * MEJORA: Método dedicado a emitir la sincronización.
         */
        emitSync(state) {
            this.$emit('syncItem', {
                id: this.id,
                ...state
            });
        }
    },
    mounted() {
        /**
         * MEJORA: Si se proveen datos iniciales (para editar), se cargan en el 'data'.
         */
        if (this.initialData) {
            this.concept = this.initialData.concept;
            this.quantity = this.initialData.quantity;
            this.cost = this.initialData.cost;
        }

        /**
         * MEJORA: Emitimos el estado inicial (ya sea el default o el cargado)
         * para que el componente padre ('Create.vue') esté sincronizado desde el inicio.
         */
        this.emitSync(this.itemState);
    },
};
</script>
