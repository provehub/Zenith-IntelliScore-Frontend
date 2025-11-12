<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
import { onMounted, onUnmounted, ref  } from 'vue';
const isVisible = ref(false);

const closeOnEscape = (e) => {
    if (isVisible.value && e.key === 'Escape') {
        isVisible.value = false;
    }
};
onMounted(() => document.addEventListener('keydown', closeOnEscape));
onUnmounted(() => document.removeEventListener('keydown', closeOnEscape));

defineProps([
    'message',
    'categories',
])

</script>

<template>  
  <!-- Category -->
  <div class="max-w-screen-xl px-4 py-16 sm:px-6 lg:px-8">
    <div class="grid grid-cols-1 gap-y-8 lg:grid-cols-2 lg:items-center lg:gap-x-16">
      <div class="mx-auto max-w-lg text-center lg:mx-0 lg:text-left">
        <h2 class="text-3xl font-bold sm:text-4xl">
            
            Filter by category
</h2>

        <p class="mt-4 text-gray-600">
          The category section of our listing classified website offers a wide range of options for users to easily find the products or services they are looking for. From popular categories such as vehicles, real estate, and electronics, to niche categories like pets, sporting goods, and arts & crafts, we have it all.
        </p>

        <Link
          class="mt-8 inline-flex items-center rounded border border-indigo-600 bg-indigo-600 px-8 py-3 text-white hover:bg-transparent hover:text-indigo-600 focus:outline-none focus:ring active:text-indigo-500"
          href="/register"
        >
          <span class="text-sm font-medium"> Post Ad </span>

          <svg
            class="ml-3 h-5 w-5"
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M17 8l4 4m0 0l-4 4m4-4H3"
            />
          </svg>
        </Link>
      </div>

      <div class="grid grid-cols-2 gap-4 sm:grid-cols-3">
        <!--  -->
        <div v-for="category in categories" :key="category.id">
        <Link
          class="block rounded-xl border border-gray-100 p-4 shadow-sm hover:border-gray-200 hover:ring-1 hover:ring-gray-200 focus:outline-none focus:ring"
          :href="'/listing?category_id[id]=' + category.id"
        >
          <span class="inline-block rounded-lg bg-gray-50 p-3">
            <img :src="category.image" class="h-6 w-6">
          </span>

          <h2 class="mt-2 font-bold">{{ category.name }}</h2>

          <p class="hidden sm:mt-1 sm:block sm:text-sm sm:text-gray-600">
            {{ category.description }}
          </p>
        </Link>
        </div>

      </div>
    </div>
  </div>
    <!-- Category -->
</template>
