<script setup>
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated.vue";
import BreezeLabel from "@/Components/Label.vue";
import BreezeInput from "@/Components/Input.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import { PlusIcon, TrashIcon } from "@heroicons/vue/24/solid";

const props = defineProps({
    order: Object,
    products: Object
});
</script>

<script>
import Multiselect from "vue-multiselect";

export default {
    components: {
        Multiselect,
    },
};
</script>
<template>
    <Head name="Dashboard" />
    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Detalle de Order de Compra
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div className="flex items-center justify-between mb-6">
                            <Link
                                className="px-6 py-2 text-white bg-blue-500 rounded-md focus:outline-none"
                                :href="route('orders.index')"
                            >
                                Volver
                            </Link>
                        </div>
                        <div
                            className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2"
                        >
                            <div className="mx-4 mb-4">
                                <BreezeLabel for="props.order.provider.name" value="Proveedor" />
                                <BreezeInput
                                    id="provider"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="props.order.provider.name"
                                    autofocus
                                    min="0"
                                    disabled="true"
                                />
                            </div>
                            <div className="mx-4 mb-4">
                                <BreezeLabel for="props.order.store.name" value="Local" />
                                <BreezeInput
                                    id="store"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="props.order.store.name"
                                    autofocus
                                    min="0"
                                    disabled="true"
                                />
                            </div>
                            <div className="mx-4 mb-4">
                                <BreezeLabel for="props.order.user.name" value="Solicitado por" />
                                <BreezeInput
                                    id="store"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="props.order.user.name"
                                    autofocus
                                    min="0"
                                    disabled="true"
                                />
                            </div>
                            <div className="mx-4 mb-4">
                                <BreezeLabel for="props.order.date" value="Fecha" />
                                <BreezeInput
                                    id="store"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="props.order.date"
                                    autofocus
                                    min="0"
                                    disabled="true"
                                />
                            </div>
                        </div>
                        <br />
                        <h3
                            class="font-semibold text-xl text-gray-800 leading-tight mb-4"
                        >
                            Lista de productos
                        </h3>
                        <table className="table-fixed w-full">
                            <thead>
                                <tr className="bg-gray-100">
                                    <th className="px-4 py-2 w-14">No.</th>
                                    <th className="px-4 py-2">Producto</th>
                                    <th className="px-4 py-2 w-28">Precio</th>
                                    <th className="px-4 py-2 w-28">Cantidad</th>
                                    <th className="px-4 py-2 w-32">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="product in props.products"
                                    :key="product.id"
                                >
                                    <td className="border px-4 py-2">
                                        {{ product.id }}
                                    </td>
                                    <td className="border px-4 py-2">
                                        {{ product.name }}
                                    </td>
                                    <td className="border px-4 py-2 text-center">
                                        S/. {{ parseFloat(product.price).toFixed(2) }}
                                    </td>
                                    <td className="border px-4 py-2 text-center">
                                        {{ product.unid }}
                                    </td>
                                    <td className="border px-4 py-2 text-center">
                                        S/. {{ parseFloat(product.unid * product.price).toFixed(2) }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>
<style src="vue-multiselect/dist/vue-multiselect.css"></style>
