<template>
  <swiper 
    :navigation="true" 
    :loop="true"
    :effect="'fade'"
    :spaceBetween="30"
    :centeredSlides="true"
    :autoplay="{
      delay: 7500,
      disableOnInteraction: false,
    }"
    :pagination="{
        type: 'progressbar',
      }"
     :modules="modules" 
     class="mySwiper">
    <swiper-slide v-for="slide in props.photos" :key="slide.id">
      
      <div class="relative h-[300px] sm:h-[42rem] overflow-hidden ">
    <div class="mb-5 grid grid-cols-4 justify-items-center gap-3">
      <div class="absolute inset-0 transition-opacity duration-1000">
    
    <!-- Background Image -->
    <img :src="slide.img" class=" w-full object-cover object-center bg-fixed">

    <!-- Transparent Dark Overlay -->
    <div class="absolute inset-0 bg-black opacity-50"></div>
  </div>
  </div>

    <div class="absolute inset-0 flex items-center justify-center">
      <!-- Add your search box code here -->
      <div class="relative mt-4">
        <div class=" flex flex-col lg:flex-row">
			<!--Left Col-->
			<div class="flex flex-col w-full justify-center text-center lg:text-left ">

        <div class="flex flex-col justify-center items-center text-center">
  <h3 data-aos="fade-down" data-aos-once="true" data-aos-delay="300" class="my-4 text-2xl sm:text-5xl font-bold leading-tight text-darken">
    <span class="text-yellow-50">
      Welcome to <br>
      <span class="before:block before:absolute before:-inset-1 before:-skew-y-3 before:bg-green-600 relative inline-block">
        <span class="relative text-white">Zenith IntelliScore</span>
      </span>
    </span>
  </h3>

  <!-- No need for <br> as flex layout controls spacing -->
  <h3 data-aos="fade-down" data-aos-once="true" data-aos-delay="300" class="my-4 text-2xl font-bold leading-tight text-darken">
    <span class="text-yellow-50">Arise! We are the key electorate of Nigeria.
</span>

        
  </h3>

  <h3 class="my-4 text-2xl font-bold leading-tight text-darken">
  <div class="relative inline-grid grid-cols-1 grid-rows-1 gap-12 overflow-hidden text-yellow-50">
    
    <span class="animate-word col-span-full row-span-full">#AwakenNigeria</span>
    <span class="animate-word animate-word-delay-1 col-span-full row-span-full">#StopTheHunger</span>
    <span class="animate-word animate-word-delay-2 col-span-full row-span-full">#EconomicAwakening</span>
  </div>
</h3>

</div>



<!-- <AdmissionButton /> -->


        <main>
      
    </main>
    
		
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
      </div>

      </div>
    </div>
  </div>
  </swiper-slide>
  </swiper>


  
</template>

<script setup lang="js">
// import { ref, watchEffect, onUnmounted } from 'vue';

import AOS from 'aos';
import 'aos/dist/aos.css'; 

import { Swiper, SwiperSlide } from 'swiper/vue';

import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';
import 'swiper/css/effect-fade';

import { Navigation, Pagination, EffectFade, Autoplay } from 'swiper/modules';

// import AdmissionButton from '@/Components/Buttons/AdmissionButton.vue';

const props = defineProps({
    'photos': Object,
})

const modules = [Navigation,Pagination,EffectFade,Autoplay];

AOS.init();

</script>

<style scoped>
@keyframes word {
  0% {
    transform: translateY(100%);
  }
  15% {
    transform: translateY(-10%);
    animation-timing-function: ease-out;
  }
  20% {
    transform: translateY(0);
  }
  40%,
  100% {
    transform: translateY(-110%);
  }
}

.animate-word {
  animation: word 9s infinite;
}
.animate-word-delay-1 {
  animation: word 9s infinite;
  animation-delay: -3s;
}
.animate-word-delay-2 {
  animation: word 9s infinite;
  animation-delay: -6s;
}
</style>