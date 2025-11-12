 <template>
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    <div class="mx-auto max-w-2xl lg:mx-0 lg:max-w-none">
   <ul role="list" class="mt-6 grid grid-cols-1 gap-x-6 gap-y-8 lg:grid-cols-3 xl:gap-x-8">
            <li v-for="datum in props.data.data" :key="datum.id" class="overflow-hidden rounded-xl border border-gray-200">
              <div class="flex items-center gap-x-4 border-b border-gray-900/5 bg-gray-50 p-6">
                <UserCircleIcon v-if="datum.teachers?.user?.profile_image == null" class="h-8 w-8 text-gray-300"  />
                <img v-else :src="datum.teachers?.user?.img" :alt="datum.teachers?.user?.name" class="h-12 w-12 flex-none rounded-lg bg-white object-cover ring-1 ring-gray-900/10" />
                <div class="text-sm font-medium leading-6 text-gray-900">{{ datum.teachers?.user?.name }}</div>
                <Menu as="div" class="relative ml-auto">
                  <MenuButton class="-m-2.5 block p-2.5 text-gray-400 hover:text-gray-500">
                    <span class="sr-only">Open options</span>
                    
                    <EllipsisHorizontalIcon class="h-5 w-5" aria-hidden="true" />
                  </MenuButton>
                  <transition enter-active-class="transition ease-out duration-100" enter-from-class="transform opacity-0 scale-95" enter-to-class="transform opacity-100 scale-100" leave-active-class="transition ease-in duration-75" leave-from-class="transform opacity-100 scale-100" leave-to-class="transform opacity-0 scale-95">
                    <MenuItems class="absolute right-0 z-10 mt-0.5 w-32 origin-top-right rounded-md bg-white py-2 shadow-lg ring-1 ring-gray-900/5 focus:outline-none">
                      <MenuItem v-slot="{ active }">
                        <a href="#" :class="[active ? 'bg-gray-50' : '', 'block px-3 py-1 text-sm leading-6 text-gray-900']"
                          >View<span class="sr-only">, {{ datum.teachers?.user?.name }}</span></a
                        >
                      </MenuItem>
                      <MenuItem v-slot="{ active }">
                        <a href="#" :class="[active ? 'bg-gray-50' : '', 'block px-3 py-1 text-sm leading-6 text-gray-900']"
                          >Edit<span class="sr-only">, {{ datum.teachers?.user?.name }}</span></a
                        >
                      </MenuItem>
                    </MenuItems>
                  </transition>
                </Menu>
              </div>
              <dl class="-my-3 divide-y divide-gray-100 px-6 py-4 text-sm leading-6">
                <!-- <div class="flex justify-between gap-x-4 py-3">
                  <dt class="text-gray-500">Admission Number</dt>
                  <dd class="text-gray-700">
                    <time :datetime="datum.created_at">{{ datum.created_at }}</time>
                  </dd>
                </div> -->
                <div class="flex justify-between gap-x-4 py-3">
                  <dt class="text-gray-500">Class</dt>
                  <dd class="text-gray-700">
                    <time :datetime="datum.created_at">{{ datum.schoolclass.name }}</time>
                  </dd>
                </div>
                <div class="flex justify-between gap-x-4 py-3">
                  <dt class="text-gray-500">Email</dt>
                  <dd class="flex items-start gap-x-2">
                    <div class="font-medium text-gray-900">{{ datum.teachers.user.email }}</div>

                    <!-- <div :class="[statuses[client.lastInvoice.status], 'rounded-md py-1 px-2 text-xs font-medium ring-1 ring-inset']">{{ client.lastInvoice.status }}</div> -->
                  </dd>
                </div>
                <!-- ours -->
                <div class="flex justify-center mt-3">
                  <ProfileChat :owner="datum.teachers" :owner_type="'teachers'" />
                </div>
                <!-- ours -->
              </dl>
            </li>
          </ul>

</div>
</div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import { CalendarDaysIcon, CreditCardIcon, UserCircleIcon,EllipsisHorizontalIcon } from '@heroicons/vue/20/solid'
import { Dialog, DialogPanel, Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue'

import ProfileChat from '@/Components/Provehub/ProfileChat.vue';

const props = defineProps({
    'data': Object,
})
</script>
