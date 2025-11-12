<template>
  <div class="bg-white shadow sm:rounded-lg">
    <div class="px-4 py-5 sm:p-6">
      <!-- <h3 class="text-base font-semibold leading-6 text-gray-900">Payment method</h3> -->
      <div class="mt-5">
        <div v-for="quiz in props.datum" :key="quiz.id" class="rounded-md bg-gray-50 px-6 py-5 sm:flex sm:items-start sm:justify-between">
          <h4 class="sr-only">Visa</h4>
          <div class="sm:flex sm:items-start">
            
            <div class="mt-3 sm:ml-4 sm:mt-0">
              <div class="text-sm font-medium text-gray-900">{{ quiz.name }}</div>
              <div class="mt-1 text-sm text-gray-600 sm:flex sm:items-center">
                <div>{{ quiz.description }}</div>
                <!-- <span class="hidden sm:mx-2 sm:inline" aria-hidden="true">&middot;</span>
                <div class="mt-1 sm:mt-0">Last updated on 22 Aug 2017

                </div> -->
              </div>
            </div>
          </div>
          <div class="mt-4 sm:ml-6 sm:mt-0 sm:flex-shrink-0">
            <button type="button" class="inline-flex items-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">Take</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
const props = defineProps({
    datum: Object,
})

</script>