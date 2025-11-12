<template>
    <div class="border-l-4 border-yellow-400 bg-yellow-50 p-4">
      <div class="flex">
        <div class="flex-shrink-0">
          <ExclamationTriangleIcon class="h-5 w-5 text-yellow-400" aria-hidden="true" />
        </div>
        <div class="ml-3">
          <p class="text-sm text-yellow-700">
            You have {{ props.datum }} pending exam to take.
            {{ ' ' }}
            <a :href="route('start.exam',{ exam: props.payment})" target="_blank" class="font-medium text-yellow-700 underline hover:text-yellow-600">Take Now.</a>
          </p>
        </div>
      </div>
    </div>
  </template>
  
  <script setup>
  import { Link} from '@inertiajs/vue3';
  import { ExclamationTriangleIcon } from '@heroicons/vue/20/solid'

  const props = defineProps({
  'datum': Number,
  'payment': Object,
})

  </script>