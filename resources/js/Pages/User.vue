<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head} from '@inertiajs/inertia-vue3';
import Post from "@/Pages/Post/Post.vue";
import WhoToFollow from "@/Components/WhoToFollow.vue";
import SortTimeline from "@/Components/SortTimeline.vue";
import LoadMore from "@/Components/LoadMore.vue";

defineProps({
    user: {
        type: Object,
        required: true
    },
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
    },
})
</script>

<template>
    <Head :title="user.username"/>

    <AuthenticatedLayout>
        <template #header>
            <h1 v-text="user.name"/>
        </template>
        <template #sidebar>
            <WhoToFollow :users="users"/>
        </template>

        <div class="bg-white shadow-sm md:rounded-lg p-4 space-y-2">
            <p>Follower: {{ user.follows_count }}</p>
            <p>Following: {{ user.followers_count }}</p>
            <p>Joined: {{ user.created_at_human }}</p>
        </div>

        <div class="space-y-4">
            <Post :post="post" v-for="post in posts" :id="post.id"/>
        </div>

        <LoadMore :max-posts="maxPosts"/>
    </AuthenticatedLayout>
</template>
