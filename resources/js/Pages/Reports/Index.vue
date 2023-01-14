<script setup>
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated.vue";
import BreezeLabel from "@/Components/Label.vue";
import BreezeInput from "@/Components/Input.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
</script>

<script>
import Multiselect from "vue-multiselect";

export default {
    components: {
        Multiselect,
    },
    data() {
        return {
            products_costs: [],
            providers_costs: [],
            providers_products: [],
            stores_products: [],
            orders_products: [],
        };
    },
    methods: {
        getReports() {
            axios.get("/api/reports").then((response) => {
                this.products_costs = response.data.productsCosts;
                this.providers_costs = response.data.providersCosts;
                this.providers_products = response.data.providersProducts;
                this.stores_products = response.data.storeProducts;
                this.orders_products = response.data.ordersProducts;
            });
        },
        getMonth(month) {
            let month_text = '';
            switch (month) {
                case 1:
                    month_text = 'Enero'
                    break;
                case 2:
                    month_text = 'Febrero'
                    break;
                case 3:
                    month_text = 'Marzo'
                    break;
                case 4:
                    month_text = 'Abril'
                    break;
                case 5:
                    month_text = 'Mayo'
                    break;
                case 6:
                    month_text = 'Junio'
                    break;
                case 7:
                    month_text = 'Julio'
                    break;
                case 8:
                    month_text = 'Agosto'
                    break;
                case 9:
                    month_text = 'Septiembre'
                    break;
                case 10:
                    month_text = 'Octubre'
                    break;
                case 11:
                    month_text = 'Noviembre'
                    break;
                case 12:
                    month_text = 'Diciembre'
                    break;
                default:
                    month_text = ' - '
                    break;
            };
            return month_text;
        },
        getNumberMonth(month) {
            if (month < 10 ) {
                return '0' + String(month);
            } else {
                return String(month);

            }
        },
    },
    created() {
        this.getReports();
    },
};
</script>
<template>
    <Head name="Dashboard" />
    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Reportes
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div
                            className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2"
                        >
                            <div className="mx-4 mb-4">
                                <h3
                                    class="font-semibold text-xl text-gray-800 leading-tight mb-4"
                                >
                                    Cantidad de productos adquiridos por periodo
                                </h3>
                                <table className="table-fixed w-full">
                                    <thead>
                                        <tr className="bg-gray-100">
                                            <th className="px-4 py-2 w-16">No.</th>
                                            <th className="px-4 py-2">Producto</th>
                                            <th className="px-4 py-2 w-24">Periodo</th>
                                            <th className="px-4 py-2 w-32">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr
                                            v-for="product in orders_products"
                                            :key="product.id"
                                        >
                                            <td className="border px-4 py-2 text-center">
                                                {{ product.id }}
                                            </td>
                                            <td className="border px-4 py-2 text-center">
                                                {{ product.name }}
                                            </td>
                                            <td className="border px-4 py-2">
                                                {{ product.year }}{{ this.getNumberMonth(product.month) }}
                                            </td>
                                            <td className="border px-4 py-2 text-center">
                                                {{ product.sum }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div className="mx-4 mb-4">
                                <h3
                                    class="font-semibold text-xl text-gray-800 leading-tight mb-4"
                                >
                                    Costo de productos adquiridos por periodo
                                </h3>
                                <table className="table-fixed w-full">
                                    <thead>
                                        <tr className="bg-gray-100">
                                            <th className="px-4 py-2 w-16">No.</th>
                                            <th className="px-4 py-2">Producto</th>
                                            <th className="px-4 py-2 w-24">Periodo</th>
                                            <th className="px-4 py-2 w-32">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr
                                            v-for="product in products_costs"
                                            :key="product.id"
                                        >
                                            <td className="border px-4 py-2 text-center">
                                                {{ product.id }}
                                            </td>
                                            <td className="border px-4 py-2 text-center">
                                                {{ product.name }}
                                            </td>
                                            <td className="border px-4 py-2">
                                                {{ product.year }}{{ this.getNumberMonth(product.month) }}
                                            </td>
                                            <td className="border px-4 py-2 text-center">
                                                S/. {{ parseFloat(product.total).toFixed(2) }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div className="mx-4 mb-4 col-span-2" style="margin-top: 20px;">
                                <h3
                                    class="font-semibold text-xl text-gray-800 leading-tight mb-4"
                                >
                                    Cantidad de productos adquiridos por proveedor
                                </h3>
                                <table className="table-fixed w-full">
                                    <thead>
                                        <tr className="bg-gray-100">
                                            <th className="px-4 py-2 w-16">No.</th>
                                            <th className="px-4 py-2">Proveedor</th>
                                            <th className="px-4 py-2">Producto</th>
                                            <th className="px-4 py-2 w-24">Periodo</th>
                                            <th className="px-4 py-2 w-20">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr
                                            v-for="provider in providers_products"
                                            :key="provider.id"
                                        >
                                            <td className="border px-4 py-2 text-center">
                                                {{ provider.id }}
                                            </td>
                                            <td className="border px-4 py-2">
                                                {{ provider.name }}
                                            </td>
                                            <td className="border px-4 py-2">
                                                {{ provider.product_name }}
                                            </td>
                                            <td className="border px-4 py-2 text-center">
                                                {{ provider.year }}{{ this.getNumberMonth(provider.month) }}
                                            </td>
                                            <td className="border px-4 py-2 text-center">
                                                {{ provider.sum }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div className="mx-4 mb-4" style="margin-top: 20px;">
                                <h3
                                    class="font-semibold text-xl text-gray-800 leading-tight mb-4"
                                >
                                    Unidades disponibles por Local
                                </h3>
                                <table className="table-fixed w-full">
                                    <thead>
                                        <tr className="bg-gray-100">
                                            <th className="px-4 py-2 w-16">No.</th>
                                            <th className="px-4 py-2">Local</th>
                                            <th className="px-4 py-2">Producto</th>
                                            <th className="px-4 py-2 w-20">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr
                                            v-for="store in stores_products"
                                            :key="store.id"
                                        >
                                            <td className="border px-4 py-2 text-center">
                                                {{ store.id }}
                                            </td>
                                            <td className="border px-4 py-2">
                                                {{ store.name }}
                                            </td>
                                            <td className="border px-4 py-2">
                                                {{ store.product_name }}
                                            </td>
                                            <td className="border px-4 py-2 text-center">
                                                {{ store.total }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div className="mx-4 mb-4" style="margin-top: 20px;">
                                <h3
                                    class="font-semibold text-xl text-gray-800 leading-tight mb-4"
                                >
                                    Costo de Proveedor por periodo
                                </h3>
                                <table className="table-fixed w-full">
                                    <thead>
                                        <tr className="bg-gray-100">
                                            <th className="px-4 py-2 w-16">No.</th>
                                            <th className="px-4 py-2">Producto</th>
                                            <th className="px-4 py-2 w-24">Periodo</th>
                                            <th className="px-4 py-2 w-32">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr
                                            v-for="provider in providers_costs"
                                            :key="provider.id"
                                        >
                                            <td className="border px-4 py-2 text-center">
                                                {{ provider.id }}
                                            </td>
                                            <td className="border px-4 py-2 text-center">
                                                {{ provider.name }}
                                            </td>
                                            <td className="border px-4 py-2">
                                                {{ provider.year }}{{ this.getNumberMonth(provider.month) }}
                                            </td>
                                            <td className="border px-4 py-2 text-center">
                                                S/. {{ parseFloat(provider.total).toFixed(2) }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>
<style src="vue-multiselect/dist/vue-multiselect.css"></style>
