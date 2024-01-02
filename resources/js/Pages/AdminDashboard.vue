
<template>
  <AppLayout title="Dashboard">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
        Inicio
      </h2>
    </template>

  <!-- Avisos ----------------------------------------- -->
    <section v-if="notices.length > 0">
      <div class="lg:col-span-3 mt-9">
        <h1 class="font-bold text-lg text-primary text-center">AVISOS</h1>
    </div>

    <div v-if="notices.length">
      <div v-for="notice in notices" :key="notice.id" class="globe my-2">
          <div class="globe-title">{{notice.title}}</div>
          <div class="flex justify-between items-center text-xs">
            <p class="text-center">{{ notice.content }}</p>
          </div>
      </div>
    </div>
          <p v-else class="text-center text-gray-500 text-xs">No hay avisos para mostrar.</p>
    </section>

    <div class="md:mx-12 mx-1">
      <p class="text-primary font-bold text-lg">Operaciones</p>

      <!-- ----------------------------- Solicitudes de mercancia starts ------------------------------- -->
      <div class="globe-container flex-col">
        <div class="globe relative z-0">
          <!-- <Link :href="route('products.show', product.id)"> -->
          <div class="globe-title pb-2">
            <span class="text-gray-700 justify-center"
              >Solicitud de mercancía</span
            >
            <i
              class="fa-solid fa-plus text-primary justify-end absolute right-4 border border-transparent hover:bg-gray4 cursor-pointer p-1 rounded-full transition ease-linear duration-200"
            ></i>
          </div>
          <div class="flex flex-col">
            <span
              ><i class="fa-solid fa-circle-dot mr-1 text-xs"></i> Stock mínimo:
            </span>
            <span
              ><i class="fa-solid fa-circle-dot mr-1 text-xs"></i> Unidad de
              medida:
            </span>
            <span
              ><i class="fa-solid fa-circle-dot mr-1 text-xs"></i> Precio
              actual: $
            </span>
            <span
              ><i class="fa-solid fa-circle-dot mr-1 text-xs"></i> Precio a
              empleados: $
            </span>
          </div>
          <!-- </Link> -->
        </div>
        <!-- ----------------------------- Solicitudes de mercancia ends ------------------------------- -->

        <!-- ----------------------------- Colaboradores en carrito / cocina starts ------------------------------- -->
        <div class="globe relative z-0">
          <!-- <Link :href="route('products.show', product.id)"> -->
          <div class="globe-title pb-2">
            <span class="text-gray-700 justify-center"
              >Colaboradores en carrito / cocina</span
            >
            <i
              class="fa-solid fa-pencil text-primary justify-end absolute right-4 border border-transparent hover:bg-gray4 cursor-pointer p-1 rounded-full transition ease-linear duration-200"
            ></i>
          </div>
          <p class="text-primary mb-2">Carrito</p>
          <div class="flex flex-col">
            <span
              ><i class="fa-regular fa-circle-user text-gray-600 mr-3"></i>
              Nombre del colaborador
            </span>
            <span
              ><i class="fa-regular fa-circle-user text-gray-600 mr-3"></i>
              Nombre del colaborador
            </span>
          </div>
          <div class="flex flex-col">
            <p class="text-primary my-2">Cocina</p>
            <span
              ><i class="fa-regular fa-circle-user text-gray-600 mr-3"></i>
              Nombre del colaborador
            </span>
            <span
              ><i class="fa-regular fa-circle-user text-gray-600 mr-3"></i>
              Nombre del colaborador
            </span>
          </div>
          <!-- </Link> -->
        </div>
        <!-- ----------------------------- Colaboradores en carrito / cocina ends ------------------------------- -->

        <!-- ----------------------------- Cortes starts ------------------------------- -->
        <div class="globe relative z-0">
          <!-- <Link :href="route('products.show', product.id)"> -->
          <div class="globe-title pb-2">
            <span class="text-gray-700 justify-center">Cortes</span>
            <i
              class="fa-solid fa-plus text-primary justify-end absolute right-4 border border-transparent hover:bg-gray4 cursor-pointer p-1 rounded-full transition ease-linear duration-200"
            ></i>
          </div>
          <p class="text-primary mb-2">Carrito</p>
          <div class="flex flex-col">
            <span
              ><i class="fa-regular fa-circle-user text-gray-600 mr-3"></i>
              Nombre del colaborador
            </span>
            <span
              ><i class="fa-regular fa-circle-user text-gray-600 mr-3"></i>
              Nombre del colaborador
            </span>
          </div>
          <div class="flex flex-col">
            <p class="text-primary my-2">Cocina</p>
            <span
              ><i class="fa-regular fa-circle-user text-gray-600 mr-3"></i>
              Nombre del colaborador
            </span>
            <span
              ><i class="fa-regular fa-circle-user text-gray-600 mr-3"></i>
              Nombre del colaborador
            </span>
          </div>
          <!-- </Link> -->
        </div>
        <!-- ----------------------------- Cortes ends ------------------------------- -->

        <!-- ----------------------------- Cumpleaños starts ------------------------------- -->
        <div class="globe relative text-center z-0">
          <div class="globe-title pb-2">
            <span class="text-gray-700 justify-center">Cumpleaños</span>
            <i
              class="fa-solid fa-pencil text-primary justify-end absolute right-4 border border-transparent hover:bg-gray4 cursor-pointer p-1 rounded-full transition ease-linear duration-200"
            ></i>
          </div>
          <div class="flex flex-col">
            <span
              ><i class="fa-regular fa-circle-user text-gray-600 mr-3"></i>
              Nombre del colaborador
            </span>
            <span
              ><i class="fa-regular fa-circle-user text-gray-600 mr-3"></i>
              (Fecha de hoy)
            </span>
            <i
              class="fa-solid fa-cake-candles text-6xl text-primary mt-3 text-center"
            ></i>
          </div>
        </div>
        <!-- ----------------------------- Cumpleaños ends ------------------------------- -->
      </div>

      <p class="text-primary font-bold text-lg mt-5">Estadisticas</p>

      <!-- ----------------------------- ventas chart starts ------------------------------- -->
      <div class="globe-container flex-col">
        <div class="globe relative z-0">
          <!-- <Link :href="route('products.show', product.id)"> -->
          <div class="globe-title pb-2">
            <span class="text-gray-700 justify-center"
              >Ventas (mes en curso)</span
            >
            <i
              class="fa-solid fa-plus text-primary justify-end absolute right-4 border border-transparent hover:bg-gray4 cursor-pointer p-1 rounded-full transition ease-linear duration-200"
            ></i>
          </div>

          <FinancesChart />

          <!-- </Link> -->
        </div>
        <!-- ----------------------------- ventas chart ends ------------------------------- -->

              <!-- ----------------------------- ventas chart starts ------------------------------- -->
        <div class="globe relative z-0">
          <!-- <Link :href="route('products.show', product.id)"> -->
          <div class="globe-title pb-2">
            <span class="text-gray-700 justify-center"
              >Profit (mes en curso)</span
            >
            <i
              class="fa-solid fa-plus text-primary justify-end absolute right-4 border border-transparent hover:bg-gray4 cursor-pointer p-1 rounded-full transition ease-linear duration-200"
            ></i>
          </div>
          <IncomesOutcomesChart />
          <!-- </Link> -->

        </div>
        <!-- ----------------------------- ventas chart ends ------------------------------- -->
      </div>
    </div>
