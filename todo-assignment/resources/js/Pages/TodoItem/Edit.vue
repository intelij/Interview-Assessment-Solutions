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
                            <h2 class="text-lg font-medium text-gray-900">Edit Todo Child Element</h2>
                            <p class="mt-1 text-sm text-gray-600"> Below a section to enter the child element. </p>
                        </header>
                        <div class="mt-6 space-y-6">

                            <form @submit.prevent="submitForm" class="mt-6 space-y-6">
                                <div>
                                    <InputLabel for="content" value="Sub Task" />

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
    props: {
      item: Object, // Passed from the controller
    },
    data() {
      return {
        formData: {
          content: this.item.title, // Initialize form data with todo item content
        },
      };
    },
    methods: {
      async submitForm() {
        const response = await this.$inertia.put('/todo-items/' + this.item.id, this.formData); // Send a PUT request to update the todo item
        if (response.ok) {
          this.$inertia.visit(response.headers.location); // Redirect back to the todo details page
        }
      },
    },
  };
  </script>
