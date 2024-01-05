<template>
  <div
    class="bg-transparent border-2 border-gray3 rounded-2xl p-2 mx-3 my-2 hover:bg-slate-100"
>
    <Link :href="route('users.show', user.id)">
        <div class="flex">
            <figure v-if="$page.props.jetstream.managesProfilePhotos" class="shrink-0 mr-3 mt-1">
                <img class="h-14 w-14 rounded-full object-cover" :src="user.profile_photo_url"
                  :alt="user.name" />
            </figure>
            <section class="flex flex-col flex-1">
            <div class="flex justify-between">
                <h1 class="text-xs font-bold">ID: {{ user.id }} | {{ user.name }}</h1>
                <span
                v-if="user.is_active"
                class="bg-green-100 text-green-700 text-xs px-2 py-px rounded-lg"
                >Activo</span
                >
                <span
                v-else
                class="bg-red-100 text-red-700 text-xs px-2 py-px rounded-lg"
                >Inactivo</span
                >
            </div>
            <div></div>
            <p class="text-xs text-gray-500">
                Turno: {{ user.employee_properties?.shift }} | Ingresó el:
                {{ user.created_at }}
            </p>
            <p class="text-xs text-gray-500">
                <i class="fa-solid fa-mobile-screen-button mr-1"></i>
                {{ user.phone_number }}
            </p>
            <p class="text-xs text-gray-500">
                <i class="fa-regular fa-envelope mr-1"></i>
                {{ user.email }}
            </p>
            </section>
        </div>
    </Link>
</div>
</template>

<script>
import { Link } from "@inertiajs/inertia-vue3";

export default {
data(){
    return {

    }
},
components:{
Link
},
props:{
user: Object
}
}
</script>
