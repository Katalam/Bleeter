<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, Link} from '@inertiajs/inertia-vue3';
import Post from "@/Pages/Post/Post.vue";
import WhoToFollow from "@/Components/WhoToFollow.vue";
import SortTimeline from "@/Components/SortTimeline.vue";
import LoadMore from "@/Components/LoadMore.vue";

defineProps({
    posts: {
        type: Array,
        required: true
    },
    users: {
        type: Array,
        required: true
    },
    maxPosts: {
        type: Number,
        required: true
    }
})
</script>

<template>
    <Head title="Home"/>

    <AuthenticatedLayout>
        <template #header>
            <h1>Home</h1>
        </template>
        <template #sidebar>
            <WhoToFollow :users="users"/>
        </template>

        <!-- If the user doesn't follow anyone, show a message -->
        <div v-if="maxPosts === 0" class="bg-white shadow-sm md:rounded-lg p-4 text-xl">
            You don't follow anyone yet. Check <Link :href="route('trending')" class="text-green-500 font-semibold">Trending</Link> to find people to follow.
        </div>

        <!-- If the user follows people, show the timeline -->
        <SortTimeline v-if="maxPosts > 0" />

        <div class="space-y-4">
            <Post :post="post" v-for="post in posts" :id="post.id"/>
        </div>

        <!-- If the user follows people, show the load more button -->
        <LoadMore :max-posts="maxPosts" v-if="maxPosts > 0" />
    </AuthenticatedLayout>
</template>
