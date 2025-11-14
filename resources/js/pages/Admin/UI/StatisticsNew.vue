
<template>
    
    <div>
    <dl class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
      <!-- each -->
      <div class="relative overflow-hidden rounded-lg bg-white px-4 pt-5 pb-12 shadow sm:px-6 sm:pt-6">
        <dt>
          <div class="absolute rounded-md bg-blue-500 p-3">
            <UserGroupIcon class="h-6 w-6 text-white" aria-hidden="true" />
          </div>
          <p class="ml-16 truncate text-sm font-medium text-gray-500">Users</p>
        </dt>
        <dd class="ml-16 flex items-baseline pb-6 sm:pb-7">
          <p class="text-2xl font-semibold text-gray-900">{{ props.users }}</p>
          <!-- <p :class="[item.changeType === 'increase' ? 'text-green-600' : 'text-red-600', 'ml-2 flex items-baseline text-sm font-semibold']">
            <ArrowUpIcon v-if="item.changeType === 'increase'" class="h-5 w-5 flex-shrink-0 self-center text-green-500" aria-hidden="true" />
            <ArrowDownIcon v-else class="h-5 w-5 flex-shrink-0 self-center text-red-500" aria-hidden="true" />
            <span class="sr-only"> {{ item.changeType === 'increase' ? 'Increased' : 'Decreased' }} by </span>
            {{ item.change }}
          </p> -->
          <div class="absolute inset-x-0 bottom-0 bg-gray-50 px-4 py-4 sm:px-6">
            <div class="text-sm">
              <Link :href="route('admin.users')" class="font-medium text-blue-600 hover:text-blue-500">
                View all<span class="sr-only"> Users stats</span></Link
              >
            </div>
          </div>
        </dd>
      </div>
      <!-- each -->
      <!-- each -->
      <div class="relative overflow-hidden rounded-lg bg-white px-4 pt-5 pb-12 shadow sm:px-6 sm:pt-6">
        <dt>
          <div class="absolute rounded-md bg-blue-500 p-3">
            <UserCircleIcon class="h-6 w-6 text-white" aria-hidden="true" />
          </div>
          <p class="ml-16 truncate text-sm font-medium text-gray-500">Agents</p>
        </dt>
        <dd class="ml-16 flex items-baseline pb-6 sm:pb-7">
          <p class="text-2xl font-semibold text-gray-900">{{ props.agents }}</p>
          <!-- <p :class="[item.changeType === 'increase' ? 'text-green-600' : 'text-red-600', 'ml-2 flex items-baseline text-sm font-semibold']">
            <ArrowUpIcon v-if="item.changeType === 'increase'" class="h-5 w-5 flex-shrink-0 self-center text-green-500" aria-hidden="true" />
            <ArrowDownIcon v-else class="h-5 w-5 flex-shrink-0 self-center text-red-500" aria-hidden="true" />
            <span class="sr-only"> {{ item.changeType === 'increase' ? 'Increased' : 'Decreased' }} by </span>
            {{ item.change }}
          </p> -->
          <div class="absolute inset-x-0 bottom-0 bg-gray-50 px-4 py-4 sm:px-6">
            <div class="text-sm">
              <Link :href="route('admin.agents')" class="font-medium text-blue-600 hover:text-blue-500">
                View all<span class="sr-only"> Agents</span></Link>
            </div>
          </div>
        </dd>
      </div>
      <!-- each -->
      <!-- each -->
      <div class="relative overflow-hidden rounded-lg bg-white px-4 pt-5 pb-12 shadow sm:px-6 sm:pt-6">
        <dt>
          <div class="absolute rounded-md bg-blue-500 p-3">
            <BuildingOffice2Icon class="h-6 w-6 text-white" aria-hidden="true" />
          </div>
          <p class="ml-16 truncate text-sm font-medium text-gray-500">Listings</p>
        </dt>
        <dd class="ml-16 flex items-baseline pb-6 sm:pb-7">
          <p class="text-2xl font-semibold text-gray-900">{{ props.listings }}</p>
          <!-- <p :class="[item.changeType === 'increase' ? 'text-green-600' : 'text-red-600', 'ml-2 flex items-baseline text-sm font-semibold']">
            <ArrowUpIcon v-if="item.changeType === 'increase'" class="h-5 w-5 flex-shrink-0 self-center text-green-500" aria-hidden="true" />
            <ArrowDownIcon v-else class="h-5 w-5 flex-shrink-0 self-center text-red-500" aria-hidden="true" />
            <span class="sr-only"> {{ item.changeType === 'increase' ? 'Increased' : 'Decreased' }} by </span>
            {{ item.change }}
          </p> -->
          <div class="absolute inset-x-0 bottom-0 bg-gray-50 px-4 py-4 sm:px-6">
            <div class="text-sm">
              <Link :href="route('admin.listings')" class="font-medium text-blue-600 hover:text-blue-500">
                View all<span class="sr-only"> Listings</span></Link
              >
            </div>
          </div>
        </dd>
      </div>
      <!-- each -->
      <!-- each -->
      <div class="relative overflow-hidden rounded-lg bg-white px-4 pt-5 pb-12 shadow sm:px-6 sm:pt-6">
        <dt>
          <div class="absolute rounded-md bg-blue-500 p-3">
            <BanknotesIcon class="h-6 w-6 text-white" aria-hidden="true" />
          </div>
          <p class="ml-16 truncate text-sm font-medium text-gray-500">Payments</p>
        </dt>
        <dd class="ml-16 flex items-baseline pb-6 sm:pb-7">
          <p class="text-2xl font-semibold text-gray-900">{{ props.payments }}</p>
          <!-- <p :class="[item.changeType === 'increase' ? 'text-green-600' : 'text-red-600', 'ml-2 flex items-baseline text-sm font-semibold']">
            <ArrowUpIcon v-if="item.changeType === 'increase'" class="h-5 w-5 flex-shrink-0 self-center text-green-500" aria-hidden="true" />
            <ArrowDownIcon v-else class="h-5 w-5 flex-shrink-0 self-center text-red-500" aria-hidden="true" />
            <span class="sr-only"> {{ item.changeType === 'increase' ? 'Increased' : 'Decreased' }} by </span>
            {{ item.change }}
          </p> -->
          <div class="absolute inset-x-0 bottom-0 bg-gray-50 px-4 py-4 sm:px-6">
            <div class="flex text-sm justify-between">
              <!-- <Link :href="route('admin.users')" class="font-medium text-blue-600 hover:text-blue-500">
                View all<span class="sr-only"> Trips</span></Link -->
              
              <Link :href="route('admin.dashboard')" class="font-medium text-blue-600 hover:text-blue-500">
                View all<span class="sr-only"> Reports</span></Link
              >
            </div>
          </div>
        </dd>
      </div>
      <!-- each -->
    </dl>
  </div>
</template>

<script setup>
import { ArrowDownIcon, ArrowUpIcon, CheckIcon } from '@heroicons/vue/20/solid'
import { BuildingOffice2Icon, VideoCameraIcon, UsersIcon, BanknotesIcon, UserGroupIcon, UserCircleIcon, AcademicCapIcon } from '@heroicons/vue/24/outline'
import { Link } from '@inertiajs/vue3';

const props = defineProps({
  'users': Number,
  'payments': Number,
  'agents': Number,
  'listings': Number,
})


</script>
