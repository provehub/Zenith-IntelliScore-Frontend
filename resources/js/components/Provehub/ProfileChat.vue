<template>

<button @click="confirmStart()" class="inline-flex items-center gap-2 rounded border border-blue-600 px-4 py-2 bg-blue-600 text-white hover:bg-white hover:text-blue-600 focus:outline-none focus:ring active:bg-blue-500">
    <span class="text-md font-medium">Chat</span>
    <ChatBubbleBottomCenterTextIcon class="h-5 w-5" />
  </button>

                 <!-- Start Modal -->
<Modal :show="confirmingStart" @close="closeModalDestroy" >
        <div class="rounded-lg bg-white p-8 shadow-2xl">
          <div class="absolute top-0 right-0 hidden pt-4 pr-4 sm:block">
                <button type="button" class="rounded-md bg-white text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2" @click="closeModalDestroy">
                  <span class="sr-only">Close</span>
                  <XMarkIcon class="h-6 w-6" aria-hidden="true" />
                </button>
              </div>

  <p class="mt-2 text-sm text-gray-500">
    All chats/messages can found in your dashboard.
  </p>

  <!-- <button v-if="!account" @click="connectWallet" class="text-sm font-semibold leading-6 text-gray-900">Connect Wallet <span aria-hidden="true">&rarr;</span></button> -->

  <div class="mt-4">

    <!-- chat button -->
    <div class="mt-5 " v-if="$page.props.auth.user">
                  
      <div v-if="props.owner.user_id == $page.props.auth.user.id">
        <button @click="closeModalDestroy" type="button" class="rounded bg-red-50 px-4 py-2 text-sm font-medium text-red-600">
    <span class="flex"> You cannot send a message to yourself.</span>
    </button>
      </div>

                  <!-- message box -->
                  <div v-else>
                  <form @submit.prevent="upload" class=" space-y-2 items-center">
                  <textarea class="block mt-2 w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm px-4 h-32 py-2.5"
                    placeholder="Type a message"
                    type="text"
                    v-model="form.message"
                    required
                    autofocus
                    autocomplete="message"
                ></textarea>
                <input type="hidden" v-model="form.owner">
                <input type="hidden" v-model="form.owner_type">
                <input type="hidden" v-model="form.to_user_id">
                <input type="hidden" v-model="form.from_user_id">
                <input type="hidden" v-model="form.chat_id">
                <button
                type="submit"
                  class="group relative inline-block overflow-hidden border border-blue-600 px-8 py-3 focus:outline-none focus:ring w-fit rounded-md"
                >
                  <span
                    class="absolute inset-x-0 bottom-0 h-[2px] bg-blue-600 transition-all group-hover:h-full group-active:bg-blue-500"
                  ></span>

                  <span
                    class="flex justify-center items-center relative text-md font-medium text-blue-600 transition-colors group-hover:text-white gap-4"
                  >
                    Send <PaperAirplaneIcon class="h-5 w-5" />
                  </span> 
                </button>

                <Transition class="transition duration-20000 ease-in-out">
                    <h1 v-if="form.recentlySuccessful" class="text-sm text-gray-600 bg-green-500">Message sent. </h1>
                </Transition>

              </form>
              </div>
                  <!-- message box -->
                </div>

                <div class="mt-5 " v-else>
                  <div class="sm:flex sm:items-start">
                <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                  <ExclamationTriangleIcon class="h-6 w-6 text-red-600" aria-hidden="true" />
                </div>
                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                  <div as="h3" class="text-lg font-medium leading-6 text-gray-900">Register/Login</div>
                  <div class="mt-2">
                    <p class="text-sm text-gray-500">You need to be registered or login to send a message.</p>
                  </div>

                  <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
                <Link :href="route('register')" class="inline-flex w-full justify-center rounded-md border border-transparent bg-red-600 px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 sm:ml-3 sm:w-auto sm:text-sm" >Register</Link>
                <Link :href="route('login')" class="mt-3 inline-flex w-full justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-base font-medium text-gray-700 shadow-sm hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:mt-0 sm:w-auto sm:text-sm">Login</Link>
              </div>
              
                </div>

                

              </div>
                </div>
                <!-- chat button -->

  </div>

  <div class="mt-4 flex gap-2">

    

    <!-- <button @click="closeModalDestroy" type="button" class="rounded bg-red-50 px-4 py-2 text-sm font-medium text-red-600">
    <span class="flex"> No, go back</span>
    </button> -->
  </div>

  
</div>

       
    </Modal>
    <!-- Modal -->
</template>

<script setup>
import { Link,useForm,usePage  } from '@inertiajs/vue3';
import { ref, computed, watchEffect } from "vue";
import Modal from '@/Components/Modal.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';

import { Disclosure, DisclosureButton, DisclosurePanel, Menu, MenuButton, MenuItem, MenuItems, } from '@headlessui/vue'
  import {
    BarsArrowUpIcon,
    CheckBadgeIcon,
    ChevronDownIcon,
    ChevronRightIcon,
    MagnifyingGlassIcon,
    RectangleStackIcon,
    StarIcon,
  } from '@heroicons/vue/20/solid'

  import { Bars3CenterLeftIcon, XMarkIcon,ChatBubbleBottomCenterTextIcon,ExclamationTriangleIcon,PaperAirplaneIcon  } from '@heroicons/vue/24/outline'

  const props = defineProps([
  'owner',
  'owner_type',
])

  const user = usePage().props.auth.user?.id ?? null;

  const form = useForm({
    message: '',
    owner: '',
    owner_type: '',
    to_user_id: '',
    from_user_id: '',
    chat_id: '',
});

watchEffect(() => {
      form.owner = props.owner.id, 
      form.owner_type = props.owner_type, 
      form.to_user_id = props.owner.user_id, 
      form.from_user_id = user
    })

    const upload = () => {
  form.post(
    route('profile.create.message'),
    {
    preserveScroll: true,
      onSuccess: () => form.reset('message'),
    },
  )
}



const confirmingStart = ref(false);

const confirmStart = () => {
    confirmingStart.value = true;
};

const closeModalDestroy = () => {
    confirmingStart.value = false;
};


</script>
