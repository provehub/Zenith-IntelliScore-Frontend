<template>
    <div class="min-h-full">
      <Popover as="header" class="bg-gradient-to-r from-blue-800 to-yellow-600" v-slot="{ open }">
       
      <nav class="flex items-center justify-between p-2 lg:px-8" aria-label="Global">
        <div class="flex lg:flex-1">
          <Link :href="route('index')" class="-m-1.5 p-1.5">
            <span class="sr-only">Your Community</span>
            <ApplicationLogoWhite class="h-10 w-auto" alt="Zenith IntelliScore" />
          </Link>
        </div>
       
        <!-- Menu button -->
        <div class="absolute right-0 flex-shrink-0 lg:hidden">
          <!-- Mobile menu button -->
          <PopoverButton class="inline-flex items-center justify-center rounded-md bg-transparent p-2 text-cyan-200 hover:bg-white hover:bg-opacity-10 hover:text-white focus:outline-none focus:ring-2 focus:ring-white">
            <span class="sr-only">Open main menu</span>
            <Bars3Icon v-if="!open" class="block h-6 w-6 " aria-hidden="true" />
            <XMarkIcon v-else class="block h-6 w-6" aria-hidden="true" />
            
          </PopoverButton>
        </div>

        <div class="hidden lg:flex lg:gap-x-12">
          <Link v-for="item in navigation" :key="item.name" :href="item.href" class="text-sm font-semibold leading-6 text-white">{{ item.name }}</Link>
        </div>
        <div class=" lg:flex lg:flex-1 lg:justify-end gap-3 mr-8">
          <RegisterButton />
        </div>
      </nav>

        <TransitionRoot as="template" :show="open">
          <div class="lg:hidden">
            <TransitionChild as="template" enter="duration-150 ease-out" enter-from="opacity-0" enter-to="opacity-100" leave="duration-150 ease-in" leave-from="opacity-100" leave-to="opacity-0">
              <PopoverOverlay class="fixed inset-0 z-20 bg-black bg-opacity-25" />
            </TransitionChild>
  
            <TransitionChild as="template" enter="duration-150 ease-out" enter-from="opacity-0 scale-95" enter-to="opacity-100 scale-100" leave="duration-150 ease-in" leave-from="opacity-100 scale-100" leave-to="opacity-0 scale-95">
              <PopoverPanel focus class="absolute inset-x-0 top-0 z-30 mx-auto w-full max-w-3xl origin-top transform p-2 transition">
                <div class="divide-y divide-gray-200 rounded-lg bg-white shadow-lg ring-1 ring-black ring-opacity-5">
                  <div class="pt-3 pb-2">
                    <div class="flex items-center justify-between px-4">
                      <div>
                        <ApplicationLogoWhite class="h-8 w-auto" alt="Zenith IntelliScore" />
                      </div>
                      <div class="-mr-2">
                        <PopoverButton class="inline-flex items-center justify-center rounded-md bg-white p-2 text-gray-400 hover:bg-gray-100 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-cyan-500">
                          <span class="sr-only">Close menu</span>
                          <XMarkIcon class="h-6 w-6" aria-hidden="true" />
                        </PopoverButton>
                      </div>
                    </div>
                    <div class="mt-3 space-y-1 px-2">
                      <Link v-for="item in navigation" :key="item.name" :href="item.href" class="block rounded-md px-3 py-2 text-base font-medium text-gray-900 hover:bg-gray-100 hover:text-gray-800">{{ item.name }}</Link>
                    </div>
                  </div>
                  <div class="pt-4 pb-2">
                    <div class="flex items-center px-5">
                      <!-- <div class="flex-shrink-0">
                        <img class="h-10 w-10 rounded-full" src="user.img" alt="" />
                      </div> -->
                      <div class="ml-3 min-w-0 flex-1">
                        <!-- <div class="truncate text-base font-medium text-gray-800">WWWW</div> -->
                        <!-- <div class="truncate text-sm font-medium text-gray-500">12345, NY</div> -->
                      </div>
                      <!-- <button type="button" class="ml-auto flex-shrink-0 rounded-full bg-white p-1 text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:ring-offset-2">
                        <span class="sr-only">View notifications</span>
                        <BellIcon class="h-6 w-6" aria-hidden="true" />
                      </button> -->
                    </div>
                    <!-- <div class="mt-3 space-y-1 px-2">
                      <a v-for="item in userNavigation" :key="item.name" :href="item.href" class="block rounded-md px-3 py-2 text-base font-medium text-gray-900 hover:bg-gray-100 hover:text-gray-800">{{ item.name }}</a>
                      <ResponsiveNavLink :href="route('logout')" method="post" as="button">
                                Log Out
                            </ResponsiveNavLink>
                    </div> -->
                  </div>
                </div>
              </PopoverPanel>
            </TransitionChild>
          </div>
        </TransitionRoot>
      </Popover>
      
     
    </div>
  </template>
  
  <script setup>
import { Link,usePage } from '@inertiajs/vue3';
// import { watchEffect,ref } from 'vue';
import ApplicationLogoWhite from '@/Components/ApplicationLogoWhite.vue';

// import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import RegisterButton from '@/Components/Provehub/Buttons/RegisterButton.vue';

import {
  Popover,
  PopoverButton,
  PopoverOverlay,
  PopoverPanel,
  TransitionChild,
  TransitionRoot,
} from '@headlessui/vue'
import {
  Bars3Icon,
  XMarkIcon,
} from '@heroicons/vue/24/outline'

const navigation = [
  { name: 'Home', href: route('index'), current: true },
  { name: 'About', href: route('about'), current: false },
  // { name: 'Gallery', href: route('gallery'), current: false },
  { name: 'Our Blog', href: route('blog'), current: false },
  { name: 'Contact Us', href: route('contact'), current: false },
  // { name: 'Regist121er', href: route('register'), current: false },
  { name: 'Login', href: route('login'), current: false },
]
// const userNavigation = [
//   { name: 'My Dashboard', href: '#' },
//   { name: 'Settings', href: '#' }, 
// ]
</script>