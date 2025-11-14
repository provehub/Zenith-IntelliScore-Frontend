<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import StatisticsNew from '@/Pages/Admin/UI/StatisticsNew.vue';

import Activities from '@/Pages/Admin/UI/Activities.vue';
import Traffic from '@/Pages/Admin/UI/Traffic.vue';
import ReviewStats from '@/Pages/Admin/UI/ReviewStats.vue';
import { computed } from 'vue';
import { Head } from '@inertiajs/vue3';

const props = defineProps({
  'message':String,
  'time': String,
  'users': Number,
  'agents': Number,
  'payments': Number,
  'listings': Number,
})

const greeting = computed(() => {
    let hour = parseInt(props.time.substring(0, 2));
            if (hour < 12) {
                return 'Good morning,';
            } else if (hour < 16) {
                return 'Good afternoon,';
            } else {
                return 'Good evening,';
            }
    });

</script>
 
<template>
    <Head title="Admin Dashboard" />

    <AdminLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Admin Dashboard</h2>
        </template>

        <div class="py-8">
            <h2 class="px-8 font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">Admin Dashboard</h2>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="font-bold text-xl text-gray-800 dark:text-gray-100 leading-none">{{ greeting }} {{ $page.props.auth.user.name }}</div>
                <!-- <StatisticsNew 
                    :users="users"
                    :agents="agents"
                    :payments="payments"
                    :listings="listings"
                     /> -->

                     <!-- <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mt-8">
                <Activities
                    :title="'Listings'"
                    :url="'listings'"
                    :visit="'admin.dashboard'"
                    :pending="gymspending"
                    :promotions="promotions"
                 />
                <Activities
                    :title="'Payments'"
                    :url="'payments'"
                    :visit="'admin.dashboard'"
                    :pending="coachespending"
                    :promotions="promotions"
                 />
                 <Traffic :traffic="''" />
                 <ReviewStats :reports="reports" :reviews="reviews" />

                </div> -->

            </div>
        </div>
    </AdminLayout>
</template>
