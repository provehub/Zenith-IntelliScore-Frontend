<script setup>
import { ref, computed } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';
import axios from 'axios';
import Modal from '@/Components/Modal.vue';
import LocationBarCity from '@/Components/LocationBarCity.vue';
import { ChevronRightIcon, ChevronLeftIcon, MagnifyingGlassCircleIcon, XMarkIcon } from '@heroicons/vue/20/solid';

// Modals
const confirmingSelectMarket = ref(false);
const confirmingSelectMarketState = ref(false);
const confirmingAddImages = ref(false);

// Data
const getMarkets = ref([]);
const getMarketsState = ref([]);
const dataFromButton = ref([]);
const search = ref('');
const searchState = ref('');

// Fetching States (reused)
const fetchStates = async (target) => {
  try {
    const url = route('extra.get.states', { countryId: 161 });
    const response = await axios.get(url);
    if (target === 'country') {
      getMarkets.value = response.data;
    } else {
      getMarketsState.value = response.data;
    }
  } catch (error) {
    console.error(error);
  }
};

// Show/hide modals
const confirmMarket = () => {
  confirmingSelectMarket.value = true;
  fetchStates('country');
};
const closeModal = () => confirmingSelectMarket.value = false;

const confirmMarketState = () => {
  confirmingSelectMarketState.value = true;
  fetchStates('state');
};
const closeModalState = () => confirmingSelectMarketState.value = false;

const confirmAddImages = (data) => {
  dataFromButton.value = data;
  confirmingAddImages.value = true;
};
const closeModalImages = () => confirmingAddImages.value = false;

// Filtering logic
const filteredItems = computed(() => {
  const term = search.value.trim().toLowerCase();
  return getMarkets.value.filter(item =>
    item.name.toLowerCase().includes(term)
  );
});

const filteredItemsState = computed(() => {
  const term = searchState.value.trim().toLowerCase();
  return getMarketsState.value.filter(item =>
    item.name.toLowerCase().includes(term)
  );
});
</script>

<template>
  <!-- Location Choose Button -->
  <div class="mb-3">
    <div class="flex w-fit items-center justify-center overflow-hidden rounded-full py-1.5 px-4 text-sm leading-6 ring-1 ring-white ring-inset text-white">
      <button @click="confirmMarket" class="text-indigo-50 font-semibold">
        {{ $page.props.flash.locationsall ? 'Find anything in ' + $page.props.flash.locationsall.location_name : 'Choose a Location' }}
        <span aria-hidden="true">&rarr;</span>
      </button>
    </div>
  </div>

  <!-- Modal: Choose Country -->
  <Modal :show="confirmingSelectMarket" @close="closeModal">
    <div class="bg-gray-100 rounded-xl shadow-md overflow-hidden w-full">
      <div class="flex items-center bg-gray-100">
      <button @click="closeModal" class="flex items-center text-sm text-gray-700">
        <XMarkIcon class="h-5 w-5 mr-2" /> Close
      </button>
    </div>
      <!-- Header -->
      <div class="grid gap-4 md:grid-cols-2 px-4 py-4">
        <div class="flex items-center space-x-2">
          <h2>
            <Link :href="route('location.all', {country_id: 161, state_id: 0, city_id: 0, location_name: 'Nigeria'})">
              All Nigeria
            </Link>
          </h2>
          <p class="text-gray-500 text-sm">&CenterDot; 1,345,455 ads</p>
        </div>
        <div class="relative">
          <MagnifyingGlassCircleIcon class="h-5 w-5 text-gray-400 absolute top-[18px] left-4 z-20" />
          <input
            v-model.trim="search"
            class="text-sm text-gray-600 bg-white rounded w-full lg:max-w-[452px] px-10 py-3 border border-gray-300 focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
            type="text"
            placeholder="Find state..."
          />
        </div>
      </div>

      <!-- State List -->
      <!-- State List -->
<div class="md:flex h-96 overflow-y-auto">
  <div class="p-6 w-full">
    <!-- No states found -->
    <div v-if="!filteredItems.length" class="text-center text-sm text-gray-500 py-6">
      No states found.
    </div>

    <!-- State list -->
    <div v-else class="grid gap-4 grid-cols-1 md:grid-cols-3">
      <div
        v-for="item in filteredItems"
        :key="item.id"
        class="flex flex-col border border-gray-200 bg-white divide-y text-sm text-gray-600 rounded"
      >
        <button
          class="flex justify-between items-center px-4 py-3 hover:bg-indigo-50 transition"
          @click="confirmAddImages(item)"
        >
          <span class="truncate">{{ item.name }}</span>
          <ChevronRightIcon class="h-5 w-5 text-gray-400" />
        </button>
      </div>
    </div>
  </div>
</div>

    </div>
  </Modal>

  <!-- Modal: Show Cities -->
  <Modal :show="confirmingAddImages" @close="closeModalImages">
    <div class="flex items-center bg-gray-100 p-4">
      <button @click="closeModalImages" class="flex items-center text-sm text-gray-700">
        <ChevronLeftIcon class="h-5 w-5 mr-2" /> Back
      </button>
    </div>
    <LocationBarCity :states="dataFromButton" />
  </Modal>
</template>
