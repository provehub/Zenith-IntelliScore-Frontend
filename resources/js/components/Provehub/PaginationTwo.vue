<template>
  <!-- Pagination -->
  <nav aria-label="Pagination" class="mx-auto mt-12 flex max-w-7xl justify-between px-4 text-sm font-medium text-gray-700 sm:px-6 lg:px-8">
    <div class="min-w-0 flex-1">
      <!-- Previous here -->
      <Link
        v-if="previousLink"
        :href="previousLink.url"
        class="inline-flex h-10 items-center rounded-md border border-gray-300 bg-white px-4 hover:bg-gray-100 focus:border-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:ring-opacity-25 focus:ring-offset-1 focus:ring-offset-blue-600"
        v-html="previousLink.label"
      ></Link>
    </div>
    <div class="space-x-2 sm:flex">
      <!-- Numbers here (filtered out) -->
      <Link
        v-for="(link, index) in numberLinks"
        :key="index"
        :href="link.url"
        class="inline-flex h-10 items-center rounded-md border border-gray-300 bg-white px-4 hover:bg-gray-100 focus:border-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:ring-opacity-25 focus:ring-offset-1 focus:ring-offset-blue-600"
        :class="{
          'border-blue-600 ring-1 ring-blue-600': link.active
        }"
        v-html="link.label"
      />
    </div>
    <div class="flex min-w-0 flex-1 justify-end">
      <!-- Next here -->
      <Link
        v-if="nextLink"
        :href="nextLink.url"
        class="inline-flex h-10 items-center rounded-md border border-gray-300 bg-white px-4 hover:bg-gray-100 focus:border-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:ring-opacity-25 focus:ring-offset-1 focus:ring-offset-blue-600"
        v-html="nextLink.label"
      ></Link>
    </div>
  </nav>
</template>

<script setup>
import { computed } from 'vue'
  import { Link } from '@inertiajs/vue3';
  const props = defineProps({
    links: [Object,Array],
  })

  // Extract previous, next, and number links
const previousLink = computed(() => props.links.find(link => link.label.includes('Previous')));
const nextLink = computed(() => props.links.find(link => link.label.includes('Next')));
const numberLinks = computed(() => props.links.filter(link => !link.label.includes('Previous') && !link.label.includes('Next')));

  </script>