<!-- 
      <SecondaryButton @click="getPosition" class="mt-3"
        >Probar geolocalización</SecondaryButton
      > -->
  </AppLayout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import FinancesChart from "@/Components/FinancesChart.vue";
import IncomesOutcomesChart from "@/Components/IncomesOutcomesChart.vue";
import { Link } from "@inertiajs/inertia-vue3";

export default {
  data() {
    return {
      geolocation_options: {
        enableHighAccuracy: true,
        timeout: 5000,
        maximumAge: 0,
      },
      valid_areas: [
        {
          label: "Audicarr",
          latitudes: [20.71203, 20.71208],
          longitudes: [-103.37882, -103.37863],
        },
        {
          label: "Carrito",
          latitudes: [20.71246, 20.71258],
          longitudes: [-103.37795, -103.37776],
        },
        {
          label: "Casa",
          latitudes: [20.76441, 20.76641],
          longitudes: [-103.42651, -103.40651],
        },
      ],
    };
  },
  components: {
    AppLayout,
    PrimaryButton,
    SecondaryButton,
    Link,
    FinancesChart,
    IncomesOutcomesChart
  },
  props: {
    checked_in: Boolean,
    checked_out: Boolean,
    leaves: Array,
    loan: Object,
    notices: Array,
  },
  methods: {
    getPosition() {
      if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
          this.analyzePosition,
          this.error,
          this.geolocation_options
        );
      } else {
        alert(
          "error",
          "Geolocación no soportada por navegador, inténtalo en uno diferente"
        );
      }
    },
    error(e) {
      alert("ERROR(" + e.code + "): " + e.message);
    },
    analyzePosition(current_position) {
      const validated_area = this.valid_areas.find((valid_area) =>
        this.isCurrentPositionInsideArea(valid_area, current_position)
      );

      if (validated_area !== undefined) {
        alert(
          validated_area.label +
            ". Posición: " +
            current_position.coords.latitude +
            ", " +
            current_position.coords.longitude
        );
      } else {
        alert(
          "Ubicación no válida para registrar asistencia." +
            current_position.coords.latitude +
            ", " +
            current_position.coords.longitude
        );
      }
    },
    isCurrentPositionInsideArea(valid_area, current_position) {
      var current_latitude = current_position.coords.latitude;
      var current_longitude = current_position.coords.longitude;

      if (
        this.between(current_latitude, valid_area.latitudes) &&
        this.between(current_longitude, valid_area.longitudes)
      )
        return valid_area;
      else return 0;
    },
    between(x, range) {
      return x >= range[0] && x <= range[1];
    },
  },
};
</script>