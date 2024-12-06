<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3'; // Para manejar el formulario con Inertia.js
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';

const form = useForm({
  title: '',
  description: '',
  url_image: '',
  price: '',
  prize: '',
  date_play: '',
  date_end: '',
  numbers_quantity: '',
  status: 'active',
  user_id: '', 
});

const submitForm = () => {
  form.post(route('loterias.store'));
};
</script>

<template>
    <Head title="Crear Loteria" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    Crear Loteria
                </h2>
                <Link :href="route('loterias.index')">
                    Ver Loterias
                </Link>
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg flex justify-center">
                    <form class="w-1/3" action="">
                        <div>
                            <InputLabel for="names" value="Name" />

                            <TextInput
                                id="names"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.names"
                                required
                                autofocus
                                autocomplete="names"
                            />

                            <InputError class="mt-2" :message="form.errors.names" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

