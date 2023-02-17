<script setup>
import {Link} from "@inertiajs/inertia-vue3";
import {Inertia} from "@inertiajs/inertia";
import dayjs from "dayjs";
import relativeTime from 'dayjs/plugin/relativeTime';
import {onBeforeUnmount, ref} from "vue";

dayjs.extend(relativeTime);

const props = defineProps({
    post: {
        type: Object,
        required: true
    }
})

const createdAt = dayjs(props.post.created_at);
const createdAtReadable = ref(createdAt.fromNow());


// Start the interval at the second the post was created
// so that the time is more accurate than the updating every minute
let interval;
const date = new Date()
interval = setTimeout(() => {
    interval = setInterval(() => {
        createdAtReadable.value = createdAt.fromNow()
    }, 1000)
}, createdAt.second() * 1000)

onBeforeUnmount(() => {
    clearInterval(interval)
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

function answer() {
    Inertia.visit(route('posts.show', props.post.id))
}
</script>

<template>
    <div class="bg-white shadow-sm md:rounded-lg p-4 space-y-2">
        <div class="flex items-top justify-between">
            <Link :href="route('user-page', post.user.username)" class="text-sm text-gray-700 flex flex-col">
                <span class="font-semibold text-lg">{{ post.user.name }}</span>
                <span class="text-gray-500">{{ '@' + post.user.username }}</span>
            </Link>
            <p class="text-sm text-gray-500">{{ createdAtReadable }}</p>
        </div>
        <div v-if="post.public_url" class="flex w-full justify-center">
            <img :src="post.public_url" alt="" class="max-h-96 rounded-lg">
        </div>
        <p v-html="post.body_html"/>
        <div class="space-x-3">
            <button class="text-sm text-gray-500" @click="like()"
                    :class="{ 'font-semibold' : props.post.liked_by_current_user}">
                <span v-text="post.likes_count"></span>
                Likes
            </button>
            <button class="text-sm text-gray-500" @click="answer()" v-if="!post.parent_id">
                <span v-text="post.answers_count"></span>
                Answer
            </button>
        </div>
    </div>
</template>
