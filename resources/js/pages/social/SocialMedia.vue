<script setup>
import AppLayout from '@/layouts/AppLayout.vue';
import { Head } from '@inertiajs/vue3';
// import PlaceholderPattern from '../components/PlaceholderPattern.vue';
// import DonutOne from '@/Components/Provehub/Sha/Charts/DonutOne.vue';
// import ActivityGoal from '@/Components/Provehub/Sha/Cards/ActivityGoal.vue';
import DatatableCampaign from '@/Components/Provehub/Sha/Tables/DatatableCampaign.vue';
import { ref } from 'vue';


defineProps({
    'message': String,
    'campaigns': Object,
})

const breadcrumbs = ref([
    {
        title: 'Social Media Campaigns',
        href: '/social',
    },
]);

</script>

<template>
    <Head title="Social Media Campaigns" />

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
            
            <DatatableCampaign :campaigns="campaigns" />
            <!-- <div class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border md:min-h-min">
                <PlaceholderPattern />
            </div> -->
        </div>
    </AppLayout>
</template>
