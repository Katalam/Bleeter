<script setup>
import {Link} from "@inertiajs/inertia-vue3";

const props = defineProps({
    post: {
        type: Object,
        required: true
    }
})

function like() {
    axios({
        'method': 'POST',
        'url': route('like'),
        'data': {
            'post_id': props.post.id
        }
    }).then(response => {
        props.post.liked_by_current_user = response.data.liked
        if (response.data.liked) {
            props.post.likes_count++
        } else {
            props.post.likes_count--
        }
    });
}
</script>

<template>
    <div class="bg-white shadow-sm md:rounded-lg p-4 space-y-2">
        <div class="flex items-top justify-between">
            <Link :href="route('user-page', post.user.username)" class="text-sm text-gray-700 flex flex-col">
                <span class="font-semibold text-lg">{{ post.user.name }}</span>
                <span class="text-gray-500">{{ '@' + post.user.username }}</span>
            </Link>
            <p class="text-sm text-gray-500">{{ post.created_at_human }}</p>
        </div>
        <p v-html="post.body_html" />
        <div>
            <button class="text-sm text-gray-500" @click="like()" :class="{ 'font-semibold' : props.post.liked_by_current_user}">
                <span v-text="post.likes_count"></span>
                Likes
            </button>
        </div>
    </div>
</template>
