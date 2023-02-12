<script setup>
import {Inertia} from "@inertiajs/inertia";

let limit = (new URLSearchParams(document.location.search)).get('l');
if (limit !== null) {
    limit = parseInt(limit);
} else {
    limit = 10;
}

const props = defineProps({
    maxPosts: {
        type: Number,
        default: 0,
    }
})

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

function showLoadMore() {
    return (props.maxPosts === 0) || limit < props.maxPosts;
}
</script>

<template>
    <div class="flex items-center justify-center text-neutral-400" v-show="showLoadMore()">
        <button class=" hover:underline select-none" @click="loadMore()">
            Load more...
        </button>
    </div>
</template>
