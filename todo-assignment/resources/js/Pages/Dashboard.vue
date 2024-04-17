<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                    <div class="p-6 text-gray-900">

                        <div v-if="$page.props.user.permissions.includes('read tasks')">
                            <button type="button">Read task</button>
                        </div>

                        <div v-if="$page.props.user.permissions.includes('create tasks')">
                            <button type="button">Write task</button>
                        </div>

                        <div v-if="$page.props.user.permissions.includes('edit tasks')">
                            <button type="button">Edit task</button>

                        </div>

                        <div v-if="$page.props.user.permissions.includes('delete tasks')">
                            <button type="button">Delete task</button>
                        </div>

                    </div>

                    <div class="p-6 text-gray-900">
                        <h2></h2>
                        <section class="min-w-xl">
                        <header>
                            <h2 class="text-lg font-medium text-gray-900">Quick Links</h2>
                            <p class="mt-1 text-sm text-gray-600"> Below is a list of links that will help you jump start the navigation through the system. </p>
                            <div><a :href="'/todos/'"  class="mt-1 text-lg text-red-700"> Route::get('/todos', [TodoController::class, 'index'])->name('todos.index'); </a></div>
                            <div><a :href="'/todos/create'"  class="mt-1 text-lg text-red-700"> Route::get('/todos/create', [TodoController::class, 'create'])->name('todos.create');</a></div>
                        </header>
                        <div class="mt-6 space-y-6">
                        </div>
                        </section>

                    </div>

                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
