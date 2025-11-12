<script setup lang="js">
import { ref, onMounted, onUnmounted } from 'vue';
import { Link } from '@inertiajs/vue3';
import { MagnifyingGlassCircleIcon, MagnifyingGlassIcon } from '@heroicons/vue/20/solid';
import { ExclamationCircleIcon } from '@heroicons/vue/24/outline';
import axios from 'axios';

const opensearch = ref(false);
const form = ref({ q: '' });
const results = ref([]);
const loadingSearch = ref(false);
const searchWrapper = ref(null);

let debounceTimeout = null;

const submitForm = () => {
  opensearch.value = true;
  if (debounceTimeout) {
    clearTimeout(debounceTimeout);
  }
  debounceTimeout = setTimeout(async () => {
    const query = form.value.q.trim();
    if (query.length >= 2) {
      loadingSearch.value = true;
      try {
        const searchResults = await axios.post(route('search.home'), { q: query });
        results.value = searchResults.data;
      } catch (error) {
        console.error('Search error:', error);
      } finally {
        loadingSearch.value = false;
      }
    } else {
      results.value = [];
      loadingSearch.value = false;
    }
  }, 300);
};

const closeOnEscape = (e) => {
  if (opensearch.value && e.key === 'Escape') {
    opensearch.value = false;
  }
};

const handleClickOutside = (e) => {
  if (searchWrapper.value && !searchWrapper.value.contains(e.target)) {
    opensearch.value = false;
  }
};

onMounted(() => {
  document.addEventListener('keydown', closeOnEscape);
  document.addEventListener('mousedown', handleClickOutside);
});
onUnmounted(() => {
  document.removeEventListener('keydown', closeOnEscape);
  document.removeEventListener('mousedown', handleClickOutside);
});

const truncateText = (text, length = 30) => {
  if (!text) return '';
  return text.length > length ? text.substr(0, length) + '...' : text;
};


</script>

<template>
  <div class="flex items-center justify-between w-full">
    <!-- Search Box -->
    <div class="relative w-full">
      <div class="mt-1 flex rounded-md shadow-sm h-11 w-full">
        <div class="relative flex flex-grow items-stretch focus-within:z-10 w-full">
          <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
            <MagnifyingGlassCircleIcon class="h-5 w-5 text-gray-400" aria-hidden="true" />
          </div>
          <input 
            v-model.trim="form.q" 
            @input="submitForm" 
            type="text" 
            id="search" 
            autocomplete="off"
            class="block w-full rounded-none rounded-l-md border border-gray-300 pl-10 pr-4 focus:border-blue-500 focus:ring-blue-500 sm:text-sm text-gray-800" 
            placeholder="I am looking for..." 
          />
        </div>
        <button 
          type="button" 
          class="relative -ml-px inline-flex items-center justify-center rounded-r-md border border-gray-300 bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-500 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500"
        >
          <MagnifyingGlassIcon class="h-5 w-5 text-white" aria-hidden="true" />
        </button>
      </div>

      <!-- Search Results -->
       
      <div ref="searchWrapper" v-show="opensearch" class="absolute z-50 w-full mt-1">
        <div class="max-h-38 scroll-py-3 overflow-y-auto p-0 bg-white rounded-lg">
          <div v-if="loadingSearch" class="flex justify-center text-center mx-auto mb-4 bounce-loader">
            <div class="dot"></div>
            <div class="dot"></div>
            <div class="dot"></div>
          </div>

          <div v-for="item in results" :key="item.id" class="cursor-pointer hover:bg-indigo-50">
            <!-- {{ item }} -->
            <!-- For categories -->
            <Link v-if="item.labels === 'categories'" :href="route('index', { searched: item.name })" class="flex select-none rounded-xl p-3">
              <div class="ml-4 flex-auto">
                <p class="text-sm font-medium text-gray-700">{{ item.name }}</p>
              </div>
              <span class="ml-3 flex-none text-xs font-semibold text-gray-400">
                <kbd class="font-sans">{{ item.labels }}</kbd>
              </span>
            </Link>
            <!-- For listing -->
            <Link v-else-if="item.labels === 'listing'" :href="`${route('index', item.slug)}?phs=${form.q}`" class="flex select-none rounded-xl p-3 hover:bg-indigo-50">
              <div :class="['flex h-10 w-10 flex-none items-center justify-center rounded-lg', item.color]">
                <img :src="item.images[0].img" alt="profile" class="h-6 w-6" />
              </div>
              <div class="ml-4 flex-auto">
                <p class="text-sm font-medium text-gray-700">{{ item.name }}</p>
              </div>
              <span class="ml-3 flex-none text-xs font-semibold text-gray-400">
                <kbd class="font-sans">{{ item.labels }}</kbd>
              </span>
            </Link>
          </div>

          <div v-if="results.length !== 0" class="flex flex-wrap items-center bg-gray-50 py-2.5 px-4 text-xs text-gray-700">
            <Link :href="'/listing?searched=' + form.q" class="flex flex-wrap items-center">
              See all search for
              <span class="mx-1 flex h-5 w-5 items-center justify-center rounded border bg-white font-semibold sm:mx-2">{{ form.q }}</span>
            </Link>
          </div>
          
          <div v-if="results.length === 0 && !loadingSearch" class="py-4 px-6 text-center text-sm sm:px-14 bg-white border rounded-lg shadow">
            <ExclamationCircleIcon class="mx-auto h-6 w-6 text-gray-400" />
            <p class="mt-4 font-semibold text-gray-900">No results found</p>
            <p class="mt-2 text-gray-500">Try following the link below:</p>
            <div class="mx-auto text-center mt-2">
              <div class="mt-6 flex space-x-3 md:mt-0 md:ml-4 justify-center">
                <Link :href="'/listing'" type="button" class="inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-md font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                  See all properties
                </Link>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- End Search Results -->
    </div>
  </div>
</template>

<style scoped>
.bounce-loader {
  position: relative;
  height: 30px;
  width: 70px;
}
.bounce-loader .dot {
  position: absolute;
  bottom: 0;
  width: 10px;
  height: 10px;
  border-radius: 50%;
  animation: bounce 1s infinite;
}
.bounce-loader .dot:nth-child(1) {
  background: #1abc9c;
  left: 0;
  animation-delay: 0s;
}
.bounce-loader .dot:nth-child(2) {
  background: #3498db;
  left: 20px;
  animation-delay: 0.2s;
}
.bounce-loader .dot:nth-child(3) {
  background: #9b59b6;
  left: 40px;
  animation-delay: 0.4s;
}
@keyframes bounce {
  0% { transform: scale(1); opacity: 1; }
  50% { transform: scale(1.5); opacity: 0.5; }
  100% { transform: scale(1); opacity: 1; }
}
</style>
