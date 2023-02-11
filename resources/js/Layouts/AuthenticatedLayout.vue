<script setup>
import {nextTick, ref} from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import Navigation from "@/Components/Navigation.vue";
import NavigationResponsive from "@/Components/NavigationResponsive.vue";
import NewPost from "@/Components/NewPost.vue";

const showingNavigationDropdown = ref(false);
</script>

<template>
    <div>
        <div class="min-h-screen bg-gray-100">
            <nav class="bg-white border-b border-gray-100">
                <!-- Primary Navigation Menu -->
                <div class="max-w-screen-2xl mx-auto px-4 md:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex">
                            <!-- Logo -->
                            <div class="shrink-0 flex items-center">
                                <ApplicationLogo/>
                            </div>
                        </div>

                        <div class="hidden md:flex md:items-center md:ml-6 space-x-12">
                            <div class="space-y-1">
                                <p class="text-sm leading-4 font-medium text-gray-500">
                                    {{ $page.props.auth.user.name }}
                                </p>
                                <p class="text-sm leading-3 font-medium text-gray-400">
                                    {{ '@' + $page.props.auth.user.username }}
                                </p>
                            </div>
                            <NewPost/>
                        </div>

                        <!-- Hamburger -->
                        <div class="-mr-2 flex items-center md:hidden">
                            <button
                                @click="showingNavigationDropdown = !showingNavigationDropdown"
                                class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out"
                            >
                                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path
                                        :class="{
                                            hidden: showingNavigationDropdown,
                                            'inline-flex': !showingNavigationDropdown,
                                        }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M4 6h16M4 12h16M4 18h16"
                                    />
                                    <path
                                        :class="{
                                            hidden: !showingNavigationDropdown,
                                            'inline-flex': showingNavigationDropdown,
                                        }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"
                                    />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Responsive Navigation Menu -->
                <div
                    :class="{ block: showingNavigationDropdown, hidden: !showingNavigationDropdown }"
                    class="md:hidden"
                >
                    <div class="pt-2 pb-3 space-y-1">
                        <NavigationResponsive/>
                    </div>

                    <!-- Responsive Settings Options -->
                    <div class="pt-4 pb-1 border-t border-gray-200">
                        <div class="px-4">
                            <div class="font-medium text-base text-gray-800">
                                {{ $page.props.auth.user.name }}
                            </div>
                            <div class="font-medium text-sm text-gray-500">{{ $page.props.auth.user.email }}</div>
                        </div>

                        <div class="mt-3 space-y-1">
                            <ResponsiveNavLink :href="route('profile.edit')">Profile</ResponsiveNavLink>
                            <ResponsiveNavLink :href="route('logout')" method="post" as="button">
                                Log Out
                            </ResponsiveNavLink>
                        </div>
                    </div>
                </div>
            </nav>


            <!-- Page Content -->
            <main class="w-full flex justify-center">
                <div class="max-w-screen-2xl w-full md:px-6 lg:px-8">
                    <!-- Page Heading -->
                    <header v-if="$slots.header" class="md:pl-0 pl-2 pt-12 tracking-wider font-bold text-3xl">
                        <slot name="header"/>
                    </header>
                    <div class="flex gap-10 py-12 w-full">
                        <nav class="hidden md:block w-1/6 space-y-4">
                            <Navigation/>
                        </nav>
                        <div class="w-full md:w-5/6 overflow-hidden h-max">
                            <div class="grid grid-cols-5 gap-10">
                                <div class="space-y-4 col-span-5"
                                     :class="{'lg:col-span-3': !!$slots.sidebar, 'md:col-span-5': !!!$slots.sidebar}">
                                    <slot/>
                                </div>
                                <div class="col-span-2 bg-white shadow-sm md:rounded-lg h-max">
                                    <slot name="sidebar"/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</template>
