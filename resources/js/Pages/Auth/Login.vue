<script setup>
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import AuthenticationCard from '@/Components/AuthenticationCard.vue';
import AuthenticationCardLogo from '@/Components/AuthenticationCardLogo.vue';
import Checkbox from '@/Components/Checkbox.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
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
const password = ref('');

const togglePasswordVisibility = () => {
  showPassword.value = !showPassword.value;
};
</script>

<template>
    <Head title="Log in" />

    <AuthenticationCard>
        <template #logo>
            <AuthenticationCardLogo />
        </template>

        <div class="border-b border-gray-300 mb-12 mt-9 text-center w-[80%] mx-auto">
       <span class="inline-block border-b-2 border-primary px-4 text-gray-600">Iniciar sesión</span>
    </div>

        <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
            {{ status }}
        </div>

        <form @submit.prevent="submit">
            <div>
                <InputLabel for="id" value="Número de empleado" class="text-gray-600" />
                <TextInput
                    id="id"
                    v-model="form.id"
                    type="number"
                    class="mt-1 block w-full"
                    required
                    autofocus
                />
                <InputError class="mt-2" :message="form.errors.id" />
            </div>

            <div class="mt-4 relative">
        <InputLabel for="password" value="Contraseña" class="text-gray-600" />
        <div class="flex justify-center items-center">
          <TextInput
            id="password"
            v-model="form.password"
            :type="showPassword ? 'text' : 'password'"
            class="mt-1 block w-full bg-transparent placeholder:text-[#9A9A9A]"
            required
            autocomplete="current-password"
            placeholder="Contraseña"
          />
          <i
            :class="showPassword ? 'fa fa-eye-slash' : 'fa fa-eye'"
            class="text-gray-400 ml-2 cursor-pointer absolute right-3 top-8"
            @click="togglePasswordVisibility"
          ></i>
        </div>
        <InputError class="mt-2" :message="form.errors.password" />
      </div>

            <div class="block mt-4">
                <label class="flex items-center">
                    <Checkbox v-model:checked="form.remember" name="remember" />
                    <span class="ml-2 text-sm text-gray-600">Mantener abierta la sesión</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                <Link v-if="canResetPassword" :href="route('password.request')" class="underline text-sm text-gray-600 hover:text-gray-900">
                    ¿Olvidaste tu contraseña?
                </Link>
                <div class="mx-auto mt-5">
                    <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Ingresar <i class="fa-solid fa-arrow-right ml-2"></i>
                    </PrimaryButton>
                </div>
            </div>
        </form>
    </AuthenticationCard>
</template>
