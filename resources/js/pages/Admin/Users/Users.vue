<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';
import Modal from '@/Components/Modal.vue';

import DataTable from 'datatables.net-vue3';
import DataTablesLib from 'datatables.net';
import 'datatables.net-select-dt'; // Correct styling import for select functionality
import 'datatables.net-buttons-dt'; // Correct styling import for buttons functionality
import 'datatables.net-buttons/js/buttons.html5'; // Export options for CSV, Excel, etc.
import jszip from 'jszip'; // Required for Excel export
import pdfmake from 'pdfmake'; // Required for PDF export

// Register DataTables and its extensions
DataTable.use(DataTablesLib);
DataTablesLib.Buttons.jszip(jszip);
DataTablesLib.Buttons.pdfMake(pdfmake);

const props = defineProps([
    'message',
    'users',
    'users_count',
])

const confirmingUpdate = ref(false);

const dataFromButton = ref([]);

const confirmUpdate = (data) => {
    dataFromButton.value = data;
    confirmingUpdate.value = true;
};

const closeModalUpdate = () => {
    confirmingUpdate.value = false;
};


const confirmingDestroy = ref(false);

const dataFromButtonDestroy = ref([]);

const confirmDestroy = (data) => {
    dataFromButtonDestroy.value = data;
    confirmingDestroy.value = true;
};

const closeModalDestroy = () => {
    confirmingDestroy.value = false;
};

const data = props.users;

//<button data-id="${row.id}" data-action="update" data-row='${JSON.stringify(row)}' class="flex items-center px-4 py-2 text-sm font-medium text-gray-600 bg-gray-800 transition-colors duration-200 sm:text-base sm:px-6 dark:bg-gray-800 dark:hover:bg-gray-500 dark:text-gray-300 gap-x-3 hover:bg-gray-500"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 sm:w-6 sm:h-6">
            //<path stroke-linecap="round" stroke-linejoin="round" d="M12 16.5V9.75m0 0l3 3m-3-3l-3 3M6.75 19.5a4.5 4.5 0 01-1.41-8.775 5.25 5.25 0 0110.233-2.33 3 3 0 013.758 3.848A3.752 3.752 0 0118 19.5H6.75z" />
        //</svg>
            //<span>Update</span></button>

const renderButtons = (data, type, row) => {
    return `
    <div class="inline-flex">
        
        <button data-id="${row.id}" data-action="delete" data-row='${JSON.stringify(row)}' class="flex items-center px-4 py-2 text-sm font-medium text-gray-200 bg-gray-800 transition-colors duration-200 sm:text-base sm:px-6 gap-x-3 hover:bg-gray-500 ml-1">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 sm:w-6 sm:h-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
        </svg>
            <span>Delete</span></button>
            </div>
    `;
};


// Define options for DataTable
const options = {
    dom: '<"d-flex align-items-center justify-content-between"lBf>rtip', 
    layout: {
        topStart: 'buttons',
    },
    select: true,
    buttons: [
        {
            extend: 'csvHtml5',
            text: 'Export CSV',
            className: 'px-6 py-2 font-medium tracking-wide text-white capitalize transition-colors duration-300 transform bg-blue-600 rounded-lg hover:bg-blue-500 focus:outline-none focus:ring focus:ring-blue-300 focus:ring-opacity-80',
        },
    ],
    responsive: true
};

const renderCounter = (data, type, row, meta) => {
    return meta.row + meta.settings._iDisplayStart + 1;
};

const columns = ref([
    { title: 'No.', data: null, render: renderCounter, orderable: true, searchable: false, width: "7%" },
    { title: 'ID', data: 'id', visible: false },
    { title: 'Name', data: 'name' },
    { title: 'Email', data: 'email' },
    { title: 'Actions', data: null, render: renderButtons, orderable: false, searchable: false, }
]);


const handleClick = (event) => {
    // Determine if the clicked element or any of its ancestors is a button.
    let targetElement = event.target; 
    while (targetElement !== null) {
        if (targetElement.matches('button[data-action]')) {
            break;
        }
        targetElement = targetElement.parentElement;
    }

    if (targetElement === null) return; // No matched button found in the clicked element's lineage.

    const action = targetElement.dataset.action;
    const rowData = JSON.parse(targetElement.dataset.row);

    if (action === "delete") {
        console.log(`Delete button with ID ${rowData.id} clicked!`);
        confirmDestroy(rowData);
    }

    // if (action === "update") {
    //     console.log(`Update button with ID ${rowData.id} clicked!`);
    //     confirmUpdate(rowData);
    // } else if (action === "delete") {
    //     console.log(`Delete button with ID ${rowData.id} clicked!`);
    //     confirmDestroy(rowData);
    // }
};




