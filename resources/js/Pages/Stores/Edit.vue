<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import BreezeLabel from '@/Components/Label.vue';
import BreezeInput from '@/Components/Input.vue';
import BreezeTextArea from '@/Components/Textarea.vue';
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
const props = defineProps({
    store: Object,
    type: Object,
});
const form = useForm({
    name: props.store.name,
    type: props.type,
    address: props.store.address,
    contact: props.store.contact,
    phone: props.store.phone,
});
const submit = () => {
    form.put(route('stores.update', props.store.id));
};
</script>
<script>
import Multiselect from "vue-multiselect";

export default {
    components: {
        Multiselect,
    },
    data() {
        return {
            options: [
                {'id': '1', 'key': 'almacen', 'name': 'Almacén'},
                {'id': '2', 'key': 'tienda', 'name': 'Tienda'},
            ],
        };
    },
};
</script>
<template>
    <Head title="Dashboard" />
    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Editar Local
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div className="flex items-center justify-between mb-6">
                            <Link
                                className="px-6 py-2 text-white bg-blue-500 rounded-md focus:outline-none"
                                :href="route('stores.index')"
                            >
                                Volver
                            </Link>
                        </div>
                        <form name="createForm" @submit.prevent="submit">
                            <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
                                <div className="mx-4 mb-4">
                                    <BreezeLabel for="name" value="Nombre de Local" />
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
                                    <BreezeLabel for="type" value="Tipo" />
                                    <multiselect
                                        v-model="form.type"
                                        :options="options"
                                        placeholder="Select one"
                                        label="name"
                                        track-by="id"
                                    ></multiselect>
                                    <span
                                        className="text-red-600"
                                        v-if="form.errors.type"
                                    >
                                        {{ form.errors.type }}
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
<style src="vue-multiselect/dist/vue-multiselect.css"></style>