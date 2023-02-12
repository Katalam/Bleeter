<script setup>
import ResponsiveNavLink from "@/Components/ResponsiveNavLink.vue";
</script>

<template>
    <ResponsiveNavLink :href="route('home')" :active="route().current('home')">
        Home
    </ResponsiveNavLink>
    <ResponsiveNavLink :href="route('trending')" :active="route().current('trending')">
        Trending
    </ResponsiveNavLink>
</template>
