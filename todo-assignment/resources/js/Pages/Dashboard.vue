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
                    <div class="p-6 text-gray-900">You're logged in!!!</div>

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

                    <div class="p-6 text-gray-900">{{ $page.props.user }}</div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
