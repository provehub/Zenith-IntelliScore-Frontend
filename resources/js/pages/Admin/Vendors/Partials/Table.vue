<script setup>
import TablePaginate from '@/Pages/Admin/UI/TablePaginate.vue';
import { Link } from '@inertiajs/vue3';
import ViewDocuments from '@/Pages/Admin/Vendors/Partials/ViewDocuments.vue';
import { ref } from 'vue';
import Modal from '@/Components/Modal.vue';

defineProps([
'message',
'vendors',
])

const openInNewTab = (event) => {
const url = event.currentTarget.href;
window.open(url, '_blank');
};

const confirmingDocuments = ref(false);
const dataFromButton = ref([]);

const confirmDocuments = (data) => {
    dataFromButton.value = data;
    confirmingDocuments.value = true;
};

const closeModalDocuments = () => {
    confirmingDocuments.value = false;
};

</script>

<template>

<div class="container px-4 mx-auto dark:bg-gray-600 w-fit">
<div class="sm:flex sm:items-center sm:justify-between">
<div>
<div class="flex items-center gap-x-3">
<h2 class="text-lg font-medium text-white">Accounts</h2>

<span
class="px-3 py-1 text-xs text-red-600 bg-red-100 rounded-full dark:bg-gray-800 dark:text-red-400">{{ vendors . data . length }}
accounts</span>
</div>

<p class="mt-1 text-sm text-gray-500 dark:text-gray-300">Manage all accounts.</p>
</div>

<!-- <div class="flex items-center mt-4 gap-x-3">
<button class="flex items-center justify-center w-1/2 px-5 py-2 text-sm text-gray-700 transition-colors duration-200 bg-white border rounded-lg gap-x-2 sm:w-auto dark:hover:bg-gray-800 dark:bg-gray-900 hover:bg-gray-100 dark:text-gray-200 dark:border-gray-700">
<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
<g clip-path="url(#clip0_3098_154395)">
<path d="M13.3333 13.3332L9.99997 9.9999M9.99997 9.9999L6.66663 13.3332M9.99997 9.9999V17.4999M16.9916 15.3249C17.8044 14.8818 18.4465 14.1806 18.8165 13.3321C19.1866 12.4835 19.2635 11.5359 19.0351 10.6388C18.8068 9.7417 18.2862 8.94616 17.5555 8.37778C16.8248 7.80939 15.9257 7.50052 15 7.4999H13.95C13.6977 6.52427 13.2276 5.61852 12.5749 4.85073C11.9222 4.08295 11.104 3.47311 10.1817 3.06708C9.25943 2.66104 8.25709 2.46937 7.25006 2.50647C6.24304 2.54358 5.25752 2.80849 4.36761 3.28129C3.47771 3.7541 2.70656 4.42249 2.11215 5.23622C1.51774 6.04996 1.11554 6.98785 0.935783 7.9794C0.756025 8.97095 0.803388 9.99035 1.07431 10.961C1.34523 11.9316 1.83267 12.8281 2.49997 13.5832" stroke="currentColor" stroke-width="1.67" stroke-linecap="round" stroke-linejoin="round"/>
</g>
<defs>
<clipPath id="clip0_3098_154395">
<rect width="20" height="20" fill="white"/>
</clipPath>
</defs>
</svg>

<span>Export</span>
</button>

<button class="flex items-center justify-center w-1/2 px-5 py-2 text-sm tracking-wide text-white transition-colors duration-200 bg-red-500 rounded-lg shrink-0 sm:w-auto gap-x-2 hover:bg-red-600 dark:hover:bg-red-500 dark:bg-red-600">
<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
<path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
</svg>

<span>Add new</span>
</button>
</div> -->
</div>

<div class="mt-6 md:flex md:items-center md:justify-between">
<div
class="inline-flex overflow-hidden bg-white border divide-x rounded-lg dark:bg-gray-900 rtl:flex-row-reverse dark:border-gray-700 dark:divide-gray-700">
<button
class="px-5 py-2 text-xs font-medium text-gray-600 transition-colors duration-200 bg-gray-100 sm:text-sm dark:bg-gray-800 dark:text-gray-300">
All
</button>

<button
class="px-5 py-2 text-xs font-medium text-gray-600 transition-colors duration-200 sm:text-sm dark:hover:bg-gray-800 dark:text-gray-300 hover:bg-gray-100">
Active
</button>

