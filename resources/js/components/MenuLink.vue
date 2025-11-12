<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps(['href', 'active']);

const classes = computed(() =>
    props.active
        ? 'block rounded-lg bg-gray-100 px-4 py-2 text-sm font-medium text-gray-700'
        : 'block rounded-lg px-4 py-2 text-sm font-medium text-gray-500 hover:bg-gray-100 hover:text-gray-700'
);
</script>

<template>
    <Link :href="href" :class="classes">
        <slot />
    </Link>
</template>
