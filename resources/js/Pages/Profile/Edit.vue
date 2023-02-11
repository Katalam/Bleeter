<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DeleteUserForm from './Partials/DeleteUserForm.vue';
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';
import {Head} from '@inertiajs/inertia-vue3';

defineProps({
    mustVerifyEmail: Boolean,
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

        <div class="py-12 w-full">
            <div class="sm:px-6 lg:px-8 space-y-8 divide-y">
                <UpdateProfileInformationForm
                    :must-verify-email="mustVerifyEmail"
                    :status="status"
                />

                <div class="pt-4">
                    <UpdatePasswordForm/>
                </div>

                <div class="pt-4">
                    <DeleteUserForm/>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
