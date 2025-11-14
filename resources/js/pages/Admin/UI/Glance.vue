<script setup>
import { Link } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

const props = defineProps({
  'message':String,
  'time': String,
  'users': Number,
  'listings': Number,
  'locations': Number,
})

const greeting = computed(() => {
    let hour = parseInt(props.time.substring(0, 2));
            if (hour < 12) {
                return 'Good morning!';
            } else if (hour < 16) {
                return 'Good afternoon!';
            } else {
                return 'Good evening!';
            }
    });

</script>

<template>
<div>
    <h3 class="text-2xl font-bold mb-4">Admin Dashboard</h3>

    <div class="grid grid-cols-2 gap-4">
      <div class="col-span-2">
        <div class="p-4 bg-green-100 rounded-xl">
          <div class="font-bold text-xl text-gray-800 leading-none">{{ greeting }} <br>{{ $page.props.auth.user.name }}</div>
          <div class="mt-5">
            <Link :href="route('admin.users')" class="inline-flex items-center justify-center py-2 px-3 rounded-xl bg-white text-gray-800 hover:text-green-500 text-sm font-semibold transition">
              View Users
            </Link>
            <Link :href="route('admin.students')" class="inline-flex items-center justify-center py-2 px-3 rounded-xl bg-white text-gray-800 hover:text-green-500 text-sm font-semibold transition">
              View Students
            </Link>
            <Link :href="route('admin.parents')" class="inline-flex items-center justify-center py-2 px-3 rounded-xl bg-white text-gray-800 hover:text-green-500 text-sm font-semibold transition ml-2">
              View Parents
            </Link>
            <Link :href="route('admin.teachers')" class="inline-flex items-center justify-center py-2 px-3 rounded-xl bg-white text-gray-800 hover:text-green-500 text-sm font-semibold transition ml-2">
              View Teachers
            </Link>
          </div>
        </div>
      </div>
      <div class="p-4 bg-yellow-100 rounded-xl text-gray-800">
        <div class="font-bold text-2xl leading-none">{{ users }}</div>
        <div class="mt-2">Users</div>
      </div>
      <div class="p-4 bg-yellow-100 rounded-xl text-gray-800">
        <div class="font-bold text-2xl leading-none">0</div>
        <div class="mt-2">Classes</div>
      </div>
      <div class="col-span-2">
        <div class="p-4 bg-purple-100 rounded-xl text-gray-800">
          <div class="font-bold text-xl leading-none">1</div>
          <div class="mt-2"> Buses</div>
        </div>
      </div>
    </div>
  </div>
</template>