<script setup>
import { Link } from '@inertiajs/vue3';
import { onMounted, onUnmounted, ref  } from 'vue';
import SingleListing from '@/Components/SingleListing.vue';

const isVisible = ref(false);

// const formattedPrice = computed(() => {
//   return (price) => '$' + price.toFixed(2);
// });


const closeOnEscape = (e) => {
    if (isVisible.value && e.key === 'Escape') {
        isVisible.value = false;
    }
};
onMounted(() => document.addEventListener('keydown', closeOnEscape));
onUnmounted(() => document.removeEventListener('keydown', closeOnEscape));
defineProps([
    'categories',
    'listings',
])

</script>

<template>  
<div class=" inset-0 z-20" @mouseleave="isVisible = false">
    <!-- <div class="fixed inset-0" @click="isVisible = false"></div> -->
    <!-- <div class="fixed inset-0 z-20" @mouseleave="isVisible = false"></div> -->
      <!-- component -->
<div class="">
    <div class=" m-auto text-gray-500 ">
        <!-- fixed -->
<div class="">
    <div class="flex">
        <div class="w-1/4">
        <div class="sticky top-32 left-0 w-full mt-8">
            <!-- categories -->
            <!-- component items cat -->
<div class="flex items-center justify-center">
		<div class="flex max-w-xs bg-black">
			<ul class="flex flex-col">
				
                 
				<li class="my-px">
					<!-- <Link v-for="category in categories" :key="category.id" @mouseover="isVisible = true" @keydown.enter="isVisible = !isVisible" :href="'/listing?category_id[id]=' + category.id" -->
					<Link v-for="category in categories" :key="category.id"  :href="'/listing?category_id[id]=' + category.id"
					   class="flex flex-row items-center h-12 px-4 text-gray-50 hover:bg-gray-500">
						<span class="flex items-center justify-center">
              <img :src="category.img" class="h-6 w-6">
						</span>
						<span class="ml-3 truncate">{{ category.name }}</span>
                        <!-- <span class="flex flex-row items-center h-12 px-4 text-gray-500 hover:bg-gray-300"></span>
						<span class="flex items-center justify-center text-sm text-gray-700 font-semibold bg-gray-100 h-6 px-2 rounded-full ml-auto">{{ category.total_listings }} ads</span> -->
                        <svg
              xmlns="http://www.w3.org/2000/svg"
              class="h-5 w-5"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path
              :class="{ 'rotate-180': isVisible }"
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M9 5l7 7-7 7"
              />
            </svg>
        </Link>
				</li>
				
			</ul>
		</div>
	</div>
    <!-- component items cat -->
            <!-- component items cat flyout -->
            
   <div>
   
   </div>
<div v-show="isVisible" class="absolute z-20 top-0 ml-64 w-full">
    <!-- <div class="fixed inset-0" @mouseover="isVisible = true"></div> -->
		<div class="flex w-full max-w-xs dark:bg-gray-400 bg-slate-200">
			<ul class="flex flex-col w-full">
				<li class="my-px">
					<a href="#"
					   class="flex flex-row items-center h-12 px-4 text-gray-500 hover:bg-gray-300">
						<span class="flex items-center justify-center text-lg text-gray-500">
							<svg fill="none"
								 stroke-linecap="round"
								 stroke-linejoin="round"
								 stroke-width="2"
								 viewBox="0 0 24 24"
								 stroke="currentColor"
								 class="h-6 w-6">
								<path d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
							</svg>
						</span>
						<span class="ml-3">Manager</span>
					</a>
				</li>
				
				
				
				<li class="my-px">
					<a href="#"
					   class="flex flex-row items-center h-12 px-4 text-gray-500 hover:bg-gray-300">
						<span class="flex items-center justify-center text-lg text-gray-500">
							<svg fill="none"
								 stroke-linecap="round"
								 stroke-linejoin="round"
								 stroke-width="2"
								 viewBox="0 0 24 24"
								 stroke="currentColor"
								 class="h-6 w-6">
								<path d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
								<path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
							</svg>
						</span>
						<span class="ml-3">Settings</span>
					</a>
				</li>
				
			</ul>
		</div>
        
	</div>
    <!-- component items cat flyout -->
            <!-- categories -->
        </div>
        
        </div>
        <div class="w-3/4 ">
            <!-- cta -->
        <div class="container mt-8">
        </div>
       
            <!-- cta -->
            <!-- listings -->
            <h3 class="mt-8 text-bold text-2xl">Trending</h3>
<div class="">
  <div class="mx-auto max-w-2xl px-4 sm:py-4 sm:px-4 lg:max-w-7xl lg:px-4 ">
    <h2 class="sr-only">Products</h2>

    <div class="grid grid-cols-1 gap-y-6 gap-x-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3 xl:gap-x-4">

      
      <SingleListing :listings="listings" />

     
    </div>
  </div>
</div>
    
            <!-- listings -->
        </div>
    </div>
</div>
    <!-- fixed -->
    </div>
</div>
</div>
</template>
