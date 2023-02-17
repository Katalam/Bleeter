<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head} from '@inertiajs/inertia-vue3';
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
    },
    hashtag: {
        type: String,
        required: true
    }
})
</script>

<template>
    <Head :title="hashtag"/>

    <AuthenticatedLayout>
        <template #header>
            <h1 v-text="'#' + hashtag" />
        </template>
        <template #sidebar>
            <WhoToFollow :users="users"/>
        </template>

        <SortTimeline />

        <div class="space-y-4">
            <Post :post="post" v-for="post in posts" :id="post.id"/>
        </div>

        <LoadMore :max-posts="maxPosts" />
    </AuthenticatedLayout>
</template>
