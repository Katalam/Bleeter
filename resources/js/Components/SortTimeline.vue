<script setup>
import {Inertia} from "@inertiajs/inertia";
import {ref} from "vue";

function mostLiked() {
    sort.value = 'likes_count';
    Inertia.reload({
        preserveState: true,
        preserveScroll: true,
        only: ['posts'],
        replace: true,
        data: {
            s: 'likes_count'
        }
    })
}

function mostRecent() {
    sort.value = 'created_at';
    Inertia.reload({
        preserveState: true,
        preserveScroll: true,
        only: ['posts'],
        replace: true,
        data: {
            s: undefined,
        }
    })
}

const sort = ref('created_at');
</script>

<template>
    <div class="grid grid-cols-3 bg-white shadow-sm md:rounded-lg divide-x text-center overflow-hidden">
        <button class="p-4 border-b-2" @click="mostRecent()"
                :class="sort === 'created_at' ? 'border-b-green-500' : 'border-b-transparent'">Recent
        </button>
        <button class="p-4 border-b-2" @click="mostLiked()"
                :class="sort === 'likes_count' ? 'border-b-green-500' : 'border-b-transparent'">Most liked
        </button>
        <div class="p-4 border-b-2 border-b-transparent">Most answer</div>
    </div>
</template>
