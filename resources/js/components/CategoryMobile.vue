<template>
    <!-- Container for the entire category grid -->
    <div
      class="grid gap-6 
             grid-cols-3 
             sm:grid-cols-3 
             md:grid-cols-4 
             lg:grid-cols-6 
             xl:grid-cols-6
             p-4 "
    >
      <!-- Single category card -->
      


      <Link v-for="category in categories" :key="category.id"  :href="'/listing?category_id[id]=' + category.id">

                       <div class="flex flex-col items-center "
      >
        <div class="bg-gray-200 shadow-sm rounded-lg p-4 hover:shadow-md transition-shadow ">
          <!-- Icon (replace with actual images if available) -->
          <img
            :src="category.img"
            alt="Category Icon"
            class="w-12 h-12 object-contain mb-2"
          />
        </div>
          <!-- Category name -->
          <span class="text-center text-sm font-medium">
            {{ category.name }}
          </span>
        
      </div>
                       
						<!-- <span class="ml-3 truncate">{{ category.name }}</span> -->
        </Link>

    </div>


    <!-- listings -->
    <h3 class="mt-8 text-bold text-2xl">Trending</h3>
<div class="bg-white">
  <div class="mx-auto max-w-2xl px-4 sm:py-4 sm:px-4 lg:max-w-7xl lg:px-4 ">
    <h2 class="sr-only">Products</h2>

    <div class="grid grid-cols-1 gap-y-10 gap-x-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 xl:gap-x-4">

     
      <SingleListing :listings="props.listings" />

      <!-- More products... -->
    </div>
  </div>
</div>
    
            <!-- listings -->
  </template>
  
  <script setup lang="js">
import { Link } from '@inertiajs/vue3';
import SingleListing from '@/Components/SingleListing.vue';

const props = defineProps([
    'categories',
    'listings',
])

  
  </script>
  