<button
class="px-5 py-2 text-xs font-medium text-gray-600 transition-colors duration-200 sm:text-sm dark:hover:bg-gray-800 dark:text-gray-300 hover:bg-gray-100">
Not-Active
</button>
</div>

<div class="relative flex items-center mt-4 md:mt-0">
<span class="absolute">
<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
stroke="currentColor" class="w-5 h-5 mx-3 text-gray-400 dark:text-gray-600">
<path stroke-linecap="round" stroke-linejoin="round"
d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
</svg>
</span>

<input type="text" placeholder="Search"
class="block w-full py-1.5 pr-5 text-gray-700 bg-white border border-gray-200 rounded-lg md:w-80 placeholder-gray-400/70 pl-11 rtl:pr-11 rtl:pl-5 dark:bg-gray-900 dark:text-gray-300 dark:border-gray-600 focus:border-red-400 dark:focus:border-red-300 focus:ring-red-300 focus:outline-none focus:ring focus:ring-opacity-40">
</div>
</div>

<div class="flex flex-col mt-6">
<div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
<div class="inline-block min-w-fit py-2 align-middle md:px-6 lg:px-8">
<div class="overflow-hidden border border-gray-200 dark:border-gray-700 md:rounded-lg">
<table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
<thead class="bg-gray-50 dark:bg-gray-800">
    <tr>
        <th scope="col"
            class="py-3.5 px-4 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <span>S/N</span>
        </th>
        <th scope="col"
            class="py-3.5 px-4 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <button class="flex items-center gap-x-3 focus:outline-none">
                <span>Name</span>

                <svg class="h-3" viewBox="0 0 10 11" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M2.13347 0.0999756H2.98516L5.01902 4.79058H3.86226L3.45549 3.79907H1.63772L1.24366 4.79058H0.0996094L2.13347 0.0999756ZM2.54025 1.46012L1.96822 2.92196H3.11227L2.54025 1.46012Z"
                        fill="currentColor" stroke="currentColor" stroke-width="0.1" />
                    <path
                        d="M0.722656 9.60832L3.09974 6.78633H0.811638V5.87109H4.35819V6.78633L2.01925 9.60832H4.43446V10.5617H0.722656V9.60832Z"
                        fill="currentColor" stroke="currentColor" stroke-width="0.1" />
                    <path
                        d="M8.45558 7.25664V7.40664H8.60558H9.66065C9.72481 7.40664 9.74667 7.42274 9.75141 7.42691C9.75148 7.42808 9.75146 7.42993 9.75116 7.43262C9.75001 7.44265 9.74458 7.46304 9.72525 7.49314C9.72522 7.4932 9.72518 7.49326 9.72514 7.49332L7.86959 10.3529L7.86924 10.3534C7.83227 10.4109 7.79863 10.418 7.78568 10.418C7.77272 10.418 7.73908 10.4109 7.70211 10.3534L7.70177 10.3529L5.84621 7.49332C5.84617 7.49325 5.84612 7.49318 5.84608 7.49311C5.82677 7.46302 5.82135 7.44264 5.8202 7.43262C5.81989 7.42993 5.81987 7.42808 5.81994 7.42691C5.82469 7.42274 5.84655 7.40664 5.91071 7.40664H6.96578H7.11578V7.25664V0.633865C7.11578 0.42434 7.29014 0.249976 7.49967 0.249976H8.07169C8.28121 0.249976 8.45558 0.42434 8.45558 0.633865V7.25664Z"
                        fill="currentColor" stroke="currentColor" stroke-width="0.3" />
                </svg>
            </button>
        </th>

        <th scope="col"
            class="px-12 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
            Status
        </th>

        <th scope="col" class="relative py-3.5 px-4">
            <span class="sr-only">Action</span>
        </th>
    </tr>
