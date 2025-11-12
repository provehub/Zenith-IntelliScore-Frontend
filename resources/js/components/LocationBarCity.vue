<script setup>
import { ref, computed, onMounted } from 'vue'
import { Link, usePage } from '@inertiajs/vue3'
import axios from 'axios'
import { ChevronRightIcon, MagnifyingGlassCircleIcon } from '@heroicons/vue/20/solid'

// Props
const props = defineProps({
  states: Object,
})

// Reactive state
const getMarketsState = ref([])
const searchState = ref('')
const loadingMarket = ref(false)

// Fetch markets on mount
onMounted(async () => {
  try {
    loadingMarket.value = true
    const url = route('extra.get.cities', { stateId: props.states.id })
    const response = await axios.get(url)

    if (response.status === 200) {
      getMarketsState.value = response.data
    } else {
      console.error('Failed to fetch cities')
    }
  } catch (error) {
    console.error('Error fetching cities:', error)
  } finally {
    loadingMarket.value = false
  }
})

// Optional: debounce (uncomment to use)
// import debounce from 'lodash.debounce'
// watch(searchState, debounce((val) => {}, 300))

// Computed filtered results
const filteredItemsState = computed(() => {
  const term = searchState.value.trim().toLowerCase()
  return getMarketsState.value.filter((item) =>
    item.name.toLowerCase().includes(term)
  )
})
</script>

<template>
  <div class="w-full">
    <!-- Top Section -->
    <div class="bg-gray-100 rounded-xl shadow-md overflow-hidden w-full">
      
      <div class="grid gap-4 gap-y-0 grid-cols-1 md:grid-cols-2 px-4 py-4">

        <!-- Title -->
        <div class="flex items-center space-x-2">
          <h2 class="text-base font-semibold text-gray-800">
            <Link
              :href="route('location.all', {
                country_id: 161,
                state_id: props.states.id,
                city_id: 0,
                location_name: props.states.name
              })"
            >
              All {{ props.states.name }}
            </Link>
          </h2>
          <p class="text-gray-500 text-sm">&CenterDot; 1,345,455 ads</p>
        </div>

        <!-- Search Input -->
        <div class="relative">
          <MagnifyingGlassCircleIcon class="h-5 w-5 text-gray-400 absolute top-3.5 left-4 z-10" />
          <input
            v-model.trim="searchState"
            type="text"
            class="w-full text-sm leading-none text-gray-600 bg-white rounded-lg lg:max-w-[452px] pl-10 pr-4 py-3 border border-gray-300 focus:border-blue-500 focus:ring-blue-500"
            placeholder="Find city..."
          />
        </div>
      </div>

      <!-- Loading state -->
      <div v-if="loadingMarket" class="text-center py-6 text-sm text-gray-500">
        Loading cities...
      </div>

      <!-- No results -->
      <div v-else-if="filteredItemsState.length === 0" class="text-center py-6 text-sm text-gray-500">
        No cities found.
      </div>

      <!-- City List -->
      <div v-else class="md:flex h-96 overflow-y-auto">
        <div class="p-4 w-full">
          <div class="grid gap-4 grid-cols-1 md:grid-cols-3">
            <div
              v-for="item in filteredItemsState"
              :key="item.id"
              class="flex flex-col divide-y divide-gray-200 border border-gray-200 text-sm font-medium text-gray-600 bg-white rounded-lg overflow-hidden">
              <Link :href="route('location.all', {
                  country_id: 161,
                  state_id: props.states.id,
                  city_id: item.id,
                  location_name: item.name
                })"
                class="flex justify-between items-center px-4 py-3 hover:bg-indigo-50 transition-all duration-200 ease-in-out">
                <span class="truncate">{{ item.name }}</span>
                <ChevronRightIcon class="h-5 w-5 text-gray-400" />
              </Link>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
