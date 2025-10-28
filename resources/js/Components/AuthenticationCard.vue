<template>
    <!-- 
      MODERNIZACIÓN:
      - Fondo: Cambiado de un simple 'bg-gray-100' a un gradiente sutil y elegante 'bg-slate-50'.
      - Tarjeta:
        - Se hizo blanca ('bg-white') para un contraste limpio.
        - Se aumentaron los bordes redondeados ('sm:rounded-2xl') para un look más suave.
        - Se añadió una sombra mucho más pronunciada y moderna ('shadow-xl' o 'shadow-2xl').
        - Se aumentó el padding (px-8 py-10) para dar más espacio al contenido.
    -->
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-slate-50">
        <div>
            <slot name="logo" />
        </div>

        <div class="w-full sm:max-w-md mt-6 px-8 py-10 bg-white shadow-xl overflow-hidden sm:rounded-2xl">
            <slot />
        </div>
    </div>
</template>
