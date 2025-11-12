<template>
    <div class="sm:flex items-center sm:space-x-8 px-10">
			<div data-aos="fade-right" class="sm:w-1/2 relative">
				<div class="bg-green-500 rounded-full absolute w-12 h-12 z-0 -left-4 -top-3 animate-pulse"></div>
				<h1 class="font-semibold text-3xl relative z-50 text-darken lg:pr-10">The Awaken Economic Community (AEC)<br> <span class="text-green-500">A Movement FOR US, BY US.</span></h1>
				<p class="py-5 lg:pr-32">It is common knowledge that Nollywood and Afrobeats are two Global homegrown industries that was the creation of hardworking and committed professionals.<br>
The Zenith IntelliScore believes that as Nigerians, united in thought and compassion, we can feed the most hungry and vulnerable among us.<br>
We estimate that N2,500 can feed a person with Pap and Akara in the morning, Swallow in the afternoon and a fruit in the evening.

</p>
				
				<div class="mt-8 space-y-5">
                    <DonutOne />
                </div>
				<div class="mt-8 space-y-5">
                    <TableOne />
                </div>
				
			</div>
			<div data-aos="fade-left" class="sm:w-1/2 relative mt-10 sm:mt-0">
				<div style="background: #22c55e;" class="floating w-24 h-24 absolute rounded-lg z-0 -top-3 -left-3"></div>
				<img class="rounded-xl z-40 relative" :src="$page.props.site.img_share.ten" alt="">
				<button class="bg-white w-14 h-14 rounded-full flex items-center justify-center absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 focus:outline-none transform transition hover:scale-110 duration-300 ease-in-out z-50">
					<svg class="w-5 h-5 ml-1" viewBox="0 0 24 28" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M22.5751 12.8097C23.2212 13.1983 23.2212 14.135 22.5751 14.5236L1.51538 27.1891C0.848878 27.5899 5.91205e-07 27.1099 6.25202e-07 26.3321L1.73245e-06 1.00123C1.76645e-06 0.223477 0.848877 -0.256572 1.51538 0.14427L22.5751 12.8097Z" fill="#22c55e"/>
					</svg>
				</button>
				<div class="bg-yellow-500 w-40 h-40 floating absolute rounded-lg z-10 -bottom-3 -right-3"></div>
			</div>
		</div>
</template>

<script setup>
import TableOne from '@/Components/Provehub/Sha/TableOne.vue';
import DonutOne from '@/Components/Provehub/Sha/Charts/DonutOne.vue';

</script>

<style scoped>
.floating { 
    animation-name: floating; 
    animation-duration: 3s; 
    animation-iteration-count: infinite; 
    animation-timing-function: ease-in-out;
} 
@keyframes floating { 
    0% { transform: translate(0, 0px); } 
    50% { transform: translate(0, 8px); } 
    100% { transform: translate(0, -0px); }  
} 
</style>