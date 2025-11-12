<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Search2 from '@/Components/Search2.vue';
import { Link } from '@inertiajs/vue3';
import { computed, onMounted, onUnmounted, ref } from 'vue'; 
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
    const m = route('extra.get.markets');
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


</script>
<script>
// import SelectMarket from '@/Components/UI/SelectMarket.vue'
</script>


<template>   
<div class="md:block hidden isolate lg:px-8 bg-gradient-to-r from-indigo-700 to-purple-500">

  <div>
		<div class="max-w-screen-xl px-8 mx-auto flex flex-col lg:flex-row items-start">
			<!--Left Col-->
			<div class="flex flex-col w-full lg:w-6/12 justify-center lg:pt-24 items-start text-center lg:text-left mb-5 md:mb-0">

        <h1 data-aos="fade-right" data-aos-once="true" class="mt-20 my-4 text-5xl font-bold leading-tight text-darken">
					<span class="text-yellow-50">Welcome to<br> {{ $page.props.site.site_name }}</span>
				</h1>

        
      <div class="relative px-2 mt-4 max-w-sm">
        <div>
              <div class="flex w-fit items-center justify-center overflow-hidden rounded-full py-1.5 px-4 text-sm leading-6 ring-1 ring-white ring-inset text-white">
                <button @click="confirmMarket" class="text-gray-20 font-semibold text-indigo-50">
  {{ $page.props.flash.market ? 'Find anything in ' + $page.props.flash.market.name : 'Click to Choose a Market' }}
  <span aria-hidden="true">&rarr;</span> 
</button>

              </div>

              
    <Search2 />
    
        </div>
      </div>
    
		
        <!-- sear -->
        <div class="absolute inset-x-0 top-[-10rem] -z-40 transform-gpu overflow-hidden blur-3xl sm:top-[-20rem]">
      <svg class="relative left-[calc(50%-11rem)] -z-10 h-[21.1875rem] max-w-none -translate-x-1/2 rotate-[30deg] sm:left-[calc(50%-30rem)] sm:h-[42.375rem]" viewBox="0 0 1155 678" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path fill="url(#45de2b6b-92d5-4d68-a6a0-9b9b2abad533)" fill-opacity=".3" d="M317.219 518.975L203.852 678 0 438.341l317.219 80.634 204.172-286.402c1.307 132.337 45.083 346.658 209.733 145.248C936.936 126.058 882.053-94.234 1031.02 41.331c119.18 108.451 130.68 295.337 121.53 375.223L855 299l21.173 362.054-558.954-142.079z" />
        <defs>
          <linearGradient id="45de2b6b-92d5-4d68-a6a0-9b9b2abad533" x1="1155.49" x2="-78.208" y1=".177" y2="474.645" gradientUnits="userSpaceOnUse">
            <stop stop-color="#9089FC"></stop>
            <stop offset="1" stop-color="#FF80B5"></stop>
          </linearGradient>
        </defs>
      </svg>
    </div>

    
        <!-- sear -->
				
			</div>
			<!--Right Col-->
     

			<div class="w-full lg:w-6/12 lg:-mt-10 relative" id="girl">
				<img data-aos="fade-up" data-aos-once="true" class="w-10/12 mx-auto 2xl:-mb-20" src="https://jafx.net/cdn/girl0.png" />
				<!-- calendar -->
				<div data-aos="fade-up" data-aos-delay="300" data-aos-once="true" class="absolute top-20 -left-6 sm:top-32 sm:left-10 md:top-40 md:left-16 lg:-left-0 lg:top-52 floating-4">
					<img class="rounded-lg h-12 sm:h-16" src="https://jafx.net/cdn/shop2.png">
				</div>
				<!-- red -->
				
				<!-- ux class -->
				<div data-aos="fade-up" data-aos-delay="500" data-aos-once="true" class="absolute bottom-14 -left-4 sm:left-2 sm:bottom-20 lg:bottom-24 lg:-left-4 floating">
					<img class="rounded-lg h-12 sm:h-28" src="https://jafx.net/cdn/connect.png" alt="">
				</div>
				<!-- congrats -->
				<div data-aos="fade-up" data-aos-delay="600" data-aos-once="true" class="absolute bottom-20 md:bottom-48 lg:bottom-52 -right-6 lg:right-8 floating-4">
					<img class=" rounded-lg h-12 sm:h-16" src="https://jafx.net/cdn/more.png" alt="">
				</div>
			</div>



		</div>
		
	</div>

    
   

  </div>
  
  <div class="text-white -mt-14 sm:-mt-24 lg:-mt-36 z-40 md:block hidden">
			<svg class="xl:h-60 xl:w-full" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
				<path d="M600,112.77C268.63,112.77,0,65.52,0,7.23V120H1200V7.23C1200,65.52,931.37,112.77,600,112.77Z" fill="currentColor"></path>
			</svg>
			<div class="bg-white w-full h-20 -mt-px"></div>
		</div>
    
  <!-- Modal -->
  <Modal :show="confirmingSelectMarket" @close="closeModal">
    <div class="bg-gray-100 rounded-xl shadow-md overflow-hidden w-full">
