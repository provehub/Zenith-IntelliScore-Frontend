<script setup>
defineProps({
    value: {
        type: String,
    },
});
</script>

<template>
    <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">
        <span v-if="value">{{ value }}</span>
        <span v-else><slot /></span>
    </label>
</template>
