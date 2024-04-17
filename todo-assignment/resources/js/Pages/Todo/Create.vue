<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
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
                            <h2 class="text-lg font-medium text-gray-900">Todo Parent Item</h2>
                            <p class="mt-1 text-sm text-gray-600"> Below a section to enter your parent todo item title. </p>
                        </header>
                        <div class="mt-6 space-y-6">

                            <form @submit.prevent="submitForm" class="mt-6 space-y-6">
                                <div>
                                    <InputLabel for="title" value="Title" />

                                    <TextInput
                                        type="text"
                                        class="mt-1 block w-full"
                                        v-model="formData.title"
                                        required
                                        autofocus
                                        autocomplete="title"
                                    />
                                </div>
                                <div class="flex items-center gap-4">
                                    <PrimaryButton>Save</PrimaryButton>

                                    <Transition
                                        enter-active-class="transition ease-in-out"
                                        enter-from-class="opacity-0"
                                        leave-active-class="transition ease-in-out"
                                        leave-to-class="opacity-0"
                                    >
                                    </Transition>
                                </div>
                            </form>





                        </div>
                    </section>
                </div>
            </div>
        </div>

    </AuthenticatedLayout>
</template>

  <script>
  export default {
    data() {
      return {
        formData: {
          title: '', // Set up a reactive form data
        },
      };
    },
    methods: {
      async submitForm() {
        const response = await this.$inertia.post('/todos', this.formData); // Send a POST request to the server
        if (response.ok) {
          this.$inertia.visit(response.headers.location); // Redirect to the newly created todo
        }
      },
    },
  };
  </script>

