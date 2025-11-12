<script setup>
import { Link,usePage } from '@inertiajs/vue3';
import { computed, onMounted, onUnmounted, ref, } from 'vue';

import { ChevronRightIcon, MagnifyingGlassCircleIcon, MagnifyingGlassIcon } from '@heroicons/vue/20/solid'

const props = defineProps({
  'states': Object,
})

const getMarketsState = ref([]);
let loadingMarket = false;
onMounted(async () => {
  try {
        loadingMarket = true;
        const c = route('extra.get.cities',{ stateId: props.states.id });
        const response = await axios.get(c);
        if (response.status === 200) {
          getMarketsState.value = response.data;
        } else {
          // handle error
        }
      } catch (error) {
        // handle error
      }finally {
        loadingMarket = false;
      }

    });

 
const searchState = ref('');

const filteredItemsState = computed(() => {
  const searchTerm = searchState.value.trim().toLowerCase();
  return getMarketsState.value.filter((item) => {
    return (
      item.name.toLowerCase().includes(searchTerm) 
      // ||
      // item.description.toLowerCase().includes(searchTerm)
    );
  });
});


</script>

<template>  
<div>
  
  <div class="bg-gray-100 rounded-xl shadow-md overflow-hidden w-full">
<div class="grid gap-4 gap-y-0 grid-cols-1 md:grid-cols-2">
    
    <div class="flex p-2">
        <h2><Link :href="route('location.all', {country_id: $page.props.site.ccc.id, state_id: props.states.id, city_id: 0, location_name: props.states.name})">All {{ props.states.name }} </Link> </h2> <p class="text-gray-500 ml-2 shrink-0"> <span>&CenterDot;</span>  1 345 455 ads </p>
    </div>
    <div class="">
        <div class="relative">
            <div class="">
              <MagnifyingGlassCircleIcon class="h-5 w-5 text-gray-400 absolute z-20 cursor-pointer top-[18px] left-4" aria-hidden="true" />
            <input @input="searchState = $event.target.value.trim()"
      class="relative text-sm leading-none text-gray-600 bg-white rounded lg:max-w-[452px] w-full px-10 py-4 border-transparent focus:border-transparent focus:ring-0"
      type="text"
      name=""
      placeholder="Find city..."
    />
          </div>
          </div>
    </div>
</div>


  <div class="md:flex h-96 overflow-y-auto">
    
    <div class="p-6">
      
        <div class="overflow-hidden">
          
            <div class="grid gap-12 gap-y-0 grid-cols-1 md:grid-cols-3">
                <!-- cols -->
                
            <div v-for="(item, index) in filteredItemsState" :key="index"
          class="flex flex-col divide-y divide-gray-200 border border-gray-200 text-sm font-medium text-gray-500 bg-white "
        >
       
        <div>
          <Link :href="route('location.all', {country_id: $page.props.site.ccc.id, state_id: props.states.id, city_id: item.id, location_name: item.name})" class="flex justify-between items-center px-6 py-3" @click.prevent="closeModalState">
            <span class="hover:text-indigo-900 transition-all duration-300 ease-in-out shrink-0"> {{ item.name }}</span> <p class="text-gray-500 shrink-0"> <span>&CenterDot;</span></p>
            <ChevronRightIcon  class="h-5 w-5" aria-hidden="true" />
          </Link>
        </div>
        </div>
        
                <!-- cols -->
                
            </div>
        </div>
    </div>
  </div>
</div>



    </div>


    
</template>
