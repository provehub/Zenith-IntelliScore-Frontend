<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link,usePage } from '@inertiajs/vue3';
import { computed, onMounted, onUnmounted, ref, } from 'vue'; 
import Modal from '@/Components/Modal.vue';

const page = usePage();
const mm = computed(() => {
  return page.props.value.flash.market?.id || 0;
});

const opensearch = ref(false);
const closeOnEscape = (e) => {
    if (opensearch.value && e.key === 'Escape') {
      opensearch.value = false;
    }
};
onMounted(() => document.addEventListener('keydown', closeOnEscape));
onUnmounted(() => document.removeEventListener('keydown', closeOnEscape));

const closeSearch = () => {
      opensearch.value = false;
    };

const form = ref({
      q: '',
      market_id: '',
    });
    const results = ref([]);

    const submitForm = async () => {
      if (form.value.q.length >= 3) {
        const searchResults = await axios.post(route('search'), 
        { 
          q: form.value.q, 
          market_id: form.value.mm, 
        });
        opensearch.value = true;
        results.value = searchResults.data;

      }
    };


    // trial

    const searchWrapper = ref(null);

const handleClickOutside = (e) => {
  if (searchWrapper.value && !searchWrapper.value.contains(e.target)) {
    opensearch.value = false;
  }
};

onMounted(() => {
  document.addEventListener('mousedown', handleClickOutside);
});

onUnmounted(() => {
  document.removeEventListener('mousedown', handleClickOutside);
});
</script>
<script>
// import SelectMarket from '@/Components/UI/SelectMarket.vue'
</script> 


<template>  


    <main>

    <!-- new search -->
<div class=" py-4">
      <!-- component -->
<div class="">
        <div class="">
          <!-- absolute -->
            <div class="">
               <!-- absolute -->
                <div class="bg-white shadow-md rounded-lg px-3 py-2 mb-4 ">
                    <div class="flex items-center rounded-md">
                        <div class="relative flex items-center rounded-lg overflow-hidden w-full sm:w-80 md:max-w-sm lg:w-[30rem]">
                            <div class="grid place-items-center text-gray-300 " >
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>

                            <div v-show="opensearch" class="fixed inset-0 -z-40" @click="opensearch = false"></div>

                            <form>
                              <input v-model="form.q" @input="submitForm"
                            class="lg:w-96 sm:w-fit outline-none text-sm pr-2 leading-none text-gray-600 rounded border-transparent focus:border-transparent focus:ring-0"
                            type="text"
                            placeholder="Search something..." /> 
                            <input type="hidden" v-model="market_id">
                            </form>
                            

                        </div>
                    </div>
                    <!-- here -->
                    <div ref="searchWrapper">
                    <div v-show="opensearch" class="absolute bg-white shadow-md rounded-lg py-1 px-1 mt-3 w-fit sm:w-80 md:max-w-sm lg:w-[30rem]">
                    <div class="text-sm overflow-y-scroll h-[200px] z-20" >
                        <div class="flex justify-start text-gray-700 hover:text-blue-400 hover:bg-blue-100 rounded-md px-2 py-2 " v-for="result in results" :key="result.id">
                            <span class="bg-gray-400 h-2 w-2 m-2 rounded-full"></span>
                            <div class="flex-grow font-medium px-2">
                              <Link :href="'/listing?searched=' + form.q">
                               {{ result.name }}
                              </Link>
                              </div>
                            <!-- <div class="text-sm font-normal text-gray-500 tracking-wide">in Vehicle category</div> -->
                        </div>
                    </div>
                  </div></div>

                </div>
            </div>
        </div>
    </div>
    </div>
    <!-- new search -->
    </main>

  
</template>
