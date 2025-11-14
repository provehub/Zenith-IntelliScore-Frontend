<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import AddSettings from './Partials/AddSettings.vue';
import AddPhotos from './Partials/AddPhotos.vue';
import { Head } from '@inertiajs/vue3';
const props = defineProps({
  settings: Array,
  country: {Array,Object},
  photos: Object,
})
</script>
 
<template>
    <Head title="Settings" />

    <AdminLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Settings</h2>
        </template>

        <div class="py-12"> 
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mt-8">
                    <AddSettings :settings="settings" :country="country"
                        class="max-w-xl"
                    />
                    <AddPhotos :photos="photos"
                        class="max-w-xl"
                    />
                </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
