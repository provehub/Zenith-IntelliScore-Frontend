 <template>
  <!-- Featured section -->
  <section aria-labelledby="cause-heading">
    <div
      class="relative bg-gray-800 py-32 px-6 sm:py-40 sm:px-12 lg:px-16 bg-fixed bg-cover"
      :style="backgroundStyle">

            <!-- <div class="absolute inset-0 overflow-hidden">
              <img src="https://tailwindui.com/img/ecommerce-images/home-page-03-feature-section-full-width.jpg" alt="" class="h-full w-full object-cover object-center bg-fixed" />
            </div> -->
            <div aria-hidden="true" class="absolute inset-0 bg-gray-900 bg-opacity-60" />
            <div class="relative mx-auto flex max-w-3xl flex-col items-center text-center">
              <h2 id="cause-heading" class="text-3xl font-bold tracking-tight text-white sm:text-4xl">Why Choose Zenith IntelliScore?</h2>
              <p class="mt-3 text-xl text-white">Zenith IntelliScore isn’t just another property listing platform; we are revolutionizing real estate with transparency, security, and convenience.</p>


              
              <div class="flex gap-6">
              <button @click="open = true" class="mt-8 block w-full rounded-md border border-transparent bg-white py-3 px-8 text-base font-medium text-gray-900 hover:bg-gray-100 sm:w-auto">Register</button>
              <Link :href="route('login')"  class="mt-8 block w-full rounded-md border border-transparent bg-white py-3 px-8 text-base font-medium text-gray-900 hover:bg-gray-100 sm:w-auto">Log in</Link>
            </div>
            </div>
          </div>
        </section>


         <!-- Register Popup -->
    <TransitionRoot as="template" :show="open">
    <Dialog as="div" class="relative z-10" @close="open = false">
      <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0" enter-to="opacity-100" leave="ease-in duration-200" leave-from="opacity-100" leave-to="opacity-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" />
      </TransitionChild>

      <div class="fixed inset-0 z-10 overflow-y-auto">
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
          <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" enter-to="opacity-100 translate-y-0 sm:scale-100" leave="ease-in duration-200" leave-from="opacity-100 translate-y-0 sm:scale-100" leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
            <DialogPanel class="relative transform overflow-hidden rounded-lg bg-white px-4 pt-5 pb-4 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:p-6">
              <div class="absolute top-0 right-0 hidden pt-4 pr-4 sm:block">
                <button type="button" class="rounded-md bg-white text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2" @click="open = false">
                  <span class="sr-only">Close</span>
                  <XMarkIcon class="h-6 w-6" aria-hidden="true" />
                </button>
              </div>
              <div class="sm:flex sm:items-start">
                <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                  <ExclamationTriangleIcon class="h-6 w-6 text-red-600" aria-hidden="true" />
                </div>
                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                  <DialogTitle as="h3" class="text-lg font-medium leading-6 text-gray-900">Register to manage your ward or children</DialogTitle>
                  <div class="mt-2">
                    <p class="text-sm text-gray-500">Register as a Parent or login to continue.</p>
                  </div>
                </div>
              </div>
              <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
                <Link :href="route('admission')" class="inline-flex w-full justify-center rounded-md border border-transparent bg-red-600 px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 sm:ml-3 sm:w-auto sm:text-sm" >Register as a Parent</Link>
                <Link :href="route('login')" class="mt-3 inline-flex w-full justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-base font-medium text-gray-700 shadow-sm hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:mt-0 sm:w-auto sm:text-sm">Login to continue</Link>
              </div>
            </DialogPanel>
          </TransitionChild>
        </div>
      </div>
    </Dialog>
  </TransitionRoot>
    <!-- Register Popup -->
</template>

<script setup>
  import { Link,usePage } from '@inertiajs/vue3';
  
  import { ref,computed,onMounted } from 'vue';

  import { Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot } from '@headlessui/vue'
import { ExclamationTriangleIcon, XMarkIcon } from '@heroicons/vue/24/outline'
  
const page = usePage()
const open = ref(false)

const backgroundImage = ref('');

onMounted(() => {
  if (page.props.site.img_share.three) {
    backgroundImage.value = 'https://images.unsplash.com/photo-1618828665011-0abd973f7bb8?q=80&w=1932&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D';
    // backgroundImage.value = page.props.site.img_share.three;
  }
});

const backgroundStyle = computed(() => ({
  backgroundImage: `url(${backgroundImage.value})`
}));

  </script>