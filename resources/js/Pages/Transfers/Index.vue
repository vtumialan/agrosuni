<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { EyeIcon } from '@heroicons/vue/24/solid';
import { Head, Link } from '@inertiajs/inertia-vue3';
import { TailwindPagination } from 'laravel-vue-pagination';
import { ref } from 'vue';

const transferData = ref({});

const getResults = async (page = 1) => {
    const response = await fetch(`api/transfers?page=${page}`);
    transferData.value = await response.json();
}

getResults();
</script>
<template>
    <Head title="Dashboard" />
    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Ordenes de Transferencia
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div className="flex items-center justify-between mb-6">
                            <Link
                                className="px-6 py-2 text-white bg-green-500 rounded-md focus:outline-none"
                                :href="route('transfers.create')"
                            >
                                Crear Orden de Transferencia
                            </Link>
                        </div>
                        <table className="table-fixed w-full">
                            <thead>
                                <tr className="bg-gray-100">
                                    <th className="px-4 py-2 w-14">No.</th>
                                    <th className="px-4 py-2">Local Origen</th>
                                    <th className="px-4 py-2">Local Destino</th>
                                    <th className="px-4 py-2 w-36">Solicitado (Fecha)</th>
                                    <th className="px-4 py-2 w-36">Completado (Fecha)</th>
                                    <th className="px-4 py-2 w-28">Status</th>
                                    <th className="px-4 py-2 w-56">Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="transfer in transferData.data" :key="transfer.id">
                                    <td className="border px-4 py-2">{{ transfer.id }}</td>
                                    <td className="border px-4 py-2">{{ transfer.origin_store.name }}</td>
                                    <td className="border px-4 py-2">{{ transfer.destination_store.name }}</td>
                                    <td className="border px-4 py-2 text-center">{{ transfer.user_created.name }} <br/> ({{ transfer.created_date }})</td>
                                    <td className="border px-4 py-2 text-center">{{ transfer.user_completed ? transfer.user_completed.name : '-'  }} <br/> {{ transfer.completed ? '(' + (transfer.completed_date || '-') +')' : '' }}</td>
                                    <td className="border px-4 py-2">{{ transfer.status_name }}</td>
                                    <td className="border px-4 py-2 text-center align-middle grid grid-cols-5 w-56" style="padding-top: 16px;padding-bottom: 16px;">
                                        <Link
                                            :href="route('transfers.edit', transfer.id)"
                                            tabIndex="-1"
                                            type="button"
                                            className="mx-1 py-1 text-sm text-black bg-white-500 rounded-md"
                                            >
                                            <EyeIcon class="h-6 w-6 text-white-500"/>
                                        </Link>
                                        <button v-if="transfer.status == 0"
                                            @click="changeStatus(transfer.id, 1)"
                                            tabIndex="-1"
                                            type="button"
                                            className="mx-1 px-2 py-1 text-sm text-white bg-green-500 rounded-md col-span-2"
                                        >
                                            Finalizar
                                        </button>
                                        <button v-if="transfer.status == 0"
                                            @click="changeStatus(transfer.id, 2)"
                                            tabIndex="-1"
                                            type="button"
                                            className="mx-1 px-2 py-1 text-sm text-white bg-red-500 rounded-md col-span-2"
                                        >
                                            Cancelar
                                        </button>
                                        <button v-if="transfer.status == 1"
                                            type="button"
                                            className="mx-1 px-3 py-1 text-sm text-white bg-gray-500 rounded-md col-span-4"
                                            :disabled="true"
                                        >
                                            Finalizada
                                        </button>
                                        <button v-if="transfer.status == 2"
                                            type="button"
                                            className="mx-1 px-3 py-1 text-sm text-white bg-gray-500 rounded-md col-span-4"
                                            :disabled="true"
                                            style="background-color: black;"
                                        >
                                            Cancelada
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div className="text-center w-full pt-4">
                            <TailwindPagination
                                :data="transferData"
                                @pagination-change-page="getResults"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>
<script>
export default {
    methods: {
        changeStatus(transfer_id, status) {
            axios.put("/transfers/" + transfer_id, {
                status: status,
            })
                .then(function (response) {
                if (response.data.status === "success") {
                    window.location.href = response.data.url;
                }
                if (response.data.status === "error") {
                    window.location.href = response.data.url;
                }
            })
                .catch(function (error) {
                console.log("error");
                console.log(error);
            });
        },
    },
    components: { EyeIcon }
};
</script>