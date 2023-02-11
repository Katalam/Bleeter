<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/inertia-vue3';

const props = defineProps({
    href: {
        type: String,
        required: true,
    },
    active: {
        type: Boolean,
        required: true,
    },
    as: {
        type: String,
        default: 'a',
    },
    method: {
        type: String,
        default: 'get',
    }
})

const classes = computed(() =>
    props.active
        ? 'text-neutral-700 tracking-wider flex space-x-4 p-2 rounded-lg bg-white/60 font-semibold'
        : 'text-neutral-700 tracking-wider flex space-x-4 p-2 rounded-lg'
);
</script>

<template>
    <Link :href="href" :class="classes" :as="as" :method="method">
        <slot />
    </Link>
</template>
