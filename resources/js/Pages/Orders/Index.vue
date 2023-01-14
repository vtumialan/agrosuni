<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { EyeIcon } from '@heroicons/vue/24/solid';
import { Head, Link } from '@inertiajs/inertia-vue3';
import { TailwindPagination } from 'laravel-vue-pagination';
import { ref } from 'vue';

const orderData = ref({});

const getResults = async (page = 1) => {
    const response = await fetch(`api/orders?page=${page}`);
    orderData.value = await response.json();
}

getResults();
</script>
<template>
    <Head title="Dashboard" />
    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Ordenes de Compra
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div className="flex items-center justify-between mb-6">
                            <Link
                                className="px-6 py-2 text-white bg-green-500 rounded-md focus:outline-none"
                                :href="route('orders.create')"
                            >
                                Crear Orden de Compra
                            </Link>
                        </div>
                        <table className="table-fixed w-full">
                            <thead>
                                <tr className="bg-gray-100">
                                    <th className="px-4 py-2 w-14">No.</th>
                                    <th className="px-4 py-2">Proveedor</th>
                                    <th className="px-4 py-2 w-36">Local</th>
                                    <th className="px-4 py-2 w-32">Total</th>
                                    <th className="px-4 py-2 w-36">Socilitado por</th>
                                    <th className="px-4 py-2 w-28">Status</th>
                                    <th className="px-4 py-2 w-32">Fecha</th>
                                    <th className="px-4 py-2 w-56">Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="order in orderData.data" :key="order.id">
                                    <td className="border px-4 py-2">{{ order.id }}</td>
                                    <td className="border px-4 py-2">{{ order.provider.name }}</td>
                                    <td className="border px-4 py-2">{{ order.store.name }}</td>
                                    <td className="border px-4 py-2">S/. {{ order.total }}</td>
                                    <td className="border px-4 py-2">{{ order.user.name }}</td>
                                    <td className="border px-4 py-2">{{ order.status_name }}</td>
                                    <td className="border px-4 py-2">{{ order.date }}</td>
                                    <td className="border px-4 py-2 text-center align-middle grid grid-cols-5 w-56" style="padding-top: 16px;padding-bottom: 16px;">
                                        <Link
                                            :href="route('orders.edit', order.id)"
                                            tabIndex="-1"
                                            type="button"
                                            className="mx-1 py-1 text-sm text-black bg-white-500 rounded-md"
                                            >
                                            <EyeIcon class="h-6 w-6 text-white-500"/>
                                        </Link>
                                        <button v-if="order.status == 1"
                                            @click="changeStatus(order.id, 2)"
                                            tabIndex="-1"
                                            type="button"
                                            className="mx-1 px-2 py-1 text-sm text-white bg-blue-500 rounded-md col-span-2"
                                        >
                                            Aprobar
                                        </button>
                                        <button v-if="order.status == 2"
                                            @click="changeStatus(order.id, 3)"
                                            tabIndex="-1"
                                            type="button"
                                            className="mx-1 px-2 py-1 text-sm text-white bg-green-500 rounded-md col-span-2"
                                        >
                                            Completar
                                        </button>
                                        <button v-if="order.status < 3"
                                            @click="changeStatus(order.id, 5)"
                                            tabIndex="-1"
                                            type="button"
                                            className="mx-1 px-2 py-1 text-sm text-white bg-red-500 rounded-md col-span-2"
                                        >
                                            Cancelar
                                        </button>
                                        <button v-if="order.status == 3"
                                            type="button"
                                            className="mx-1 px-3 py-1 text-sm text-white bg-gray-500 rounded-md col-span-4"
                                            :disabled="true"
                                        >
                                            Finalizada
                                        </button>
                                        <button v-if="order.status > 3"
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
                                :data="orderData"
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
        changeStatus(order_id, status) {
            axios.put("/orders/" + order_id, {
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