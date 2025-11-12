<template>
     <Head title="404" />
    <Favicon />
    <div class="flex flex-col bg-white">
    <!-- <img
      src="https://images.unsplash.com/photo-1571902943202-507ec2618e8f?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1548&q=80"
      alt=""
      class="object-cover w-full h-64"
    /> -->
  
    <div class="flex items-center justify-center flex-1">
      <div class="max-w-xl px-4 py-8 mx-auto text-center">
        <h1 class="text-2xl font-bold tracking-tight text-gray-900 sm:text-4xl">
          We can't find that page.
        </h1>
  
        <p class="mt-4 text-gray-500">
          Try something else, or return home to start from the beginning.
        </p>
  
        <Link
          :href="route('index')"
          class="inline-block px-5 py-3 mt-6 text-sm font-medium text-white bg-blue-600 rounded hover:bg-blue-700 focus:outline-none focus:ring"
        >
          Go Back Home
        </Link>
      </div>
    </div>
  </div>
  
  </template>
  
  <script setup>
  import Favicon from '@/Components/Favicon.vue';
  import { Link,Head } from '@inertiajs/vue3';

  </script>