<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DeleteUserForm from './Partials/DeleteUserForm.vue';
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';
import {Head} from '@inertiajs/inertia-vue3';

defineProps({
    status: String,
});
</script>

<template>
    <Head title="Profile"/>

    <AuthenticatedLayout>
        <template #header>
            <h1>Profile</h1>
        </template>
        <template #sidebar>
        </template>

        <div class="w-full">
            <div class="sm:px-6 lg:px-8 space-y-8 divide-y">
                <div class="p-4 bg-white shadow-sm md:rounded-lg">
                    <UpdateProfileInformationForm
                        :status="status"
                    />
                </div>

                <div class="p-4 bg-white shadow-sm md:rounded-lg">
                    <UpdatePasswordForm/>
                </div>

                <div class="p-4 bg-white shadow-sm md:rounded-lg">
                    <DeleteUserForm/>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
