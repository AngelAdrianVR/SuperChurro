<script setup>
import { computed, ref, watch } from 'vue';
import { usePage } from '@inertiajs/inertia-vue3';

const show = ref(true);
const style = computed(() => usePage().props.value.jetstream.flash?.bannerStyle || 'success');
const message = computed(() => usePage().props.value.jetstream.flash?.banner || '');

watch(message, async () => {
  show.value = true;
});
</script>

<template>
    <div>
        <!-- Transición para un fundido suave de entrada y salida -->
        <Transition
            enter-active-class="transition ease-out duration-300"
            enter-from-class="opacity-0"
            enter-to-class="opacity-100"
            leave-active-class="transition ease-in duration-200"
            leave-from-class="opacity-100"
            leave-to-class="opacity-0"
        >
            <!-- 
              Contenedor principal del banner
              - Usa fondos claros (bg-emerald-100, bg-red-100)
              - Añade un borde izquierdo acentuado (border-l-4)
              - Define colores de texto con buen contraste (text-emerald-800, text-red-800)
              - Añade una sombra sutil (shadow-md)
            -->
            <div
                v-if="show && message"
                :class="{
                    'bg-emerald-100 border-l-4 border-emerald-500 text-emerald-800 shadow-md': style == 'success',
                    'bg-red-100 border-l-4 border-red-500 text-red-800 shadow-md': style == 'danger',
                }"
            >
                <div class="max-w-screen-xl mx-auto py-3 px-3 sm:px-6 lg:px-8">
                    <div class="flex items-center justify-between flex-wrap">
                        <div class="w-0 flex-1 flex items-center min-w-0">
                            <!-- El span del icono ya no necesita un fondo separado -->
                            <span class="flex p-2 rounded-lg">
                                <svg
                                    v-if="style == 'success'"
                                    class="h-5 w-5" 
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="1.5"
                                    stroke="currentColor"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                                    />
                                </svg>

                                <svg
                                    v-if="style == 'danger'"
                                    class="h-5 w-5"
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="1.5"
                                    stroke="currentColor"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126z"
                                    />
                                </svg>
                            </span>

                            <!-- El color del texto se hereda del div principal -->
                            <p class="ml-3 font-medium text-sm truncate">
                                {{ message }}
                            </p>
                        </div>

                        <div class="shrink-0 sm:ml-3">
                            <!-- 
                              Botón de cierre actualizado:
                              - Estilos de hover/focus más sutiles que coinciden con la paleta.
                              - Añadido focus:ring para mejor accesibilidad.
                            -->
                            <button
                                type="button"
                                class="-mr-1 flex p-2 rounded-md focus:outline-none sm:-mr-2 transition"
                                :class="{
                                    'hover:bg-emerald-200 focus:bg-emerald-200 focus:ring-2 focus:ring-offset-2 focus:ring-emerald-600 focus:ring-offset-emerald-100': style == 'success',
                                    'hover:bg-red-200 focus:bg-red-200 focus:ring-2 focus:ring-offset-2 focus:ring-red-600 focus:ring-offset-red-100': style == 'danger',
                                }"
                                aria-label="Dismiss"
                                @click.prevent="show = false"
                            >
                                <!-- El color del icono del botón se hereda -->
                                <svg
                                    class="h-5 w-5"
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="1.5"
                                    stroke="currentColor"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M6 18L18 6M6 6l12 12"
                                    />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </Transition>
    </div>
</template>
