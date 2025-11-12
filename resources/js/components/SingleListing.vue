<script setup>
import { Link } from '@inertiajs/vue3';
import { onMounted, onUnmounted, ref, computed  } from 'vue';
const isVisible = ref(false);


const closeOnEscape = (e) => {
    if (isVisible.value && e.key === 'Escape') {
        isVisible.value = false;
    }
};
onMounted(() => document.addEventListener('keydown', closeOnEscape));
onUnmounted(() => document.removeEventListener('keydown', closeOnEscape));

const props = defineProps([
    'listings',
])

</script>
<template>
<!-- each -->
<div v-for="listing in props.listings" :key="listing.id" class="group grid w-full ">
  <div class="relative mx-auto w-full">
    <a href="#" class="relative inline-block w-full">
      <div class="rounded-lg bg-white p-4 shadow">
        <div class="relative flex h-52 justify-center overflow-hidden rounded-lg">
          <div class="w-full transform transition-transform duration-500 ease-in-out hover:scale-110">
            <Link :href="route('listing.show',listing.slug)" class="absolute inset-0 bg-black bg-opacity-80">
              <img :src="listing.images[0].img" alt="" class="h-full w-full object-cover object-center" />
            </Link>
          </div>

          <div class="absolute bottom-0 left-5 mb-3 flex">
            <p class="flex items-center font-medium text-white shadow-sm">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 015.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 00-1.134-.175 2.31 2.31 0 01-1.64-1.055l-.822-1.316a2.192 2.192 0 00-1.736-1.039 48.774 48.774 0 00-5.232 0 2.192 2.192 0 00-1.736 1.039l-.821 1.316z" />
  <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0zM18.75 10.5h.008v.008h-.008V10.5z" />
</svg>

              {{ listing.images_count }} 
            </p>
          </div>
          <div class="absolute bottom-0 right-5 mb-3 flex">
            <p class="flex items-center font-medium text-white">
              <!-- <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
  <path fill-rule="evenodd" d="M6.32 2.577a49.255 49.255 0 0111.36 0c1.497.174 2.57 1.46 2.57 2.93V21a.75.75 0 01-1.085.67L12 18.089l-7.165 3.583A.75.75 0 013.75 21V5.507c0-1.47 1.073-2.756 2.57-2.93z" clip-rule="evenodd" />
</svg> -->



            </p>
          </div>

          <span class="absolute top-0 right-2 z-10 mt-3 ml-3 inline-flex select-none rounded-sm bg-yellow-600 px-2 py-1 text-xs font-semibold text-white" v-if="listing.status"> Promoted </span>
          <span class="absolute top-0 left-0 z-10 mt-3 ml-3 inline-flex select-none rounded-lg bg-transparent px-3 py-2 text-lg font-medium text-white" v-if="listing.status"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M15.042 21.672L13.684 16.6m0 0l-2.51 2.225.569-9.47 5.227 7.917-3.286-.672zM12 2.25V4.5m5.834.166l-1.591 1.591M20.25 10.5H18M7.757 14.743l-1.59 1.59M6 10.5H3.75m4.007-4.243l-1.59-1.59" />
</svg>
 </span>
        </div>

        <div class="mt-4">
          <Link :href="route('listing.show',listing.slug)" class="underline"><h2 class="line-clamp-1 font-medium text-gray-800 dark:text-gray-800  md:text-lg">{{ listing.name }}</h2></Link>
          <p class="text-primary mt-2 inline-block whitespace-nowrap rounded-xl font-semibold leading-tight">
            <Link :href="route('listing.show',listing.slug)"><span class="text-2xl text-gray-800 dark:text-gray-800">{{ $page.props.site.ccc.currency_symbol }} 
          {{ Number(listing.price).toLocaleString() }}</span></Link>
            
          </p>
        </div>
        
        <div class="mt-6 flex items-center gap-8 text-xs">
      <div class="sm:inline-flex sm:shrink-0 sm:items-center sm:gap-2">
        <svg
          class="size-4 text-blue-700"
          xmlns="http://www.w3.org/2000/svg"
          fill="none"
          viewBox="0 0 24 24"
          stroke="currentColor"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"
          />
        </svg>

        <div class="mt-1.5 sm:mt-0">
          <p class="text-gray-500">Parking</p>

          <p class="font-medium">2 spaces</p>
        </div>
      </div>

      <div class="sm:inline-flex sm:shrink-0 sm:items-center sm:gap-2">
        <svg
          class="size-4 text-blue-700"
          xmlns="http://www.w3.org/2000/svg"
          fill="none"
          viewBox="0 0 24 24"
          stroke="currentColor"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"
          />
        </svg>

        <div class="mt-1.5 sm:mt-0">
          <p class="text-gray-500">Bathroom</p>

          <p class="font-medium">2 rooms</p>
        </div>
      </div>

      <div class="sm:inline-flex sm:shrink-0 sm:items-center sm:gap-2">
        <svg
          class="size-4 text-blue-700"
          xmlns="http://www.w3.org/2000/svg"
          fill="none"
          viewBox="0 0 24 24"
          stroke="currentColor"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"
          />
        </svg>

        <div class="mt-1.5 sm:mt-0">
          <p class="text-gray-500">Bedroom</p>

          <p class="font-medium">4 rooms</p>
        </div>
      </div>
    </div>
       
        <!-- <div class="mt-8 grid grid-cols-2">
          <div class="flex items-center">
           
                      <div class="relative">
                        <Link :href="route('index')">
                          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            </svg>
                        </Link>
                    </div>
            <Link :href="route('index')" >
            <p class="line-clamp-1 ml-1 text-gray-800">Agent Name</p>

                  </Link>

            
          </div>

          <div class="flex justify-end gap-1">
            <button class="rounded-md bg-yellow-500 py-1 px-1 text-white">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.76c0 1.6 1.123 2.994 2.707 3.227 1.087.16 2.185.283 3.293.369V21l4.076-4.076a1.526 1.526 0 011.037-.443 48.282 48.282 0 005.68-.494c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z" />
                </svg></button>
            <button class="rounded-md bg-blue-700 py-1 px-1 text-white"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 3.75v4.5m0-4.5h-4.5m4.5 0l-6 6m3 12c-8.284 0-15-6.716-15-15V4.5A2.25 2.25 0 014.5 2.25h1.372c.516 0 .966.351 1.091.852l1.106 4.423c.11.44-.054.902-.417 1.173l-1.293.97a1.062 1.062 0 00-.38 1.21 12.035 12.035 0 007.143 7.143c.441.162.928-.004 1.21-.38l.97-1.293a1.125 1.125 0 011.173-.417l4.423 1.106c.5.125.852.575.852 1.091V19.5a2.25 2.25 0 01-2.25 2.25h-2.25z" />
            </svg>
            </button>
          </div>
        </div> -->

        
      </div>
    </a>
  </div>
</div>
      <!-- each -->
</template>