</thead>
<tbody class="bg-white divide-y divide-gray-200 dark:divide-gray-700 dark:bg-gray-900">
    <tr v-for="(vendor, index) in vendors.data" :key="vendor.id">
        <td class="px-4 py-4 text-sm font-medium whitespace-nowrap">
            <div>
                <h2 class="font-medium text-gray-800 dark:text-white ">{{ index + 1 }}
                </h2>
            </div>
        </td>
        <td class="px-4 py-4 text-sm font-medium whitespace-nowrap">
            <div>
                <h2 class="font-medium text-gray-800 dark:text-white ">{{ vendor . name }}
                </h2>
            </div>
        </td>
        <td class="px-12 py-4 text-sm font-medium whitespace-nowrap">
            <div v-if="vendor . status == 1"
                class="inline px-3 py-1 text-sm font-normal rounded-full text-emerald-500 gap-x-2 bg-emerald-100/60 dark:bg-gray-800">
                Active
            </div>
            <div v-else
                class="inline px-3 py-1 text-sm font-normal rounded-full text-emerald-50 gap-x-2 bg-red-600/60 dark:bg-gray-800">
                Not Active
            </div>
        </td>

        <td class="px-4 py-4 text-sm whitespace-nowrap">
            <div
                class="flex overflow-hidden bg-white border divide-x rounded-lg rtl:flex-row-reverse dark:bg-gray-900 dark:border-gray-700 dark:divide-gray-700 w-fit">
                <!-- <Link v-if="vendor . status == 3" :href="route('admin.vendors.activate', { vendor: vendor.slug, user: vendor.user_id })"
                as="button" method="get"
                    class="flex items-center px-4 py-2 text-sm font-medium text-gray-600 transition-colors duration-200 sm:text-base sm:px-6 dark:hover:bg-gray-800 dark:text-gray-300 gap-x-3 hover:bg-gray-100">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                        class="w-5 h-5 sm:w-6 sm:h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5m8.25 3v6.75m0 0l-3-3m3 3l3-3M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                    </svg>

                    <span>Activate</span>
                </Link> -->

                <!-- <Link v-if="vendor . status == 1" :href="route('admin.vendors.deactivate', { vendor: vendor.slug, user: vendor.user_id })"
                as="button" method="get"
                    class="flex items-center px-4 py-2 text-sm font-medium text-gray-600 transition-colors duration-200 sm:text-base sm:px-6 dark:hover:bg-gray-800 dark:text-gray-300 gap-x-3 hover:bg-gray-100">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                        class="w-5 h-5 sm:w-6 sm:h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                    </svg>

                    <span>Deactivate</span>
                </Link> -->

                <!-- <a :href="route('agent.show',vendor.slug)" @click.prevent="openInNewTab" v-if="vendor . status == 1"
                    class="flex items-center px-4 py-2 text-sm font-medium text-gray-600 transition-colors duration-200 sm:text-base sm:px-6 dark:hover:bg-gray-800 dark:text-gray-300 gap-x-3 hover:bg-gray-100">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
  <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
</svg>


                    <span>View</span>
                </a> -->

                <a :href="route('liveness.show',{ vendor: vendor.id, extras: vendor.id})" @click.prevent="openInNewTab"
                    class="flex items-center px-4 py-2 text-sm font-medium text-gray-600 transition-colors duration-200 sm:text-base sm:px-6 dark:hover:bg-gray-800 dark:text-gray-300 gap-x-3 hover:bg-gray-100">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                        class="w-5 h-5 sm:w-6 sm:h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M7.5 3.75H6A2.25 2.25 0 003.75 6v1.5M16.5 3.75H18A2.25 2.25 0 0120.25 6v1.5m0 9V18A2.25 2.25 0 0118 20.25h-1.5m-9 0H6A2.25 2.25 0 013.75 18v-1.5M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>

                    <span>Liveness Results</span>
                </a>

                <div v-if="vendor . status != 1 && vendor . status != 3"
                class="inline px-3 py-1 text-sm font-normal rounded-full text-emerald-50 gap-x-2 bg-red-600/60 dark:bg-gray-800">
                Has not finished registeration.
            </div>

            <button @click="confirmDocuments(vendor)" class="flex items-center px-4 py-2 text-sm font-medium text-gray-600 transition-colors duration-200 sm:text-base sm:px-6 dark:hover:bg-gray-800 dark:text-gray-300 gap-x-3 hover:bg-gray-100">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 sm:w-6 sm:h-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 16.5V9.75m0 0l3 3m-3-3l-3 3M6.75 19.5a4.5 4.5 0 01-1.41-8.775 5.25 5.25 0 0110.233-2.33 3 3 0 013.758 3.848A3.752 3.752 0 0118 19.5H6.75z" />
        </svg>

        <span>Make Loan Decision</span>
    </button>
            </div>
        </td>

    </tr>


</tbody>
</table>
</div>
</div>
</div>
</div>

<!-- Links -->
<TablePaginate :links="vendors.links" />
<!-- Links -->
</div>

<Modal :show="confirmingDocuments" @close="closeModalDocuments" >
                    <ViewDocuments :vendor="dataFromButton"
                    class="py-8 px-8"
                    />
                </Modal>

</template>
