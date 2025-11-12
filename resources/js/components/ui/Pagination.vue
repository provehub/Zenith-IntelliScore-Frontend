<template>
  <div class="flex gap-1 mt-4 ">
    <Link
      v-for="(link, index) in links" 
      :key="index" class="flex items-center justify-center w-1/2 px-5 py-2 text-sm text-gray-700 capitalize transition-colors duration-200 bg-white border rounded-md sm:w-auto gap-x-2 hover:bg-gray-100 dark:bg-gray-900 dark:text-gray-200 dark:border-gray-700 dark:hover:bg-gray-800" 
      :href="link.url" 
      :class="{'flex items-center justify-center w-1/2 px-5 py-2 text-sm text-gray-700 capitalize transition-colors duration-200 bg-white border rounded-md sm:w-auto gap-x-2 hover:bg-gray-100 dark:bg-blue-900 dark:text-gray-200 dark:border-blue-700 dark:hover:bg-blue-800': link.active}"
      v-html="link.label"
    />
  </div>
</template>

<script setup>
import {Link} from '@inertiajs/vue3'
defineProps({links: Array})
</script>