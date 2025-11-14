<script setup>
import { computed } from 'vue';

const props = defineProps({
    vendor: Object,
})

const logo = computed(() => {
      return route('index') + '/storage/vendor/profile/' +props.vendor.profile_image;
    });

const identity = computed(() => {
      return route('index') + '/storage/vendor/verifications/' +props.vendor.identity;
    });

const document = computed(() => {
      return route('index') + '/storage/vendor/verifications/' +props.vendor.shopdoc;
    });

</script>

<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900">Documents for {{ props.vendor.name }}</h2>
        </header>

        <div class="mt-6 space-y-6">
            <div>
                <h3>Logo</h3>
                <div class=" overflow-hidden rounded-lg mb-4">
                    <img :src="logo" class=" object-cover object-center">
                    </div>
                <h3>Identity Card</h3>
                <div class=" overflow-hidden rounded-lg mb-4">
                    <img :src="identity" class=" object-cover object-center">
                    </div>
                <h3>Proof Document</h3>
                <div class=" overflow-hidden rounded-lg mb-4">
                    <img :src="document" class=" object-cover object-center">
                    </div>

            </div>
        </div>
    </section>
</template>
