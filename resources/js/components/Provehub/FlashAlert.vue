<template>
    <div>
      <!-- alert -->
      <Transition enter-active-class="transition duration-500 ease-in" enter-from-class="opacity-0"
            enter-to-class="opacity-100" leave-active-class="transition duration-500 ease-in"
            leave-from-class="opacity-100" leave-to-class="opacity-0">
            <div class="flex justify-center">
                <span v-if="showSuccessMessage"
                    class="inline-flex items-center justify-center rounded-full bg-emerald-100 px-2.5 py-0.5 text-emerald-700 absolute">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="-ml-1 mr-1.5 h-4 w-4">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p class="whitespace-nowrap text-sm">{{ flashSuccess }}</p>
                </span>
                <span v-if="showErrorMessage"
                    class="inline-flex items-center justify-center rounded-full bg-red-100 px-2.5 py-0.5 text-red-700 absolute">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    <p class="whitespace-nowrap text-sm">{{ flashError }}</p>
                </span>
            </div>
        </Transition>
        <!-- alert -->
    </div>
  </template>
  
  <script setup>
  import { Link, usePage} from '@inertiajs/vue3';
  import { watchEffect,ref } from 'vue';
  import { ExclamationTriangleIcon } from '@heroicons/vue/20/solid'

  const page = usePage()

    const flashSuccess = ref(page.props.flash.success)
    const flashError = ref(page.props.flash.error)

    const showSuccessMessage = ref(!!flashSuccess.value)
    const showErrorMessage = ref(!!flashError.value)

    watchEffect(() => {
        flashSuccess.value = page.props.flash.success
        flashError.value = page.props.flash.error
        showSuccessMessage.value = !!flashSuccess.value
        showErrorMessage.value = !!flashError.value
        if (flashSuccess.value) {
            setTimeout(() => {
                showSuccessMessage.value = false
            }, 15000)
        }
        if (flashError.value) {
            setTimeout(() => {
                showErrorMessage.value = false
            }, 15000)
        }
    })



  </script>