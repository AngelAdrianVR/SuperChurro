<template>
  <AppLayout title="Administración de consumibles">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
        Administración de consumibles
      </h2>
    </template>

    <!-- Contenedor principal con padding estándar -->
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
      <!-- Botón de "Agregar" alineado con el contenedor -->
      <div class="flex justify-end mb-6">
        <Link :href="route('consumables.create')">
          <PrimaryButton>Agregar consumible</PrimaryButton>
        </Link>
      </div>

      <!-- Cuadrícula (Grid) responsiva para las tarjetas -->
      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">

        <!-- Tarjeta de consumible -->
        <div v-for="consumable in consumables.data" :key="consumable.id"
             class="bg-white rounded-lg shadow-lg overflow-hidden relative transition-all duration-300 ease-in-out hover:shadow-2xl group">

          <!-- Área clickeable que lleva a "editar" -->
          <Link :href="route('consumables.edit', consumable.id)" class="block">
            <!-- Contenedor de la imagen -->
            <figure class="h-48 w-full bg-gray-100 flex items-center justify-center">
              <img v-if="consumable.media[0]?.original_url"
                   :src="consumable.media[0]?.original_url"
                   alt="Imagen del consumible"
                   class="h-full w-full object-contain">
              <!-- Mensaje si no hay imagen -->
              <span v-else class="text-sm text-gray-400">Sin imagen</span>
            </figure>

            <!-- Contenido de texto -->
            <div class="p-4">
              <p class="text-lg font-semibold text-gray-900 truncate" :title="consumable.name">
                {{ consumable.name }}
              </p>
              <p class="text-sm text-gray-600 mt-1">
                Unidad: {{ consumable.unit?.name || 'No especificada' }}
              </p>
            </div>
          </Link>

          <!-- Botón de eliminar (Absoluto) -->
          <!-- Aparece al hacer hover sobre la tarjeta (usando 'group-hover') -->
          <button
            class="absolute top-2 right-2 z-10 w-7 h-7 rounded-full bg-white/70 text-red-500 hover:bg-red-100 hover:text-red-700 transition-all duration-200"
            @click="delete_confirm = true; item_to_delete = consumable;">
            <i class="fa-regular fa-trash-can text-lg"></i>
          </button>
        </div>

      </div>
    </div>

    <!-- Modal de confirmación (sin cambios) -->
    <ConfirmationModal :show="delete_confirm" @close="delete_confirm = false">
      <template #title>
        <div>¿Deseas continuar?</div>
      </template>
      <template #content>
        <div>
          Estás a punto de eliminar un consumible. Una vez realizado ya no se podrá
          recuperar.
        </div>
      </template>
      <template #footer>
        <div class="flex justify-end">
          <button @click="this.delete()"
            class="px-2 py-1 font-semibold border rounded border-red-500 text-red-500 hover:bg-red-500 hover:text-white transition duration-200 mr-2">Eliminar</button>
          <button
            class="px-2 py-1 font-semibold border rounded border-gray-500 text-gray-500 hover:bg-gray-100 transition duration-200"
            @click="delete_confirm = false">
            Cancelar
          </button>
        </div>
      </template>
    </ConfirmationModal>

  </AppLayout>
</template>

<script>
// El script se mantiene idéntico, ya que la funcionalidad no cambia.
import AppLayout from "@/Layouts/AppLayout.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import ConfirmationModal from "@/Components/ConfirmationModal.vue";
import { Link, useForm } from "@inertiajs/inertia-vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputError from "@/Components/InputError.vue";

export default {
  data() {
    const form = useForm({

    });
    return {
      form,
      delete_confirm: false,
      item_to_delete: {},
    }
  },
  components: {
    AppLayout,
    SecondaryButton,
    Link,
    ConfirmationModal,
    PrimaryButton,
    InputError,
  },
  props: {
    consumables: Object,
  },
  methods: {
    delete() {
      this.$inertia.delete(this.route("consumables.destroy", this.item_to_delete), {
        onSuccess: () => {
          this.$notify({
            title: "Eliminado",
            message: "",
            type: "success",
          });
        }
      });
      this.delete_confirm = false;
    },

  },
};
</script>
