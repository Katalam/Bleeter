<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head} from '@inertiajs/inertia-vue3';
import Post from "@/Pages/Post/Post.vue";
import WhoToFollow from "@/Components/WhoToFollow.vue";
import LoadMore from "@/Components/LoadMore.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import dayjs from "dayjs";
import relativeTime from 'dayjs/plugin/relativeTime';

dayjs.extend(relativeTime);

const props = defineProps({
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

function follow() {
    axios({
        'method': 'POST',
        'url': route('follow'),
        'data': {
            'user_id': props.user.id
        }
    }).then(response => {
        props.user.followed_by_current_user = response.data.followed
        if (response.data.followed) {
            props.user.followers_count++
        } else {
            props.user.followers_count--
        }
    });
}
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

        <div class="bg-white shadow-sm md:rounded-lg p-4 space-y-2 flex items-center justify-between w-full">
            <div>
                <p>Follower: {{ user.followers_count }}</p>
                <p>Follows: {{ user.follows_count }}</p>
                <p>Joined: {{ dayjs(user.created_at).fromNow() }}</p>
            </div>
            <div>
                <PrimaryButton v-if="user.id !== $page.props.auth.user.id" @click="follow"
                               v-text="user.followed_by_current_user ? 'Unfollow' : 'Follow'"/>
            </div>
        </div>

        <div class="space-y-4">
            <Post :post="post" v-for="post in posts" :key="post.id"/>
        </div>

        <LoadMore :max-posts="maxPosts"/>
    </AuthenticatedLayout>
</template>
