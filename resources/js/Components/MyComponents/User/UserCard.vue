<template>
  <!-- 
    Este componente ahora es un elemento de lista (el <Link> es el contenedor).
    Se diseña para vivir dentro de una tarjeta con bordes/divisores.
  -->
  <Link 
    :href="route('users.show', user.id)" 
    class="block px-6 sm:px-8 border rounded-lg py-5 hover:bg-gray-50 dar:hover:bg-gray-700 focus:outline-none focus:bg-gray-50 dar:focus:bg-gray-700 transition duration-150 ease-in-out"
  >
    <div class="flex items-center space-x-4">
      
      <!-- Foto de Perfil -->
      <figure v-if="$page.props.jetstream.managesProfilePhotos" class="shrink-0">
        <img class="h-12 w-12 rounded-full object-cover" :src="user.profile_photo_url" :alt="user.name" />
      </figure>
      
      <!-- Información del Usuario -->
      <div class="flex-1 min-w-0">
        
        <!-- Fila Superior (Nombre y Badge) -->
        <div class="flex items-center justify-between">
          <p class="text-sm font-medium text-indigo-600 dar:text-indigo-400 truncate">
            {{ user.name }}
            <span class="text-gray-500 dar:text-gray-400 font-normal">(ID: {{ user.id }})</span>
          </p>
          
          <!-- Badge de Estado -->
          <span v-if="user.is_active" class="ml-4 shrink-0 bg-green-100 text-green-800 dar:bg-green-900 dar:text-green-200 text-xs font-medium px-2.5 py-0.5 rounded-full">
            Activo
          </span>
          <span v-else class="ml-4 shrink-0 bg-red-100 text-red-800 dar:bg-red-900 dar:text-red-200 text-xs font-medium px-2.5 py-0.5 rounded-full">
            Inactivo
          </span>
        </div>

        <!-- Fila Inferior (Detalles) -->
        <div class="mt-1 flex flex-col sm:flex-row sm:flex-wrap sm:space-x-4">
          <p class="text-sm text-gray-600 dar:text-gray-400 truncate">
            <i class="fa-regular fa-envelope mr-1.5 opacity-75" aria-hidden="true"></i>
            {{ user.email }}
          </p>
          <p class="text-sm text-gray-600 dar:text-gray-400 truncate">
            <i class="fa-solid fa-mobile-screen-button mr-1.5 opacity-75" aria-hidden="true"></i>
            {{ user.phone_number ?? 'N/A' }}
          </p>
          <p class="text-sm text-gray-600 dar:text-gray-400 truncate">
            Turno: {{ user.employee_properties?.shift ?? 'N/A' }}
          </p>
        </div>

      </div>
    </div>
  </Link>
</template>

<script>
import { Link } from "@inertiajs/inertia-vue3";

export default {
  data() {
    return {};
  },
  components: {
    Link,
  },
  props: {
    user: Object,
  },
};
</script>
