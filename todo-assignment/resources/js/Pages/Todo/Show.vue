<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Todos Dashboard</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <section class="max-w-xl">
                        <header>
                            <h2 class="text-lg font-medium text-gray-900">Todo Display Information</h2>
                            <!-- <p class="mt-1 text-sm text-gray-600"> Below is a list of your todos. </p> -->
                        </header>
                        <div class="mt-6 space-y-6">
                            <h1>{{ todo.title }}</h1>
                            <ul>
                                <li v-for="item in todo.items" :key="item.id">
                                {{ item.title }}

                                <a :href="'/todo-items/'+item.id+'/edit'" class="inline-flex mt-1 items-center px-2 py-2 bg-gray-500 border border-transparent rounded-md font-semibold text-xs text-black uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    Edit
                                </a>
                                &nbsp;
                                <!-- <a :href="'/todo-items/'+item" class="inline-flex items-center px-2 py-2 bg-gray-500 border border-transparent rounded-md font-semibold text-xs text-black uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    Delete
                                </a> -->

                                </li>
                            </ul>
                            <!-- <router-link :to="'/todos/' + todo.id + '/items/create'">Add New Child Item</router-link> -->

                            <a :href="addItemUrl" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Append New Child Item
                            </a>


                        </div>
                    </section>
                </div>
            </div>
        </div>

    </AuthenticatedLayout>
</template>


  <script>
  export default {
    props: ['todo'],
    // methods: {
    //     addItem() {
    //         const addItemUrl = `/todos/${this.todo.id}/items/create`;
    //         this.$router.push(addItemUrl);
    //     }
    // }
    computed: {
        addItemUrl() {
        return `/todos/${this.todo.id}/items/create`;
        }
    }
  };
  </script>