<div class="grid gap-4 gap-y-0 grid-cols-1 md:grid-cols-2">
    
    <div class="flex p-2">
        <h2>World Main Market </h2> <p class="text-gray-500 ml-2 shrink-0"> <span>&CenterDot;</span>  1 345 455 ads </p>
    </div>
    <div class="">
        <div class="relative">
            <div class="">
            <svg
              class="absolute z-20 cursor-pointer top-[18px] left-4"
              width="16"
              height="16"
              viewBox="0 0 16 16"
              fill="none"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                d="M14.2716 13.1684L11.3313 10.2281C12.0391 9.28574 12.4213 8.13865 12.42 6.96C12.42 3.94938 9.97063 1.5 6.96 1.5C3.94938 1.5 1.5 3.94938 1.5 6.96C1.5 9.97063 3.94938 12.42 6.96 12.42C8.13865 12.4213 9.28574 12.0391 10.2281 11.3313L13.1684 14.2716C13.3173 14.4046 13.5114 14.4756 13.711 14.47C13.9105 14.4645 14.1004 14.3827 14.2415 14.2415C14.3827 14.1004 14.4645 13.9105 14.47 13.711C14.4756 13.5114 14.4046 13.3173 14.2716 13.1684ZM3.06 6.96C3.06 6.18865 3.28873 5.43463 3.71727 4.79328C4.14581 4.15192 4.7549 3.65205 5.46754 3.35687C6.18017 3.06169 6.96433 2.98446 7.72085 3.13494C8.47738 3.28542 9.17229 3.65686 9.71772 4.20228C10.2631 4.74771 10.6346 5.44262 10.7851 6.19915C10.9355 6.95567 10.8583 7.73983 10.5631 8.45247C10.268 9.1651 9.76808 9.77419 9.12673 10.2027C8.48537 10.6313 7.73135 10.86 6.96 10.86C5.92604 10.8588 4.93478 10.4475 4.20365 9.71635C3.47253 8.98522 3.06124 7.99396 3.06 6.96Z"
                fill="#4B5563"
              />
            </svg>
            <input @input="search = $event.target.value.trim()"
      class="relative text-sm leading-none text-gray-600 bg-white rounded lg:max-w-[452px] w-full px-10 py-4 border-transparent focus:border-transparent focus:ring-0"
      type="text"
      name=""
      placeholder="Find a market..."
    />
          </div>
          </div>
    </div>
</div>
  <div class="md:flex h-96 overflow-y-auto">
    <div class="p-4">
        <div class="overflow-hidden">
            <div class="grid gap-4 gap-y-0 grid-cols-1 md:grid-cols-3">
                <!-- cols -->
            <div v-for="(item, index) in filteredItems" :key="index"
          class="flex flex-col divide-y divide-gray-200 border border-gray-200 text-sm font-medium text-gray-500 bg-white "
        >
        <div>
          <Link :href="route('market', item.id)" class="flex justify-between items-center px-6 py-3" @click.prevent="closeModal">
            <span class="hover:text-indigo-900 transition-all duration-300 ease-in-out shrink-0"> {{ item.name }}</span> <p class="text-gray-500 shrink-0"> <span>&CenterDot;</span></p>
            <svg
              xmlns="http://www.w3.org/2000/svg"
              class="h-5 w-5"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M9 5l7 7-7 7"
              />
            </svg>
          </Link>
        </div>
        </div>
        
                <!-- cols -->
                
            </div>
        </div>
    </div>
  </div>
</div>
  </Modal>
  <!-- Modal -->
  
</template>
