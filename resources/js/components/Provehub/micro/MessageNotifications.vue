<template>
  <!-- Message dropdown -->
  <Menu as="div" class="relative ml-4 flex-shrink-0">
                  <div>
                    <MenuButton class=" inline-flex items-center rounded-full text-sm text-white focus:outline-none focus:ring-1 focus:ring-white focus:ring-offset-1 ">
                      <span class="sr-only">Open message menu</span>


                      <ChatBubbleBottomCenterTextIcon class="h-8 w-8 text-gray-800 dark:text-white" />
                <div  class="absolute bottom-0 right-0 w-4 h-4 bg-red-500 text-white font-medium rounded-full text-xs text-center">
              {{ notificationCount }}
            </div>
            


                    </MenuButton>
                  </div>
                  <transition enter-active-class="transition ease-out duration-100" enter-from-class="transform opacity-0 scale-95" enter-to-class="transform opacity-100 scale-100" leave-active-class="transition ease-in duration-75" leave-from-class="transform opacity-100 scale-100" leave-to-class="transform opacity-0 scale-95">
                    <MenuItems class="absolute right-0 z-10 mt-2 w-fit origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">
                    <ul class="top-11 !py-0 text-dark dark:text-white-dark w-[300px] sm:w-[375px] text-xs">
                                    <li class="mb-5">
                                        <div class="overflow-hidden relative rounded-t-md !p-5 text-white">
                                            <!-- <div
  class="absolute h-full w-full bg-no-repeat bg-center bg-cover inset-0"
  :style="{ backgroundImage: `url(${ $page.props.site.img_share.six })` }"
></div> -->
                                            <div
  class="absolute h-full w-full bg-no-repeat bg-center bg-cover inset-0 bg-blue-600"
