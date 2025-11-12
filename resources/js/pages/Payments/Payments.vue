<script setup>
import AppLayout from '@/layouts/AppLayout.vue';
import { Head } from '@inertiajs/vue3';
// import PlaceholderPattern from '../components/PlaceholderPattern.vue';
// import DonutOne from '@/Components/Provehub/Sha/Charts/DonutOne.vue';
// import ActivityGoal from '@/Components/Provehub/Sha/Cards/ActivityGoal.vue';
import DatatablePayment from '@/Components/Provehub/Sha/Tables/DatatablePayment.vue';
import { ref } from 'vue';


defineProps({
    'message': String,
    'payments': Object,
})

const breadcrumbs = ref([
    {
        title: 'My Payments',
        href: '/payments',
    },
]);

</script>

<template>
    <Head title="My Payments" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <!-- <div class="grid auto-rows-min gap-4 md:grid-cols-2">
                <div class="relative overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                    <DonutOne />
                </div>
                <div class="relative overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                    <ActivityGoal />
                </div>
            </div> -->
            
            <DatatablePayment :payments="payments" />
            <!-- <div class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border md:min-h-min">
                <PlaceholderPattern />
            </div> -->
        </div>
    </AppLayout>
</template>
