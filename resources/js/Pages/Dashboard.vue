
<template>
  <AppLayout title="Dashboard">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Inicio</h2>
    </template>
<!-- -----------------------Registro de entrada y salida------------ -->
    <div class="py-7">
      <div class="globe-container">
            <div class="globe">
               <div class="flex items-center justify-between">
                    <div>
                         <i class="fa-regular fa-clock text-lg mr-2"></i>
                         No has registrado Entrada.
                    </div>
                    <Link :href="route('qr-scanner')">
               <SecondaryButton>Entrada</SecondaryButton>
                    </Link>
               </div> 
               <div class="flex items-center justify-between">
                    <div>
                         <i class="fa-regular fa-clock text-lg text-green-600 mr-2"></i>
                         <span class="text-green-600">Entrada a las 9:00 am.</span> 
                    </div>
                    <SecondaryButton>Salida</SecondaryButton>
               </div> 
               <div class="flex items-center justify-between">
                    <div>
                         <i class="fa-regular fa-clock text-lg text-yellow-600 mr-2"></i>
                         <span class="text-yellow-600">Entrada a las 9:20 am (Retardo).</span> 
                    </div>
                    <SecondaryButton>Salida</SecondaryButton>
               </div> 
               <div class="flex items-center">
                    <i class="fa-regular fa-clock text-lg text-blue-600 mr-2"></i>
                    <span class="text-blue-600">Salida a las 2:05 pm.</span> 
               </div> 
            </div>
<!-- ------------Permutas------------- -->
            <div class="globe">
              <div class="globe-title">
                    Permutas
              </div>
               <div>
                    <p class="text-center">No hay información para mostrar.</p> 
                    <p>información de permutas.</p> 
               </div> 
            </div>
<!-- -----------------Permisos----------------- -->
            <div class="globe">
              <div class="globe-title">
                    Permisos
              </div>
               <div>
                    <p class="text-center">No hay información para mostrar.</p> 
               </div> 
               <div class="flex justify-between items-center">
                   <span><i class="fa-regular fa-calendar-days mr-2"></i>2-Ene-2022</span> 
                    <span class="text-orange-600"><i class="fa-solid fa-hourglass-start mr-2"></i>Revisando.</span> 
               </div>
               <div class="flex justify-between items-center">
                    <span><i class="fa-regular fa-calendar-days mr-2"></i>2-Ene-2022</span>
                    <span class="text-green-600"><i class="fa-solid fa-check mr-2"></i>Aprobado.</span> 
               </div>
               <div class="flex justify-between items-center">
                    <span><i class="fa-regular fa-calendar-days mr-2"></i>2-Ene-2022</span>
                    <span class="text-red-600"><i class="fa-solid fa-xmark mr-2"></i>Rechazado.</span> 
               </div>
            </div>
<!-- -----------------Préstamos----------------- -->
            <div class="globe">
              <div class="globe-title">
                    Préstamos
              </div>
               <div>
                    <p class="text-center">No hay información para mostrar.</p> 
               </div> 
              <div class="flex justify-between items-center">
                   <span><i class="fa-regular fa-calendar-days mr-2"></i>2-Ene-2022</span> 
                   <span><i class="fa-regular fa-dollar-sign mr-2"></i>1,000</span> 
                    <span class="text-orange-600"><i class="fa-solid fa-hourglass-start mr-2"></i>Revisando.</span> 
               </div>
               <div class="flex justify-between items-center">
                    <span><i class="fa-regular fa-calendar-days mr-2"></i>2-Ene-2022</span>
                    <span><i class="fa-regular fa-dollar-sign mr-2"></i>1,000</span>
                    <span class="text-green-600"><i class="fa-solid fa-check mr-2"></i>Aprobado.</span> 
               </div>
               <div class="flex justify-between items-center">
                    <span><i class="fa-regular fa-calendar-days mr-2"></i>2-Ene-2022</span>
                    <span><i class="fa-regular fa-dollar-sign mr-2"></i>1,000</span>
                    <span class="text-red-600"><i class="fa-solid fa-xmark mr-2"></i>Rechazado.</span> 
               </div>
            </div>
      
      </div>
    </div>
  </AppLayout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import { Link } from "@inertiajs/inertia-vue3";

export default {
    data(){
        return{

        }
    },
    components:{
     AppLayout,
     PrimaryButton,
     SecondaryButton,
     Link,
    },
    props:{

    },
}
</script>