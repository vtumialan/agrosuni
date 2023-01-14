<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import BreezeLabel from '@/Components/Label.vue';
import BreezeInput from '@/Components/Input.vue';
import BreezeTextArea from '@/Components/Textarea.vue';
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
const props = defineProps({
    provider: Object,
});
const form = useForm({
    name: props.provider.name,
    document_id: props.provider.document_id,
    address: props.provider.address,
    contact: props.provider.contact,
    phone: props.provider.phone,
    email: props.provider.email
});
const submit = () => {
    form.put(route('providers.update', props.provider.id));
};
</script>
<template>
    <Head title="Dashboard" />
    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Editar Proveedor
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div className="flex items-center justify-between mb-6">
                            <Link
                                className="px-6 py-2 text-white bg-blue-500 rounded-md focus:outline-none"
                                :href="route('providers.index')"
                            >
                                Volver
                            </Link>
                        </div>
                        <form name="createForm" @submit.prevent="submit">
                            <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
                                <div className="mx-4 mb-4">
                                    <BreezeLabel for="name" value="Nombre de Proveedor" />
                                    <BreezeInput
                                        id="name"
                                        type="text"
                                        class="mt-1 block w-full"
                                        v-model="form.name"
                                        autofocus />
                                    <span className="text-red-600" v-if="form.errors.name">
                                        {{ form.errors.name }}
                                    </span>
                                </div>
                                <div className="mx-4 mb-4">
                                    <BreezeLabel for="document_id" value="RUC" />
                                    <BreezeInput
                                        id="document_id"
                                        type="text"
                                        class="mt-1 block w-full"
                                        v-model="form.document_id"
                                        autofocus />
                                    <span className="text-red-600" v-if="form.errors.document_id">
                                        {{ form.errors.document_id }}
                                    </span>
                                </div>
                                <div className="mx-4 mb-4">
                                    <BreezeLabel for="address" value="Dirección" />
                                    <BreezeInput
                                        id="address"
                                        type="text"
                                        class="mt-1 block w-full"
                                        v-model="form.address"
                                        autofocus />
                                    <span className="text-red-600" v-if="form.errors.address">
                                        {{ form.errors.address }}
                                    </span>
                                </div>
                                <div className="mx-4 mb-4">
                                    <BreezeLabel for="contact" value="Persona de Contacto" />
                                    <BreezeInput
                                        id="contact"
                                        type="text"
                                        class="mt-1 block w-full"
                                        v-model="form.contact"
                                        autofocus />
                                    <span className="text-red-600" v-if="form.errors.contact">
                                        {{ form.errors.contact }}
                                    </span>
                                </div>
                                <div className="mx-4 mb-4">
                                    <BreezeLabel for="email" value="Email" />
                                    <BreezeInput
                                        id="email"
                                        type="text"
                                        class="mt-1 block w-full"
                                        v-model="form.email"
                                        autofocus />
                                    <span className="text-red-600" v-if="form.errors.email">
                                        {{ form.errors.email }}
                                    </span>
                                </div>
                                <div className="mx-4 mb-4">
                                    <BreezeLabel for="phone" value="Teléfono" />
                                    <BreezeInput
                                        id="phone"
                                        type="text"
                                        class="mt-1 block w-full"
                                        v-model="form.phone"
                                        autofocus />
                                    <span className="text-red-600" v-if="form.errors.phone">
                                        {{ form.errors.phone }}
                                    </span>
                                </div>
                            </div>
                            <div className="grid grid-cols-1">
                                <div className="mt-4">
                                    <button
                                        type="submit"
                                        className="px-6 py-2 font-bold text-white bg-green-500 rounded-md"
                                    >
                                        Guardar
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>