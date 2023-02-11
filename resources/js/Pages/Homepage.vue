<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head} from '@inertiajs/inertia-vue3';
</script>

<template>
    <Head title="Home"/>

    <AuthenticatedLayout>
        <template #header>
            <h1>Home</h1>
        </template>
        <template #header-main>
            <div class="grid grid-cols-3 bg-white shadow-sm md:rounded-lg divide-x text-center overflow-hidden">
                <div class="p-4 border-b-2 border-green-500">Recent</div>
                <div class="p-4 border-b-2 border-b-transparent">Most liked</div>
                <div class="p-4 border-b-2 border-b-transparent">Most answer</div>
            </div>
        </template>

        <div class="text-gray-900 p-6">You're logged in!</div>
    </AuthenticatedLayout>
</template>
