<template>
  <div class="flex flex-col items-center justify-center gap-4">
    <div class="p-1 rounded-lg bg-blue-50/10 border border-blue-900/5 dark:border-white/10 dark:bg-white/5">
        <Link
            :href="route('register')"
            class="dark:shadow-blue-500/10 disabled:opacity-20 group relative z-[1] flex h-11 items-center justify-center gap-1.5 rounded-md border border-blue-700 bg-blue-600 px-4  text-white"
        >
        <UserPlusIcon class="h-5 w-5 text-white" aria-hidden="true" />
            <span class="whitespace-nowrap">Register</span>
        </Link>
    </div>
  </div>



</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import { UserPlusIcon } from '@heroicons/vue/20/solid'

</script>
