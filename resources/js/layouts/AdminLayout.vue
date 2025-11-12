<script setup>
import { ref,computed } from 'vue';
import ApplicationLogoWhite from '@/Components/ApplicationLogoWhite.vue';
import Favicon from '@/Components/Favicon.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { Link,usePage } from '@inertiajs/vue3';
 
const showingNavigationDropdown = ref(false);

const page = usePage()

const flashSuccess = computed(
() => page.props.flash.success,
)
const flashError = computed(
() => page.props.flash.error,
)

</script>

<template>
    <Favicon />
<div>
<div class="min-h-screen bg-gray-900">
    
<nav class="bg-gray-800">
<!-- Primary Navigation Menu -->
<div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
<div class="flex h-16 items-center justify-between">
    <div class="flex items-center">
        <!-- Logo -->
        <div class="flex-shrink-0">
            <Link :href="route('admin.dashboard')">
            <ApplicationLogoWhite class="block h-9 w-auto fill-current text-white" />
            </Link>
        </div>

        <!-- Navigation Links -->
        <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
            <NavLink :href="route('admin.dashboard')" :active="route().current('admin.dashboard')">
                Dash
            </NavLink>
            <NavLink :href="route('admin.agents')" :active="route().current('admin.agents')">
                Agents
            </NavLink>
            <NavLink :href="route('admin.blogs')" :active="route().current('admin.blogs')">
                Blog
            </NavLink>
            <NavLink :href="route('admin.category')" :active="route().current('admin.category')">
                Category
            </NavLink>
            <NavLink :href="route('admin.listings')" :active="route().current('admin.listings')">
                Listings
            </NavLink>
            <NavLink :href="route('admin.promotions')" :active="route().current('admin.promotions')">
                Promotions
            </NavLink>
            <NavLink :href="route('admin.settings')" :active="route().current('admin.settings')">
                Settings
            </NavLink>
        </div>

    </div>

    <div class="hidden sm:flex sm:items-center sm:ml-6">
        <!-- Settings Dropdown -->
        <div class="ml-3 relative">
            <Dropdown align="right" width="48">
                <template #trigger>
                    <span class="inline-flex rounded-md">
                        <button type="button"
                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            {{ $page.props.auth.user.name }}

                            <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                    </span>
                </template>

                <template #content>
                    <DropdownLink :href="route('profile.edit')"> Profile </DropdownLink>
                    <DropdownLink :href="route('logout')" method="post" as="button">
                        Log Out
                    </DropdownLink>
                </template>
            </Dropdown>
        </div>
    </div>

    <!-- Hamburger -->
    <div class="-mr-2 flex items-center sm:hidden">
        <button @click="showingNavigationDropdown = !showingNavigationDropdown"
            class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                <path :class="{
                    hidden: showingNavigationDropdown,
                    'inline-flex': !showingNavigationDropdown,
                }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4 6h16M4 12h16M4 18h16" />
                <path :class="{
                    hidden: !showingNavigationDropdown,
                    'inline-flex': showingNavigationDropdown,
                }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

</div>
</div>

<!-- Responsive Navigation Menu -->
<div :class="{ block: showingNavigationDropdown, hidden: !showingNavigationDropdown }" class="sm:hidden">
<div class="pt-2 pb-3 space-y-1">
    <ResponsiveNavLink :href="route('admin.dashboard')" :active="route().current('dashboard')">
        Dash
    </ResponsiveNavLink>

    <ResponsiveNavLink :href="route('admin.agents')" :active="route().current('admin.agents')">
        Agents
    </ResponsiveNavLink>

    <ResponsiveNavLink :href="route('admin.blogs')" :active="route().current('admin.blogs')">
        Blogs
    </ResponsiveNavLink>

    <ResponsiveNavLink :href="route('admin.category')" :active="route().current('admin.category')">
        Category
    </ResponsiveNavLink>

    <ResponsiveNavLink :href="route('admin.listings')" :active="route().current('admin.listings')">
        Listings
    </ResponsiveNavLink>

    <ResponsiveNavLink :href="route('admin.promotions')" :active="route().current('admin.promotions')">
        Promotions
    </ResponsiveNavLink>

    <ResponsiveNavLink :href="route('admin.settings')" :active="route().current('admin.settings')">
        Settings
    </ResponsiveNavLink>

</div>

<!-- Responsive Settings Options -->
<div class="pt-4 pb-1 border-t border-gray-200">
    <div class="px-4">
        <div class="font-medium text-base text-gray-200">
            {{ $page.props.auth.user.name }}
        </div>
        <div class="font-medium text-sm text-gray-100">{{ $page.props.auth.user.email }}</div>
    </div>

    <div class="mt-3 space-y-1">
        <ResponsiveNavLink :href="route('profile.edit')"> Profile </ResponsiveNavLink>
        <ResponsiveNavLink :href="route('logout')" method="post" as="button">
            Log Out
        </ResponsiveNavLink>
    </div>
</div>
</div>
</nav>


<!-- contents here -->
<div class="flex justify-center mt-4">
 <!-- alert -->
 <span v-if="flashSuccess"
                            class="inline-flex items-center justify-center rounded-full bg-emerald-100 px-2.5 py-0.5 text-emerald-700">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                class="-ml-1 mr-1.5 h-4 w-4">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>

                            <p class="whitespace-nowrap text-sm">{{ flashSuccess }}</p>
                        </span>
                        <span v-if="flashError"
                            class="inline-flex items-center justify-center rounded-full bg-red-100 px-2.5 py-0.5 text-red-700">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                class="-ml-1 mr-1.5 h-4 w-4">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>

                            <p class="whitespace-nowrap text-sm">{{ flashError }}</p>
                        </span>
                        <!-- alert -->
                    </div>
<slot />



</div>
</div>
</template>