></div>

                                            <h4 class="font-semibold relative z-10 text-lg">Message Notification</h4>
                                        </div>
                                    </li>
                                    <template v-for="msg in localUnreadNotifications" :key="msg.id">
                                        <li>
                                            <div class="flex items-center py-1 px-1 w-full">
                                                <!-- <div v-html="msg.image"></div> -->
                                                <span class="px-3 dark:text-gray-500">
                                                    <div class="font-semibold text-sm dark:text-white-light/90" v-text="msg.data.createdBy"></div>
                                                    <div v-text="msg.data.body"></div>
                                                </span>
                                               
                                                <span
                                                    class="font-semibold bg-white-dark/20 rounded text-dark/60 px-1 ltr:ml-auto rtl:mr-auto whitespace-pre dark:text-white-dark ltr:mr-2 rtl:ml-2"
                                                    v-text="formatDate(msg.created_at)"
                                                ></span>
                                                <button type="button" class="text-neutral-300 hover:text-danger" @click="removeMessage(msg.id)">
                                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <circle opacity="0.5" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="1.5" />
                                                        <path
                                                            d="M14.5 9.50002L9.5 14.5M9.49998 9.5L14.5 14.5"
                                                            stroke="currentColor"
                                                            stroke-width="1.5"
                                                            stroke-linecap="round"
                                                        />
                                                    </svg>
                                                </button>
                                            </div>
                                        </li>
                                    </template>
                                    <template v-if="localUnreadNotifications.length">
                                        <li class="border-t border-white-light text-center dark:border-white/10 mt-5">
                                            <div
                                                class="flex items-center py-4 px-5 text-primary font-semibold group dark:text-gray-400 justify-center cursor-pointer"
                                                @click="close()"
                                            >
                                                <Link :href="route('chats')" class="group-hover:underline ltr:mr-1 rtl:ml-1">VIEW ALL MESSAGES</Link>

                                                <svg
                                                    class="w-4 h-4 group-hover:translate-x-1 transition duration-300 ltr:ml-1 rtl:mr-1"
                                                    viewBox="0 0 24 24"
                                                    fill="none"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                >
                                                    <path
                                                        d="M4 12H20M20 12L14 6M20 12L14 18"
                                                        stroke="currentColor"
                                                        stroke-width="1.5"
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                    />
                                                </svg>
                                            </div>
                                        </li>
                                    </template>
                                    <template v-if="!localUnreadNotifications.length">
                                        <li class="mb-5">
                                            <div class="!grid place-content-center hover:!bg-transparent text-lg min-h-[200px]">
                                                <div class="mx-auto ring-4 ring-primary/30 rounded-full mb-4 text-primary">
                                                    <svg width="40" height="40" viewBox="0 0 20 20"  class="text-gray-700" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            opacity="0.5"
                                                            d="M20 10C20 4.47715 15.5228 0 10 0C4.47715 0 0 4.47715 0 10C0 15.5228 4.47715 20 10 20C15.5228 20 20 15.5228 20 10Z"
                                                            fill="currentColor"
                                                        />
                                                        <path
                                                            d="M10 4.25C10.4142 4.25 10.75 4.58579 10.75 5V11C10.75 11.4142 10.4142 11.75 10 11.75C9.58579 11.75 9.25 11.4142 9.25 11V5C9.25 4.58579 9.58579 4.25 10 4.25Z"
                                                            fill="currentColor"
                                                        />
                                                        <path
                                                            d="M10 15C10.5523 15 11 14.5523 11 14C11 13.4477 10.5523 13 10 13C9.44772 13 9 13.4477 9 14C9 14.5523 9.44772 15 10 15Z"
                                                            fill="currentColor"
                                                        />
                                                    </svg>
                                                </div>
                                                <span class="text-gray-700">
                                                No new messages</span>
                                            </div>

                                           

                                        </li>

                                        <li class="border-t border-white-light text-center dark:border-white/10 mt-5">
                                            <div
                                                class="flex items-center py-4 px-5 text-primary font-semibold group dark:text-gray-400 justify-center cursor-pointer"
                                                @click="close()"
                                            >
                                                <Link :href="route('chats')" class="group-hover:underline ltr:mr-1 rtl:ml-1">VIEW ALL MESSAGES</Link>

                                                <svg
                                                    class="w-4 h-4 group-hover:translate-x-1 transition duration-300 ltr:ml-1 rtl:mr-1"
                                                    viewBox="0 0 24 24"
                                                    fill="none"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                >
                                                    <path
                                                        d="M4 12H20M20 12L14 6M20 12L14 18"
                                                        stroke="currentColor"
                                                        stroke-width="1.5"
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                    />
                                                </svg>
                                            </div>
                                        </li>
                                        
                                    </template>

                                </ul>
                              </MenuItems>
                  </transition>
                </Menu>
       
</template>

<script setup>
  import { Link, usePage } from '@inertiajs/vue3';
  import { ref, computed, onMounted } from 'vue';

  import { Disclosure, DisclosureButton, DisclosurePanel, Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue'
  
  import { ChatBubbleBottomCenterTextIcon } from '@heroicons/vue/24/outline'
  

  const page = usePage()
const notificationCount = computed(
  () => page.props.auth.notificationCount
)

const localUnreadNotifications = ref([]);

onMounted(() => {
  localUnreadNotifications.value = [...page.props.auth.unreadNotifications];
});

  
  const formatDate = (dateString) => {
    const now = new Date();
    const date = new Date(dateString);
    const secondsAgo = Math.round((now - date) / 1000);

    if (secondsAgo < 60) {
        return 'seconds ago';
    } else if (secondsAgo < 3600) {
        return `${Math.round(secondsAgo / 60)} minutes ago`;
    } else if (secondsAgo < 86400) {
        return `${Math.round(secondsAgo / 3600)} hours ago`;
    } else {
        return `${Math.round(secondsAgo / 86400)} days ago`;
    }
};
  
  
const removeMessage = async (value) => {
    try {
        console.log(value)
        // Send request to server to mark the notification as read
        const c = route('markas.read',{ id: value});
        await axios.post(c);

        // Filter out the notification from the local copy
        localUnreadNotifications.value = localUnreadNotifications.value.filter((d) => d.id !== value);

        // return response.data;

        
    } catch (error) {
        console.error('Error marking notification as read:', error);
        // Handle error appropriately (e.g., show a message to the user)
    }
};



  </script>


   