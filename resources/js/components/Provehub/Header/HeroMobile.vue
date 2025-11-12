<template>
  <div class="bg-white px-4">
      <div class="mx-auto max-w-7xl py-5 sm:px-6 sm:py-10 lg:px-8">
        <div class="relative isolate overflow-hidden bg-gray-900 px-6 py-24 text-center shadow-2xl rounded-xl sm:rounded-3xl sm:px-16">
          <h2 class="mx-auto max-w-2xl text-3xl font-bold tracking-tight text-white sm:text-4xl">Boost your productivity today.</h2>
          <p class="mx-auto mt-6 max-w-xl text-lg leading-8 text-gray-300">Incididunt sint fugiat pariatur cupidatat consectetur sit cillum anim id veniam aliqua proident excepteur commodo do ea.</p>
          <div class="mt-10 flex items-center justify-center gap-x-6">
            <a href="#" class="rounded-md bg-white px-3.5 py-2.5 text-sm font-semibold text-gray-900 shadow-sm hover:bg-gray-100 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white">Get started</a>
            <a href="#" class="text-sm font-semibold leading-6 text-white">Learn more <span aria-hidden="true">→</span></a>
          </div>
          <svg viewBox="0 0 1024 1024" class="absolute left-1/2 top-1/2 -z-10 h-[64rem] w-[64rem] -translate-x-1/2 [mask-image:radial-gradient(closest-side,white,transparent)]" aria-hidden="true">
            <circle cx="512" cy="512" r="512" fill="url(#827591b1-ce8c-4110-b064-7cb85a0b1217)" fill-opacity="0.7" />
            <defs>
              <radialGradient id="827591b1-ce8c-4110-b064-7cb85a0b1217">
                <stop stop-color="#7775D6" />
                <stop offset="1" stop-color="#E935C1" />
              </radialGradient>
            </defs>
          </svg>
        </div>
      </div>
    </div>
</template>

<script setup>
import { ref, watchEffect, computed } from 'vue';
// import NewSearchBar from '@/Components/NewSearchBar.vue';
import { Link } from '@inertiajs/vue3';
import Modal from '@/Components/Modal.vue';


const confirmingSelectMarket = ref(false);
const confirmMarket = () => {
  confirmingSelectMarket.value = true;
    fetchMarkets(2);
};

const closeModal = () => {
  confirmingSelectMarket.value = false;
};

const getMarkets = ref([]);
const fetchMarkets = async (mark) => {
  try {
    const m = route('extra.get.locations');
    const response = await axios.get(m);
    getMarkets.value = response.data;
  } catch (error) {
    console.error(error);
  }
};
 
const search = ref('');

const filteredItems = computed(() => {
  const searchTerm = search.value.trim().toLowerCase();
  return getMarkets.value.filter((item) => {
    return (
      item.name.toLowerCase().includes(searchTerm) 
      // ||
      // item.description.toLowerCase().includes(searchTerm)
    );
  });
});

const slides = [
  { image: 'http://127.0.0.1:8000/storage/slider/1.png' },
  { image: 'http://127.0.0.1:8000/storage/slider/3.png' },
  { image: 'http://127.0.0.1:8000/storage/slider/4.png' },
  { image: 'http://127.0.0.1:8000/storage/slider/6.png' },
  { image: 'http://127.0.0.1:8000/storage/slider/5.png' },
  ];

const currentSlide = ref(0);

watchEffect(() => {
  const interval = setInterval(() => {
    currentSlide.value = (currentSlide.value + 1) % slides.length;
  }, 5000);

  return () => {
    clearInterval(interval);
  };
});
</script>

<style scoped>
</style>

    