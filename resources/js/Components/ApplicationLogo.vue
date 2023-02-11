<script setup>
import {Link} from '@inertiajs/inertia-vue3'
</script>
<template>
    <Link :href="route('home')">
        <span class="font-bold text-3xl tracking-widest uppercase text-green-500">Bleeter</span>
    </Link>
</template>
