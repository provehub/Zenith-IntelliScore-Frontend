<script setup>
import ApplicationLogoWhite from '@/Components/ApplicationLogoWhite.vue';
import Favicon from '@/Components/Favicon.vue';
import Search2Header from '@/Components/Search2Header.vue';
import { Link,usePage } from '@inertiajs/vue3';
import { computed, onMounted, onUnmounted, ref } from 'vue'; 

const page = usePage();
const user = computed(() => {
  return page.props.auth.user?.user_type || 0;
});

// props.auth.user
const btnopen = ref(false);
const opw = ref(false);
const opm = ref(false);
const closeOnEscape = (e) => {
    if (open.value && e.key === 'Escape' || opw.value && e.key === 'Escape' || opm.value && e.key === 'Escape' || btnopen.value && e.key === 'Escape') {
        open.value = false;
        opw.value = false;
        opm.value = false;
        btnopen.value = false;
    }
};
onMounted(() => document.addEventListener('keydown', closeOnEscape));
onUnmounted(() => document.removeEventListener('keydown', closeOnEscape));
const open = ref(false);


</script>
<template> 
  <div v-show="btnopen" class="fixed inset-0 z-40" @click="btnopen = false"></div>  
    <div v-show="btnopen" class="relative z-40" role="dialog" aria-modal="true">
      <div class="fixed inset-0 bg-black bg-opacity-25"></div>
      <div class="fixed inset-0 z-40 flex">
        <div class="relative flex w-full max-w-xs flex-col overflow-y-auto bg-white pb-12 shadow-xl">
          <div class="flex px-4 pt-5 pb-2">
            <button type="button" class="-m-2 inline-flex items-center justify-center rounded-md p-2 text-gray-400" @click="btnopen = false">
              <span class="sr-only">Close menu</span>
              <!-- Heroicon name: outline/x-mark -->
              <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </button>
          </div>
  
          <!-- Links -->
           <!-- Links -->
           <div class="mt-2">
            <div class="border-b border-gray-200" >
              <div class="-mb-px flex space-x-8 px-4" aria-orientation="horizontal" role="tablist">

                <Link :href="route('index')" class="flex items-center text-sm font-medium border-indigo-600 text-indigo-600 border-b-2">Home</Link>
              </div>
            </div>
          </div>

  
          <div class="space-y-6 border-t border-gray-200 py-6 px-4">
            
            <div v-if="!user" class="flow-root">
              <Link  :href="route('login')" class="-m-2 block p-2 font-medium text-gray-800">Sign in</Link>
              <Link :href="route('register')" class="-m-2 block p-2 font-medium text-gray-800">Create account</Link>
            </div>
            <div v-else class="flow-root">
              <Link v-if="user == 12 || user == 10" :href="route('dashboard')" class="-m-2 block p-2 font-medium text-gray-800">Dashboard</Link>

              <Link v-else :href="route('admin.dashboard')" class="-m-2 block p-2 font-medium text-gray-800">Admin Dashboard</Link>
            </div>
          </div>
  
          <div class="border-t border-gray-200 py-6 px-4">
            <a href="#" class="-m-2 flex items-center p-2">
              <span class="flag flag-ngn flex-shrink-0" ></span>
              <span class="sr-only">, change currency</span>
            </a>
          </div>
        </div>
      </div>
    </div>
  
    <header class="sticky top-0 z-20 bg-gray-800">
      <Favicon />
      
  
      <nav aria-label="Top" class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="border-b border-gray-200">
          <div class="flex h-16 items-center">
            <!-- Mobile menu toggle, controls the 'mobileMenuOpen' state. -->
            <button type="button" class="rounded-md bg-white p-2 text-gray-400 lg:hidden" @click="btnopen = !btnopen">
              <span class="sr-only">Open menu</span>
              <!-- Heroicon name: outline/bars-3 -->
              <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
              </svg>
            </button>
  
            <!-- Logo -->
            <div class="ml-4 flex lg:ml-0 hidden md:block">
              <Link :href="route('index')">
                <span class="sr-only">Prove Marketplace</span>
                <ApplicationLogoWhite class="w-22 h-10 fill-current" />
              </Link>
            </div>
  
            <!-- Flyout menus -->
            <div v-show="opw" class="fixed inset-0 z-40" @click="opw = false"></div>
            <div v-show="opm" class="fixed inset-0 z-40" @click="opm = false"></div>
            <!-- <div class="hidden lg:ml-8 lg:block lg:self-stretch">
              <div class="flex h-full space-x-8">
              </div>
            </div> -->
               <div class="flex justify-center w-2/3 max-w-screen-xl mx-auto">
                <!-- search desktop -->
                <Search2Header />
                <!-- search desktop -->
              </div> 
            <div class="ml-auto flex items-center">
              
              <div class="hidden lg:flex lg:flex-1 lg:items-center lg:justify-end lg:space-x-6">
                <!-- <Link :href="route('dashboard')"></Link> -->
                <Link v-if="user == 12 || user == 10" :href="route('dashboard')" class="-m-2 block p-2 font-medium text-gray-100">Dashboard</Link>
                
                <Link v-if="user == 1"
                :href="route('admin.dashboard')" class="text-sm font-medium text-gray-50 hover:text-gray-200">Admin Dashboard </Link>

                <Link v-if="user == 0" :href="route('login')" class="text-sm font-medium text-gray-50 hover:text-gray-200">Sign in</Link>
                <span class="h-6 w-px bg-gray-200" aria-hidden="true"></span>
                <Link v-if="user == 0" :href="route('register')" class="text-sm font-medium text-gray-50 hover:text-gray-200">Create account</Link>
              </div>
  
              <div class="hidden lg:ml-8 lg:flex">
                <a href="#" class="flex items-center text-gray-50 hover:text-gray-200">
                  <div class="">
                    <span class="flag flag-ngn flex-shrink-0" ></span>
                  </div>
                  
                  <span class="flag flag-ngn flex-shrink-0" ></span>
                  <span class="sr-only">, change country</span>
                </a>
              </div>
  
            </div>
          </div>
        </div>
      </nav>
    </header>
  
    <div>
    <!-- <div v-click-outside="toggleOpwClose"> -->
            <slot />
        </div>
</template>
