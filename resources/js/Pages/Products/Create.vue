<script setup>
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated.vue";
import BreezeLabel from "@/Components/Label.vue";
import BreezeInput from "@/Components/Input.vue";
import BreezeTextArea from "@/Components/Textarea.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";

const form = useForm({
    name: "",
    description: "",
    type: "",
    tags: "",
    providers: "",
});
const submit = () => {
    form.post(route("products.store"));
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
            value: null,
            value2: null,
            options: [],
            tags: [],
            providers: []
        };
    },
    methods: {
        nameWithDescription({ name, description }) {
            return `${name} — [${description}]`;
        },
        getTypes() {
            axios.get("/api/types/all").then((response) => {
                this.options = response.data;
            });
        },
        getTags() {
            axios.get("/api/tags/all").then((response) => {
                this.tags = response.data;
            });
        },
        getProviders() {
            axios.get("/api/providers/all").then((response) => {
                this.providers = response.data;
            });
        },
    },
    created() {
        this.getTypes();
        this.getTags();
        this.getProviders();
    }
};
</script>
<template>
    <Head name="Dashboard" />
    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Crear Producto
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div className="flex items-center justify-between mb-6">
                            <Link
                                className="px-6 py-2 text-white bg-blue-500 rounded-md focus:outline-none"
                                :href="route('products.index')"
                            >
                                Volver
                            </Link>
                        </div>
                        <form name="createForm" @submit.prevent="submit">
                            <div
                                className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2"
                            >
                                <div className="mx-4 mb-4">
                                    <BreezeLabel
                                        for="name"
                                        value="Nombre del Producto"
                                    />
                                    <BreezeInput
                                        id="name"
                                        type="text"
                                        class="mt-1 block w-full"
                                        v-model="form.name"
                                        autofocus
                                    />
                                    <span
                                        className="text-red-600"
                                        v-if="form.errors.name"
                                    >
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
                                    <BreezeLabel
                                        for="description"
                                        value="Descripción"
                                    />
                                    <BreezeTextArea
                                        id="description"
                                        class="mt-1 block w-full"
                                        v-model="form.description"
                                        autofocus
                                    />
                                    <span
                                        className="text-red-600"
                                        v-if="form.errors.description"
                                    >
                                        {{ form.errors.description }}
                                    </span>
                                </div>
                                <div className="mx-4 mb-4">
                                    <BreezeLabel
                                        for="type"
                                        value="Categorias"
                                    />
                                    <multiselect
                                        v-model="form.tags"
                                        :options="tags"
                                        :multiple="true"
                                        :close-on-select="false"
                                        :clear-on-select="false"
                                        :preserve-search="true"
                                        placeholder="Pick some"
                                        label="description"
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
                                                v-if="values.length &amp;&amp; !isOpen"
                                                >{{ values.length }} options
                                                selected</span
                                            ></template
                                        >
                                    </multiselect>
                                    <span
                                        className="text-red-600"
                                        v-if="form.errors.tags"
                                    >
                                        {{ form.errors.tags }}
                                    </span>
                                </div>
                                <div className="mx-4 mb-4">
                                    <BreezeLabel
                                        for="providers"
                                        value="Proveedores"
                                    />
                                    <multiselect
                                        v-model="form.providers"
                                        :options="providers"
                                        :multiple="true"
                                        :close-on-select="false"
                                        :clear-on-select="false"
                                        :preserve-search="true"
                                        placeholder="Pick some"
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
                                    <span
                                        className="text-red-600"
                                        v-if="form.errors.providers"
                                    >
                                        {{ form.errors.providers }}
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
