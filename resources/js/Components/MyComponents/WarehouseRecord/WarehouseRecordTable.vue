<template>
  <table class="mt-4 lg:mx-auto mx-2">
        <thead>
          <tr>
            <th class="pr-5 pb-4">Solicitado por</th>
            <th class="px-5 pb-4">Tipo</th>
            <th class="px-5 pb-4">Solicitado el</th>
            <th class="px-5 pb-4">Para</th>
            <th class="px-5 pb-4">Notas</th>
            <th class="px-5 pb-4">Cantidad</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="(movement, index) in movements"
            :key="index"
            class="text-gray-600"
            :class="{ 'bg-gray4': index % 2 == 0 }"
          >
            <td class="text-left py-2 rounded-l-full px-5">
              {{ movement.user.name }}
            </td>
            <td class="text-center py-2 px-5">
              {{ movement.concept.name }}
            </td>
            <td class="text-center py-2 px-5">
              {{ movement.created_at.split("T")[0] }}
            </td>
            <td class="text-center py-2 px-5">
              {{ movement.warehouse_id }}
            </td>
            <td class="text-center py-2 px-5">
              {{ movement.notes ?? "--" }}
            </td>
            <td
              :class="
                movement.concept.is_entry ? 'text-green-500' : 'text-red-500'
              "
              class="text-center py-2 flex items-center rounded-r-full pr-3"
            >
              <i
                v-if="movement.concept.is_entry"
                class="fa-solid fa-plus mr-1"
              ></i>
              <i v-else class="fa-solid fa-minus mr-1"></i>
              <span>{{ movement.quantity }} {{ product.unit.name }}</span>
            </td>
          </tr>
        </tbody>
      </table>
      <p
        v-if="movements.length === 0"
        class="text-sm text-gray-500 text-center my-3"
      >
        No hay ningún movimiento registrado para este producto.
      </p>
</template>

<script>
export default {
    data(){
        return {

        }
    },
    components:{

    },
    props:{
        movements: Array,
        product: Object,
    },
    methods:{

    }
}
</script>
