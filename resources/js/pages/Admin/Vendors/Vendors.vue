<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import Table from '@/Pages/Admin/Vendors/Partials/Table.vue';
import { Head } from '@inertiajs/vue3';

defineProps([
    'message',
    'vendors',
])

</script>
 
<template>
    <Head title="Accounts" />

    <AdminLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Agents</h2> 
        </template>

        <div class="py-4">
                    <Table :vendors="vendors"
                    />
        </div>
    </AdminLayout>
</template>
