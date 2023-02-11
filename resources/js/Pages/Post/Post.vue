<script setup>
defineProps({
    post: {
        type: Object,
        required: true
    }
})
</script>

<template>
    <div class="bg-white shadow-sm md:rounded-lg p-4">
        <div class="flex items-center justify-between">
            <p class="text-sm text-gray-500">{{ post.user.name }}</p>
            <p class="text-sm text-gray-500">{{ post.created_at_human }}</p>
        </div>
        <p>{{ post.body }}</p>
        <div>
            <button class="text-sm text-gray-500">
                <span v-text="post.likes_count"></span>
                Likes
            </button>
        </div>
    </div>
</template>
