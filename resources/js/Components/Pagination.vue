<template>
  <!-- 
    CORRECCIÓN DE ERROR:
    Se agregan comprobaciones para 'pagination', 'pagination.meta' y 'pagination.meta.links'
    para prevenir errores de renderizado si el objeto 'pagination' es nulo o indefinido
    durante la carga inicial.
  -->
  <div v-if="pagination && pagination.meta && pagination.meta.links && pagination.meta.links.length > 3"
       class="w-full flex items-center justify-center">
    
    <!-- 
      DISEÑO MODERNIZADO:
      Se utiliza el patrón estándar de Tailwind UI para paginación,
      con bordes redondeados, sombra y estilos claros para estados
      activo, deshabilitado y hover.
    -->
    <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
      <template v-for="(link, key) in pagination.meta.links" :key="key">
        
        <!-- Enlace Deshabilitado (Ej. "Anterior" en la pág. 1) -->
        <span v-if="link.url === null"
              v-html="link.label"
              class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-gray-50 text-sm font-medium text-gray-400 cursor-not-allowed"
              :class="{ 
                'rounded-l-md': key === 0, 
                'rounded-r-md': key === pagination.meta.links.length - 1 
              }"
        />
        
        <!-- Enlace Normal / Activo (usando <Link> de Inertia) -->
        <Link v-else
              :href="link.url"
              v-html="link.label"
              class="relative inline-flex items-center px-4 py-2 border text-sm font-medium"
              :class="{
                'z-10 bg-indigo-50 border-indigo-500 text-indigo-600': link.active,
                'bg-white border-gray-300 text-gray-700 hover:bg-gray-50': !link.active,
                'rounded-l-md': key === 0,
                'rounded-r-md': key === pagination.meta.links.length - 1
              }"
        />
      </template>
    </nav>
  </div>
</template>

<script>
import { Link } from "@inertiajs/inertia-vue3";

export default {
    props:{
        pagination: Object,
    },
    components:{
        Link,
    },
}
</script>
