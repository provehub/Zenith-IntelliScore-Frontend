<template>
  <swiper 
    :navigation="true" 
    :loop="true"
    :effect="'fade'"
    :spaceBetween="30"
    :centeredSlides="true"
    :autoplay="{
      delay: 7500,
      disableOnInteraction: true,
    }"
    :pagination="{ type: 'progressbar' }"
    :modules="modules" 
    class="mySwiper "
  >
    <swiper-slide v-for="slide in props.photos" :key="slide.id">
      <div class="relative h-[300px] sm:h-[32rem] overflow-hidden">
        <div class="absolute inset-0 transition-opacity duration-1000">
          <img 
            :src="slide.img" 
            class="w-full h-full object-cover object-center bg-fixed" 
            alt="Slide Image"
          />
          <div class="absolute inset-0 bg-black opacity-50"></div>
        </div>

        <div class="absolute inset-0 flex items-center justify-center">
          <div class="relative px-4 sm:px-8 w-full max-w-screen-lg mx-auto text-center sm:text-left">
            <div class="flex flex-col items-center space-y-4 sm:space-y-6">
              <!-- Main Heading -->
              <h3 
                data-aos="fade-down" 
                data-aos-once="true" 
                data-aos-delay="300" 
                class="text-xl sm:text-4xl md:text-5xl font-bold text-yellow-50 leading-tight"
              >
                Welcome to
                <span class="relative inline-block">
                  <span class="before:block before:absolute before:-inset-1 before:-skew-y-3 before:bg-blue-600 relative">
                    <span class="relative text-white">Zenith IntelliScore</span>
                  </span>
                </span>
              </h3>

              <!-- Subheading -->
              <h3 
                data-aos="fade-down" 
                data-aos-once="true" 
                data-aos-delay="300" 
                class="text-base sm:text-xl md:text-2xl font-semibold text-yellow-50"
              >
                Find. Connect. Secure Your Dream Property.
              </h3>

              <!-- Location & Search Bars -->
              <div class="w-full max-w-xl space-y-4 flex flex-col items-center justify-center">
                <LocationBar />
                  <SearchBar />
              
              </div>

              <!-- Animated Hashtags -->
              <div class="text-yellow-50 mt-4">
                <div class="relative inline-grid grid-cols-1 grid-rows-1 gap-8 sm:gap-12 overflow-hidden text-lg sm:text-2xl">
                  <span class="animate-word col-span-full row-span-full">#FindRent</span>
                  <span class="animate-word animate-word-delay-1 col-span-full row-span-full">#FindNewBuilds</span>
                  <span class="animate-word animate-word-delay-2 col-span-full row-span-full">#FindSpace</span>
                </div>
              </div>
            </div>

            <!-- Gradient background SVG -->
            <div class="absolute inset-x-0 top-[-12rem] sm:top-[-20rem] -z-40 transform-gpu overflow-hidden blur-3xl">
              <svg 
                class="relative left-1/2 -z-10 h-[21rem] sm:h-[42rem] -translate-x-1/2 rotate-[30deg]" 
                viewBox="0 0 1155 678" 
                fill="none" 
                xmlns="http://www.w3.org/2000/svg"
              >
                <path 
                  fill="url(#bgGradient)" 
                  fill-opacity=".3" 
                  d="M317.219 518.975L203.852 678 0 438.341..."
                />
                <defs>
                  <linearGradient id="bgGradient" x1="1155.49" x2="-78.208" y1=".177" y2="474.645" gradientUnits="userSpaceOnUse">
                    <stop stop-color="#9089FC" />
                    <stop offset="1" stop-color="#FF80B5" />
                  </linearGradient>
                </defs>
              </svg>
            </div>


            
          </div>
        </div>
      </div>
    </swiper-slide>
  </swiper>
</template>


<script setup lang="js">

import AOS from 'aos';
import 'aos/dist/aos.css'; 

import { Swiper, SwiperSlide } from 'swiper/vue';

import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';
import 'swiper/css/effect-fade';

import { Navigation, Pagination, EffectFade, Autoplay } from 'swiper/modules';

import SearchBar from '@/Components/SearchBar.vue';
import LocationBar from '@/Components/LocationBar.vue';

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