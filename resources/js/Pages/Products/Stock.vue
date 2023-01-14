<script setup>
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated.vue";
import BreezeLabel from "@/Components/Label.vue";
import BreezeInput from "@/Components/Input.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import { PlusIcon, TrashIcon } from "@heroicons/vue/24/solid";
</script>

<script>
import Multiselect from "vue-multiselect";

export default {
    components: {
        Multiselect,
    },
    data() {
        return {
            stores: [],
            store: [{ 'id': 'all', 'name': 'Todos los locales'}],
            products: [],
        };
    },
    methods: {
        getStores() {
            axios.get("/api/stores/all").then((response) => {
                const list = [{ 'id': 'all', 'name': 'Todos los locales'}];
                this.stores = list.concat(response.data);
            });
        },
        getProducts(store = 'all') {
            axios.get("/api/products/stock/" + store).then((response) => {
                this.products = response.data;
            });
        },
        onChange(store) {
            this.getProducts(store.id);
        }
    },
    created() {
        this.getStores();
        this.getProducts();
    },
};
</script>
<template>
    <Head name="Dashboard" />
    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Crear Order de Compra
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
                            className="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-3"
                        >
                            <div className="mx-4 mb-4">
                                <BreezeLabel for="store" value="Local" />
                                <multiselect
                                    v-model="store"
                                    :options="stores"
                                    placeholder="Todos los locales"
                                    label="name"
                                    track-by="id"
                                    @select="onChange"
                                >
                                    <template
                                        slot="selection"
                                        slot-scope="{
                                            values,
                                            search,
                                            isOpen,
                                        }"
                                        ><span
                                            class="multiselect__single"
                                            v-if="values.length && !isOpen"
                                            >{{ values.length }} options
                                            selected</span
                                        ></template
                                    >
                                </multiselect>
                                <span className="text-red-600" v-if="false">
                                    {{ false }}
                                </span>
                            </div>
                            <table className="mt-4 col-span-2 table-fixed w-full">
                                <thead>
                                    <tr className="bg-gray-100">
                                        <th className="px-4 py-2 w-14">No.</th>
                                        <th className="px-4 py-2">Producto</th>
                                        <th className="px-4 py-2">Unidades</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr
                                        v-for="product in products"
                                        :key="product.id"
                                    >
                                        <td className="border px-4 py-2">
                                            {{ product.id }}
                                        </td>
                                        <td className="border px-4 py-2">
                                            {{ product.name }}
                                        </td>
                                        <td className="border px-4 py-2">
                                            {{ product.unit }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>
<style src="vue-multiselect/dist/vue-multiselect.css"></style>
