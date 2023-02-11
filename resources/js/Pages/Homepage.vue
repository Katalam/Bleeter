<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head} from '@inertiajs/inertia-vue3';
import Post from "@/Pages/Post/Post.vue";
import {Inertia} from "@inertiajs/inertia";
import {ref} from "vue";

defineProps({
    posts: {
        type: Array,
        required: true
    },
    users: {
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
            l: limit,
        }
    })
    limit += 10;
}

function mostLiked() {
    sort = 'likes_count';
    Inertia.reload({
        preserveState: true,
        preserveScroll: true,
        only: ['posts'],
        replace: true,
        data: {
            l: limit,
            s: 'likes_count'
        }
    })
}

function mostRecent() {
    sort = 'created_at';
    Inertia.reload({
        preserveState: true,
        preserveScroll: true,
        only: ['posts'],
        replace: true,
        data: {
            l: limit,
            s: undefined,
        }
    })
}

let sort = 'created_at';
const follows = ref([])

function follow(user_id) {
    axios({
        method: 'post',
        url: '/follow',
        data: {
            user_id: user_id
        }
    }).then(() => {
        if (follows.value.includes(user_id)) {
            follows.value = follows.value.filter(id => id !== user_id)
        } else {
            follows.value.push(user_id)
        }
        if (follows.value.length === 3) {
            Inertia.reload({
                preserveState: true,
                preserveScroll: true,
                only: ['users'],
            });
            follows.value = []
        }
    });
}
</script>

<template>
    <Head title="Home"/>

    <AuthenticatedLayout>
        <template #header>
            <h1>Home</h1>
        </template>
        <template #sidebar>
            <div class="bg-white shadow-sm md:rounded-lg px-4 pt-4 hidden md:block">
                <h3 class="font-semibold text-xl">Who to follow</h3>
                <div class="divide-y">
                    <div class="py-4 flex justify-between" v-for="user in users" :id="user.id">
                        <div>
                            <div class="flex items-center">
                                <img src="" alt="" class="rounded-full">
                            </div>
                            <div>
                                <p v-text="user.name"></p>
                                <p v-text="'@' + user.username" class="text-neutral-600"></p>
                            </div>
                        </div>
                        <div class="flex items-center">
                            <button class="flex items-center rounded-full px-3 py-1"
                                    :class="follows.includes(user.id) ? 'bg-green-300 text-white' : 'bg-green-100 text-green-600'"
                                    @click="follow(user.id)">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                     v-show="!follows.includes(user.id)"
                                     stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                     v-show="follows.includes(user.id)"
                                     stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 12h-15"/>
                                </svg>
                                <span class="font-semibold" v-text="follows.includes(user.id) ? 'Unfollow' : 'Follow'"/>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </template>

        <div class="grid grid-cols-3 bg-white shadow-sm md:rounded-lg divide-x text-center overflow-hidden">
            <button class="p-4 border-b-2" @click="mostRecent()"
                    :class="sort === 'created_at' ? 'border-b-green-500' : 'border-b-transparent'">Recent
            </button>
            <button class="p-4 border-b-2" @click="mostLiked()"
                    :class="sort === 'likes_count' ? 'border-b-green-500' : 'border-b-transparent'">Most liked
            </button>
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
