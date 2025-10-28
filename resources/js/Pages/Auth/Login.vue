<script setup>
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import AuthenticationCard from '@/Components/AuthenticationCard.vue';
import AuthenticationCardLogo from '@/Components/AuthenticationCardLogo.vue';
import Checkbox from '@/Components/Checkbox.vue';
import InputError from '@/Components/InputError.vue';
// InputLabel ya no se usa, usaremos <label> directamente
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { ref } from 'vue';

defineProps({
    canResetPassword: Boolean,
    status: String,
});

const form = useForm({
    id: '',
    password: '',
    remember: true,
});

const submit = () => {
    form.transform(data => ({
        ...data,
        remember: form.remember ? 'on' : '',
    })).post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};

const showPassword = ref(false);

const togglePasswordVisibility = () => {
    showPassword.value = !showPassword.value;
};
</script>

<template>
    <Head title="Log in" />

    <AuthenticationCard>
        <template #logo>
            <!-- La animación se aplica al logo -->
            <div class="fade-in-down">
                <AuthenticationCardLogo />
            </div>
        </template>

        <!-- 
          MODERNIZACIÓN:
          - Encabezado: Reemplazado el 'border-b' por un título y subtítulo limpios y centrados.
          - Transiciones: Añadidas clases 'fade-in-down' y 'fade-in-up' para la animación.
        -->
        <div class="text-center mb-10">
            <h2 class="text-3xl font-bold tracking-tight text-gray-900 fade-in-down" style="animation-delay: 0.2s;">
                Iniciar sesión
            </h2>
            <p class="mt-2 text-sm text-gray-600 fade-in-down" style="animation-delay: 0.4s;">
                Bienvenido de nuevo.
            </p>
        </div>

        <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
            {{ status }}
        </div>

        <!-- El formulario entra con animación 'fade-in-up' -->
        <form @submit.prevent="submit" class="fade-in-up" style="animation-delay: 0.6s;">
            <div>
                <!-- Label modernizado -->
                <label for="id" class="block text-sm font-medium leading-6 text-gray-900 mb-1">
                    Número de empleado
                </label>
                <TextInput id="id" v-model="form.id" type="number" class="mt-1 block w-full" required autofocus />
                <InputError class="mt-2" :message="form.errors.id" />
            </div>

            <!-- 
              MODERNIZACIÓN:
              - Espaciado: Aumentado de 'mt-4' a 'mt-6' para más aire.
              - Icono de Ojo: Posicionamiento más limpio y robusto usando 'absolute inset-y-0'.
            -->
            <div class="mt-6">
                <label for="password" class="block text-sm font-medium leading-6 text-gray-900 mb-1">
                    Contraseña
                </label>
                <div class="relative">
                    <TextInput id="password" v-model="form.password" :type="showPassword ? 'text' : 'password'"
                        class="block w-full" required autocomplete="current-password" placeholder="Contraseña" />
                    <!-- Icono posicionado con absolute dentro del div relative -->
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                         <i :class="showPassword ? 'fa fa-eye-slash' : 'fa fa-eye'"
                            class="text-gray-400 cursor-pointer"
                            @click="togglePasswordVisibility"></i>
                    </div>
                </div>
                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="flex items-center justify-between mt-6">
                 <!-- Checkbox modernizado (label) -->
                <div class="flex items-center">
                    <Checkbox v-model:checked="form.remember" name="remember" />
                    <label for="remember" class="ml-2 block text-sm text-gray-700">
                        Mantener sesión
                    </label>
                </div>

                 <!-- Link modernizado -->
                <div class="text-sm">
                    <Link v-if="canResetPassword" :href="route('password.request')"
                        class="font-medium text-blue-600 hover:text-blue-500">
                        ¿Olvidaste tu contraseña?
                    </Link>
                </div>
            </div>

            <!-- 
              MODERNIZACIÓN:
              - Botón: Movido a 'mt-8' y hecho 'w-full' para un Call to Action claro.
            -->
            <div class="mt-8">
                <PrimaryButton class="w-full" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Ingresar <i class="fa-solid fa-arrow-right ml-2"></i>
                </PrimaryButton>
            </div>
        </form>
    </AuthenticationCard>
</template>

<!-- Estilos para las transiciones de texto que pediste -->
<style>
    @keyframes fadeInDown {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    /* Clases para aplicar las animaciones */
    .fade-in-down {
        animation: fadeInDown 0.6s ease-out forwards;
    }
    .fade-in-up {
        opacity: 0; /* Empezar invisible */
        animation: fadeInUp 0.6s ease-out forwards;
    }
</style>
