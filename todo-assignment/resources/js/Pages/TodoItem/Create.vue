<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head } from '@inertiajs/vue3';
import TodoLists from '@/Components/TodoLists.vue';

// const user = page.props.auth.user;

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
                            <h2 class="text-lg font-medium text-gray-900">Todo Item</h2>
                            <p class="mt-1 text-sm text-gray-600"> Below a section to enter your todo item title. </p>
                        </header>
                        <div class="mt-6 space-y-6">

                           <!-- XXX {{ todo.title }} -->

                           <!-- {{ auth }} -->

                            <form @submit.prevent="submitForm" class="mt-6 space-y-6">

                                <div>
                                    <InputLabel for="title" value="Parent Task Title" />

                                    <TextInput
                                        type="text"
                                        class="mt-1 block w-full"
                                        v-model="parentTitle"
                                        required
                                        autofocus
                                        autocomplete="title"
                                        disabled="disabled"
                                    />

                                </div>

                                <div>
                                    <InputLabel for="content" value="Task Description" />

                                    <TextInput
                                        type="text"
                                        class="mt-1 block w-full"
                                        v-model="formData.content"
                                        required
                                        autofocus
                                        autocomplete="content"
                                    />
                                </div>
                                <div class="flex items-center gap-4">
                                    <PrimaryButton> Create </PrimaryButton>

                                    <Transition
                                        enter-active-class="transition ease-in-out"
                                        enter-from-class="opacity-0"
                                        leave-active-class="transition ease-in-out"
                                        leave-to-class="opacity-0"
                                    >
                                    </Transition>
                                </div>
                            </form>

                            <!-- <p>ID: {{ $page.props.todo.id }} | Title: {{ $page.props.todo.title }}</p> -->

                            <!-- <p>{{ $page.props.auth.user }}</p> -->

                        </div>
                    </section>
                </div>
            </div>
        </div>

    </AuthenticatedLayout>
</template>

  <script>
  export default {
    props: ['todo', 'auth'], // Declare props that you expect to receive
    data() {
      return {
        formData: {
          content: '', // Set up a reactive form data
          todo_id: this.todo ? String(this.todo.id) : '', // Convert todo.id to string, default to empty string if todo is not provided
        },
        todoId: this.todo ? String(this.todo.id) : '', // Convert todo.id to string, default to empty string if todo is not provided
        parentTitle: this.todo ? String(this.todo.title) : '',
        routeParamsId: null // Initialize routeParamsId as null
      };
    },

    // mounted() {
    //     // Set routeParamsId after component is mounted
    //     this.routeParamsId = this.$route.params.id;
    // },

    methods: {
      async submitForm() {
        console.log(this.todo.id);
        const response = await this.$inertia.post(`/todos/${this.todo.id}/items`, this.formData); // @TODO: Need to fix this
        // const response = await this.$inertia.post('/todos/' + this.$route.params.id + '/items', this.formData); // Send a POST request to create a todo item
        if (response.ok) {
          this.$inertia.visit(response.headers.location); // Redirect back to the todo details page
        }
      },
    },
  };
  </script>
