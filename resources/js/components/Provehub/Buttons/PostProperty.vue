<template>
  
    <button v-if="props.ok == 0" @click="confirmStart" 
      class="group flex items-center justify-between gap-2 rounded-lg border border-blue-600 bg-blue-600 px-5 py-2 transition-colors hover:bg-transparent focus:ring-3 focus:outline-hidden">
      <span class="font-medium text-white transition-colors group-hover:text-blue-600">
        Post Property
      </span>
    
      <span class="shrink-0 rounded-full border border-current bg-white p-2 text-blue-600 ">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 21v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21m0 0h4.5V3.545M12.75 21h7.5V10.75M2.25 21h1.5m18 0h-18M2.25 9l4.5-1.636M18.75 3l-1.5.545m0 6.205 3 1m1.5.5-1.5-.5M6.75 7.364V3h-3v18m3-13.636 10.5-3.819" />
    </svg>
  
      </span>
    </button>


    <Link v-else :href="route('listing.create')"
      class="group flex items-center justify-between gap-2 rounded-lg border border-blue-600 bg-blue-600 px-5 py-2 transition-colors hover:bg-transparent focus:ring-3 focus:outline-hidden">
      <span class="font-medium text-white transition-colors group-hover:text-blue-600">
        Post Property
      </span>
    
      <span class="shrink-0 rounded-full border border-current bg-white p-2 text-blue-600 ">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 21v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21m0 0h4.5V3.545M12.75 21h7.5V10.75M2.25 21h1.5m18 0h-18M2.25 9l4.5-1.636M18.75 3l-1.5.545m0 6.205 3 1m1.5.5-1.5-.5M6.75 7.364V3h-3v18m3-13.636 10.5-3.819" />
    </svg>
  
      </span>
    </Link>
  
     <!-- Start Modal -->
  <Modal :show="confirmingStart" @close="closeModalDestroy" >
    <div class="absolute top-0 right-0 hidden sm:block text-red-500">
                  <button type="button" class="rounded-md   hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2" @click="closeModalDestroy">
                    <span class="sr-only">Close</span>
                    <XMarkIcon class="h-6 w-6 " aria-hidden="true" />
                  </button>
                </div>
          <div class="rounded-lg shadow-2xl p-4">
            
  
    <div class="grid min-h-full grid-cols-1 grid-rows-2 lg:grid-cols-2 lg:grid-rows-1">
      <div class="relative flex">
        <img src="https://images.pexels.com/photos/7578983/pexels-photo-7578983.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1" alt="" class="absolute inset-0 h-full w-full object-cover object-center" />
        <div class="relative flex w-full flex-col items-start justify-end bg-black bg-opacity-40 p-8 sm:p-12">
          <h2 class="text-lg font-medium text-white text-opacity-75">Single Agent Registration</h2>
          <p class="mt-1 text-2xl font-medium text-white">Individual Agent</p>
          <Link :href="route('agent.create',{ agent:'single'})" class="mt-4 rounded-md bg-white px-4 py-2.5 text-sm font-medium text-gray-900 hover:bg-gray-50">Register now</Link>
        </div>
      </div>
      <div class="relative flex">
        <img src="https://images.pexels.com/photos/1181370/pexels-photo-1181370.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1" alt="" class="absolute inset-0 h-full w-full object-cover object-center" />
        <div class="relative flex w-full flex-col items-start justify-end bg-black bg-opacity-40 p-8 sm:p-12">
          <h2 class="text-lg font-medium text-white text-opacity-75">Real Estate Firm Registration</h2>
          <p class="mt-1 text-2xl font-medium text-white">Real Estate Firm</p>
          <Link :href="route('agent.create',{ agent:'firm'})" class="mt-4 rounded-md bg-white px-4 py-2.5 text-sm font-medium text-gray-900 hover:bg-gray-50">Register now</Link>
        </div>
      </div>
    </div>
  
    </div>
    </Modal>
  
  </template>
  
  <script setup lang="js">
  import { ref } from "vue";
  import Modal from '@/Components/Modal.vue';
  import { XMarkIcon  } from '@heroicons/vue/24/outline'
  import { Link } from '@inertiajs/vue3';
  
  const props = defineProps({
    'ok': Number,
})

  const confirmingStart = ref(false);
  
  const confirmStart = () => {
      confirmingStart.value = true;
  };
  
  const closeModalDestroy = () => {
      confirmingStart.value = false;
  };
  
  
  
  </script>