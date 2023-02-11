<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head} from '@inertiajs/inertia-vue3';
import Post from "@/Pages/Post/Post.vue";
import {Inertia} from "@inertiajs/inertia";

defineProps({
    posts: {
        type: Array,
        required: true
    }
})

let limit = 30;

function loadMore() {
    Inertia.reload({
        preserveState: true,
        preserveScroll: true,
        only: ['posts'],
        data: {
            l: limit
        }
    })
    limit += 10;
}
</script>

<template>
    <Head title="Home"/>

    <AuthenticatedLayout>
        <template #header>
            <h1>Home</h1>
        </template>
        <template #sidebar>
        </template>

        <div class="grid grid-cols-3 bg-white shadow-sm md:rounded-lg divide-x text-center overflow-hidden">
            <div class="p-4 border-b-2 border-green-500">Recent</div>
            <div class="p-4 border-b-2 border-b-transparent">Most liked</div>
            <div class="p-4 border-b-2 border-b-transparent">Most answer</div>
        </div>

        <div class="space-y-4">
            <Post :post="post" v-for="post in posts" :id="post.id"/>
        </div>

        <div class="flex items-center justify-center text-neutral-400">
            <button class=" hover:underline select-none" @click="loadMore()">
                Load more...
            </button>
        </div>
    </AuthenticatedLayout>
</template>
