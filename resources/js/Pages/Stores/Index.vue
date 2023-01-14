<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import { PencilSquareIcon, TrashIcon } from '@heroicons/vue/24/solid';
import { TailwindPagination } from 'laravel-vue-pagination';
import { ref } from 'vue';

const providerData = ref({});

const getResults = async (page = 1) => {
    const response = await fetch(`api/stores?page=${page}`);
    providerData.value = await response.json();
}

getResults();

const form = useForm();

function destroy(id) {
    if (confirm("Are you sure you want to Delete")) {
        form.delete(route('stores.destroy', id));
    }
}
</script>
<template>
    <Head title="Dashboard" />
    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Locales
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div className="flex items-center justify-between mb-6">
                            <Link
                                className="px-6 py-2 text-white bg-green-500 rounded-md focus:outline-none"
                                :href="route('stores.create')"
                            >
                                Crear Local
                            </Link>
                        </div>
                        <table className="table-fixed w-full">
                            <thead>
                                <tr className="bg-gray-100">
                                    <th className="px-4 py-2 w-14">No.</th>
                                    <th className="px-4 py-2">Local</th>
                                    <th className="px-4 py-2">Tipo</th>
                                    <th className="px-4 py-2">Persona Contacto</th>
                                    <th className="px-4 py-2">Dirección</th>
                                    <th className="px-4 py-2 w-40">Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="provider in providerData.data" :key="provider.id">
                                    <td className="border px-4 py-2">{{ provider.id }}</td>
                                    <td className="border px-4 py-2">{{ provider.name }}</td>
                                    <td className="border px-4 py-2">{{ provider.type }}</td>
                                    <td className="border px-4 py-2">
                                        {{ provider.contact }} ({{ provider.phone }})
                                    </td>
                                    <td className="border px-4 py-2">{{ provider.address }}</td>
                                    <td className="border px-4 py-2 text-center align-middle grid grid-cols-2">
                                        <div className="h-8">
                                            <Link
                                                :href="route('stores.edit', provider.id)"
                                                tabIndex="1"
                                                type="button"
                                                className="mx-1 px-3 py-1 text-sm text-white bg-blue-500 rounded-md"
                                            >
                                                <PencilSquareIcon class="h-6 w-6 text-white-500"/>
                                            </Link>
                                        </div>
                                        <div className="h-8">
                                            <button
                                                @click="destroy(provider.id)"
                                                tabIndex="-1"
                                                type="button"
                                                className="mx-1 px-3 py-1 text-sm text-white bg-red-500 rounded-md"
                                            >
                                                <TrashIcon class="h-6 w-6 text-white-500"/>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div className="text-center w-full pt-4">
                            <TailwindPagination
                                :data="providerData"
                                @pagination-change-page="getResults"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>

</template>
