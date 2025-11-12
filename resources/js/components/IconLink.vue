<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps(['href', 'active']);

const classes = computed(() =>
    props.active
        ? 'ml-2 inline-block rounded-full border bg-white p-3 text-gray-500 hover:bg-indigo-600 hover:text-white focus:outline-none focus:ring active:bg-indigo-500'
        : 'ml-2 inline-block rounded-full border bg-white p-3 text-gray-500 hover:bg-indigo-600 hover:text-white focus:outline-none focus:ring'
);
</script>

<template>
    <Link :href="href" :class="classes">
        <slot />
    </Link>
</template>
