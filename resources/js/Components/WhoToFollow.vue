<script setup>
import {ref} from "vue";
import {Inertia} from "@inertiajs/inertia";
import {Link} from "@inertiajs/inertia-vue3";

const props = defineProps({
    users: {
        type: Array,
        required: true
    }
})

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
    <div class="bg-white shadow-sm md:rounded-lg px-4 pt-4 hidden lg:block">
        <h3 class="font-semibold text-xl">Who to follow</h3>
        <div class="divide-y">
            <div class="py-4 flex justify-between" v-for="user in users" :id="user.id">
                <Link :href="route('user-page', user.username)">
                    <div class="flex items-center">
                        <img src="" alt="" class="rounded-full">
                    </div>
                    <div>
                        <p v-text="user.name"></p>
                        <p v-text="'@' + user.username" class="text-neutral-600"></p>
                    </div>
                </Link>
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
