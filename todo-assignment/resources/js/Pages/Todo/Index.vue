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
                            <h2 class="text-lg font-medium text-gray-900">Todo Information</h2>
                            <p class="mt-1 text-sm text-gray-600"> Below is a list of your todos. Click on the TODOS to view task lists under them</p>
                            <p class="mt-1 text-sm text-gray-600"> Please NOTE: your profile only allows you the following permissions </p>

                                <div><button type="button" class="inline-flex px-4" v-if="$page.props.user.permissions.includes('read tasks')">Read task</button></div>
                                <div><button type="button" class="inline-flex px-4" v-if="$page.props.user.permissions.includes('create tasks')">Write task</button></div>
                                <div><button type="button" class="inline-flex px-4" v-if="$page.props.user.permissions.includes('edit tasks')">Edit task</button></div>
                                <div><button type="button" class="inline-flex px-4" v-if="$page.props.user.permissions.includes('delete tasks')">Delete task</button></div>

                                <div>

                                </div>

                                <div>
                                </div>
                        </header>
                        <div class="mt-6 space-y-6">
                            <ul>
                                <li v-for="todo in todos" :key="todo.id" class="mt-1 space-y-6">
                                <a :href="'/todos/'+todo.id" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-300 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    {{ todo.title }}
                                </a>
                                </li>
                            </ul>
                        </div>


                        <a :href="'/todos/create'" class="inline-flex mt-6 items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Add New PARENT TASK
                        </a>




                    </section>
                </div>
            </div>
        </div>

    </AuthenticatedLayout>
</template>

<script>
  export default {
    props: {
      todos: Array, // Passed from the controller
    },
  };
  </script>
