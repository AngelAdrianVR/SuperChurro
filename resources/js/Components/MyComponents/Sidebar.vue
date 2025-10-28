<script>
import { Link } from '@inertiajs/inertia-vue3';
import ApplicationMark from '@/Components/ApplicationMark.vue';

export default {
  // Usando Options API como solicitaste
  name: 'Sidebar',
  components: {
    Link,
    ApplicationMark,
  },
  // 1. Definimos el evento que vamos a emitir
  emits: ['closeSidebar'],
  props: {
    sidebarOpen: {
      type: Boolean,
      default: false,
    },
    user: {
      type: Object,
      required: true,
    },
    menues: {
      type: Array,
      required: true,
    },
    adminMenues: {
      type: Array,
      required: true,
    },
  },
  
  methods: {
    // Exponemos la función route() de Ziggy para usarla en el template
    route: window.route,

    // Función para añadir clases de link activo
    activeClass(isActive) {
      return isActive 
        ? 'bg-slate-700 text-white font-semibold' 
        : 'text-slate-200 hover:bg-slate-700 hover:text-white';
    },

    // 2. Creamos el método que maneja el clic y emite el evento
    handleLinkClick() {
      // Solo cerramos el sidebar si estamos en vista móvil
      // 768px es el breakpoint 'md' de Tailwind
      if (window.innerWidth < 768) { 
        this.$emit('closeSidebar');
      }
    }
  },

  computed: {
    // Filtramos los menús aquí para mantener el template limpio
    filteredMenues() {
      return this.menues.filter(menu => menu.admin_can_see || !this.user.is_admin);
    }
  }
};
</script>

<template>
  <!-- 
    Sidebar:
    - Fijo, altura de pantalla completa, ancho estándar (w-64).
    - Moderno (bg-slate-900).
    - Se oculta/muestra con 'transform' para una animación suave.
    - Se aplica '-translate-x-full' (oculto) o 'translate-x-0' (visible).
  -->
  <aside
    :class="[
      'fixed inset-y-0 left-0 z-40 h-screen w-64 bg-slate-900 transition-transform duration-300 ease-in-out',
      sidebarOpen ? 'translate-x-0' : '-translate-x-full'
    ]"
    aria-label="Sidebar"
  >
    <div class="flex h-full flex-col overflow-y-auto px-4 py-5">
      <!-- 3. Añadimos el evento @click al logo -->
      <Link :href="route('dashboard')" @click="handleLinkClick" class="flex items-center pb-5 mb-5 border-b border-slate-700">
        <ApplicationMark class="block h-10 w-auto" />
      </Link>

      <!-- Contenedor principal de navegación -->
      <div class="flex flex-1 flex-col justify-between">
        
        <!-- Menú Principal -->
        <nav class="flex-1 space-y-2">
          <Link
            v-for="(menu, index) in filteredMenues"
            :key="'menu-' + index"
            :href="route(menu.route_name)"
            :class="[
              'group flex items-center rounded-lg p-2.5 text-base font-normal transition duration-75',
              activeClass(menu.is_active)
            ]"
            @click="handleLinkClick" 
          >
            <!-- Aquí puedes añadir iconos si los tienes -->
            <!-- <i class="fa-solid fa-home mr-3 text-slate-400 group-hover:text-white"></i> -->
            <span class="ml-1">{{ menu.label }}</span>
          </Link>
        </nav>

        <!-- Menú de Administrador (Abajo) -->
        <div v-if="user.is_admin" class="pt-4 mt-4 border-t border-slate-700">
           <h3 class="px-2 mb-2 text-xs font-semibold uppercase text-slate-400 tracking-wider">
             Administración
           </h3>
          <nav class="space-y-2">
            <Link
              v-for="(admin_menu, index) in adminMenues"
              :key="'admin-' + index"
              :href="route(admin_menu.route_name)"
              :class="[
                'group flex items-center rounded-lg p-2.5 text-base font-normal transition duration-75',
                activeClass(admin_menu.is_active)
              ]"
              @click="handleLinkClick"
            >
              <!-- <i class="fa-solid fa-user-gear mr-3 text-slate-400 group-hover:text-white"></i> -->
              <span class="ml-1">{{ admin_menu.label }}</span>
            </Link>
          </nav>
        </div>

      </div>
    </div>
  </aside>
</template>