</script>
 
<style>
@import 'datatables.net-dt/css/dataTables.dataTables.css';         
@import 'datatables.net-buttons-dt/css/buttons.dataTables.css';  
@import 'datatables.net-select-dt/css/select.dataTables.css';    
</style>

<style>
@import 'datatables.net-dt';

.dataTables_wrapper .dataTables_length select {
  border: 1px solid #aaa;
  border-radius: 3px;
  padding: 15px;
  background-color: transparent;
  color: inherit;
  padding: 4px;
  padding-left: 10px;
  padding-right: 30px;
}



</style>

<template>
    <Head title="Users" />

    <AdminLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Users</h2> 
        </template>

        <div class="py-4 pb-20 ">
            <div class="max-w-7xl mx-auto sm:flex sm:items-center sm:justify-between">
        <div>
            <div class="flex items-center gap-x-3">
                <h2 class="text-lg font-medium text-white dark:text-white">Users</h2>

                <span class="px-3 py-1 text-xs text-blue-600 bg-blue-100 rounded-full dark:bg-gray-800 dark:text-blue-400">{{ users_count }} users</span>
            </div>

            <p class="mt-1 text-sm text-gray-500 dark:text-gray-300">Manage all your users.</p>
        </div>
        </div>

            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 bg-gray-100 py-4 rounded-md">
                <div class="datatable-wrapper" @click="handleClick">
                <DataTable class="display text-gray-700 dark:text-gray-700" :columns="columns" :data="data" :options="options" width="100%" />
            </div>
                </div>
        </div>
    </AdminLayout>



    <!-- Update Modal -->
    <Modal :show="confirmingUpdate" @close="closeModalUpdate" >
        <div class="py-4 px-6">
         <!--MODAL HEADER-->
         <div
              class="flex justify-between items center border-b border-gray-200 py-2"
            >
              <div class="flex items-center justify-center">
                <p class="">
              </p>
              </div>
    
              <button @click="closeModalUpdate"
                class="bg-gray-300 hover:bg-gray-500 cursor-pointer hover:text-gray-300 font-sans text-gray-500 w-8 h-8 flex items-center justify-center rounded-full"
              >
                x
            </button>
            </div>
        </div>
        hey
    </Modal>
    <!-- Modal -->
    <!-- Delete Modal -->
    <Modal :show="confirmingDestroy" @close="closeModalDestroy" >
        <div class="py-4 px-6">
         <!--MODAL HEADER-->
         <div
              class="flex justify-between items center border-b border-gray-200 py-2"
            >
              <div class="flex items-center justify-center">
                <p class="">
              </p>
              </div>
    
              <button @click="closeModalDestroy"
                class="bg-gray-300 hover:bg-gray-500 cursor-pointer hover:text-gray-300 font-sans text-gray-500 w-8 h-8 flex items-center justify-center rounded-full"
              >
                x
            </button>
            </div>
        </div>
        <div class="rounded-lg bg-white p-8 shadow-2xl">
  <h2 class="text-lg font-bold">Are you sure you want to delete user: {{ dataFromButtonDestroy.name }}?</h2>

  <p class="mt-2 text-sm text-gray-500">
    Proceeding will delete every data owned by the user and related activities. are you 100% sure it's
    OK?
  </p>

  <div class="mt-4 flex gap-2">

    <a :href="route('admin.destroy.user', { user: dataFromButtonDestroy.id })" class="rounded bg-red-50 px-4 py-2 text-sm font-medium text-red-600">
        <span>Yes, I'm sure Delete Now</span>
    </a>

    <button @click="closeModalDestroy"
      type="button"
      class="rounded bg-greed-50 px-4 py-2 text-sm font-medium text-green-600"
    >
      No, go back
    </button>
  </div>

  <div v-if="$page.props.flash.success" class="mt-4">
            {{ $page.props.flash.success }}
        </div>
</div>

       
    </Modal>
    <!-- Modal -->

</template>
