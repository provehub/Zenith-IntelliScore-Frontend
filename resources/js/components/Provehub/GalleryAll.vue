<template>
  <!-- CTA section -->
  <section class="pb-24">
    <div class="container px-4">
      <div class="bg-blue-500 rounded-full absolute w-12 h-12 z-0 -left-4 -top-3 animate-pulse"></div>
				<h1 class="font-semibold text-3xl relative z-50 text-darken lg:pr-10 mb-5">Our Photo, <span class="text-blue-500">Gallery</span></h1>
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-[30px]">
        <a href="#" v-for="image in photos" :key="image.id">
          <img :src="image.img" @click="openLightbox(image.id)" alt="" />
        </a>
      </div>
    </div>
  </section>

  <div class="flex items-center">
    <vue-easy-lightbox
      :visible="visible"
      :imgs="imageUrls"
      :index="index"
      @hide="closeLightbox"
    />
  </div>
</template>

<script setup>
import { ref, computed } from "vue";
import VueEasyLightbox from "vue-easy-lightbox";

const props = defineProps({
  photos: {
    type: Array,
    required: true
  }
});

const visible = ref(false);
const index = ref(0);

const imageUrls = computed(() => props.photos.map((image) => image.img));

const openLightbox = (id) => {
  const imageIndex = props.photos.findIndex((image) => image.id === id);
  if (imageIndex !== -1) { // If found
    index.value = imageIndex;
    visible.value = true;
  }
};

const closeLightbox = () => {
  visible.value = false;
};
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