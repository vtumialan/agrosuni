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
            unit: 1,
            product: [],
            stores: [],
            origin_store: "",
            destination_store: "",
            products: [],
            productData: [],
        };
    },
    methods: {
        getStores() {
            axios.get("/api/stores/all").then((response) => {
                this.stores = response.data;
            });
        },
        getProducts() {
            axios.get("/api/products/all").then((response) => {
                this.products = response.data;
            });
        },
        add(product, unit) {
            if (product && unit > 0) {
                let exist = false;
                this.productData.forEach((element) => {
                    if (element.id == product.id) {
                        element.unit = parseInt(unit) + parseInt(element.unit);
                        exist = true;
                    }
                });
                if (!exist) {
                    this.productData.push({
                        id: product.id,
                        name: product.name,
                        unit: unit,
                    });
                }
                this.unit = 1;
                this.product = [];
            }
        },
        remove(id) {
            this.productData = this.productData.filter(function (item) {
                return item.id != id;
            });
        },
        formStore(e) {
            e.preventDefault();
            axios
                .post("/transfers", {
                    origin_store: this.origin_store,
                    destination_store: this.destination_store,
                    products: this.productData,
                })
                .then(function (response) {
                    if (response.data.status === "success") {
                        window.location.href = response.data.url;
                    }
                })
                .catch(function (error) {
                    console.log("error");
                    console.log(error);
                });
        },
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
                Crear Order de Transferencia
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div className="flex items-center justify-between mb-6">
                            <Link
                                className="px-6 py-2 text-white bg-blue-500 rounded-md focus:outline-none"
                                :href="route('transfers.index')"
                            >
                                Volver
                            </Link>
                        </div>
                        <form name="createForm" @submit="formStore">
                            <div
                                className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2"
                            >
                                <div className="mx-4 mb-4">
                                    <BreezeLabel for="store" value="Local de Origen" />
                                    <multiselect
                                        v-model="origin_store"
                                        :options="stores"
                                        placeholder="Select one"
                                        label="name"
                                        track-by="id"
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
                                <div className="mx-4 mb-4">
                                    <BreezeLabel for="store" value="Local de Destino" />
                                    <multiselect
                                        v-model="destination_store"
                                        :options="stores"
                                        placeholder="Select one"
                                        label="name"
                                        track-by="id"
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
                            </div>
                            <br />
                            <h3
                                class="font-semibold text-xl text-gray-800 leading-tight mb-4"
                            >
                                Lista de productos
                            </h3>
                            <div
                                className="ml-4 grid grid-cols-1 md:grid-cols-4 lg:grid-cols-4"
                            >
                                <div className="mx-4 mb-4">
                                    <BreezeLabel
                                        for="products"
                                        value="Producto"
                                    />
                                    <multiselect
                                        v-model="product"
                                        :options="products"
                                        placeholder="Select one"
                                        label="name"
                                        track-by="id"
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
                                <div className="mx-4 mb-4">
                                    <BreezeLabel for="unit" value="Cantidad" />
                                    <BreezeInput
                                        id="unit"
                                        type="number"
                                        class="mt-1 block w-full"
                                        v-model="unit"
                                        autofocus
                                        min="1"
                                    />
                                    <span className="text-red-600" v-if="false">
                                        {{ false }}
                                    </span>
                                </div>
                                <div className="mx-4 mb-4">
                                    <div>
                                        <button
                                            @click="add(product, unit)"
                                            tabIndex="-1"
                                            type="button"
                                            className="mx-1 px-3 py-1 text-sm text-white bg-green-500 rounded-md mt-6"
                                        >
                                            <PlusIcon
                                                class="h-6 w-6 text-white-500"
                                            />
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <table className="table-fixed w-full">
                                <thead>
                                    <tr className="bg-gray-100">
                                        <th className="px-4 py-2 w-14">No.</th>
                                        <th className="px-4 py-2">Producto</th>
                                        <th className="px-4 py-2">Cantidad</th>
                                        <th className="px-4 py-2 w-40">Opciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr
                                        v-for="product in productData"
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
                                        <td
                                            className="border px-4 py-2 text-center align-middle grid grid-cols-2"
                                        >
                                            <div>
                                                <button
                                                    @click="remove(product.id)"
                                                    tabIndex="-1"
                                                    type="button"
                                                    className="mx-1 px-3 py-1 text-sm text-white bg-red-500 rounded-md"
                                                >
                                                    <TrashIcon
                                                        class="h-6 w-6 text-white-500"
                                                    />
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
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
