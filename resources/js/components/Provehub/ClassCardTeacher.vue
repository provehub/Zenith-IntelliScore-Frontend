 <template>
   <div class="lg:col-start-3 lg:row-end-1">
    <h2 class="sr-only">Summary</h2>
    
    <div class="mt-6 grid grid-cols-1 gap-x-6 gap-y-8 lg:grid-cols-3 xl:gap-x-8">
    <!-- cols -->
    <div v-for="datum in props.data.data" :key="datum.id" class="rounded-lg bg-gray-50 shadow-sm ring-1 ring-gray-900/5">
      <dl class="flex flex-wrap">
        <div class="flex-auto pl-6 pt-6">
          <dt class="text-sm font-semibold leading-6 text-gray-900">Class: </dt>
          <dd class="mt-1 text-base font-semibold leading-6 text-gray-900">{{ datum.schoolclass.name }}</dd>
        </div>
        <div class="flex-none self-end px-6 pt-4">
          <dt class="sr-only">Status</dt>
          <dd class="inline-flex items-center rounded-md bg-red-50 px-2 py-1 text-xs font-medium text-red-700 ring-1 ring-inset ring-red-600/20">Current Class</dd>
        </div>
        <!-- <div class="mt-6 flex w-full flex-none gap-x-4 border-t border-gray-900/5 px-6 pt-6">
          <dt class="flex-none">
            <span class="sr-only">Client</span>
            <UserCircleIcon class="h-6 w-5 text-gray-400" aria-hidden="true" />
          </dt>
          <dd class="text-sm font-medium leading-6 text-gray-900">Hey</dd>
        </div> -->
        <!-- <div class="mt-4 flex w-full flex-none gap-x-4 px-6">
          <dt class="flex-none">
            <span class="sr-only">Due date</span>
            <CalendarDaysIcon class="h-6 w-5 text-gray-400" aria-hidden="true" />
          </dt>
          <dd class="text-sm leading-6 text-gray-500">
            <time datetime="2023-01-31">{{ datum.created_at }}</time>
          </dd>
        </div> -->
        <!-- <div class="mt-4 flex w-full flex-none gap-x-4 px-6">
          <dt class="flex-none">
            <span class="sr-only">Status</span>
            <CreditCardIcon class="h-6 w-5 text-gray-400" aria-hidden="true" />
          </dt>
          <dd class="text-sm leading-6 text-gray-500">Timetable</dd>
        </div> -->
      </dl>
      <div class="mt-6 border-t border-gray-900/5 px-6 py-6">
        <Link :href="route('teachers.students.parents', { id : datum.schoolclass.id })" class="text-sm font-semibold leading-6 text-gray-900">Students/Parents <span aria-hidden="true">&rarr;</span></Link>
        <Link :href="route('class.timetable', { schoolclass : datum.schoolclass.id })" class="text-sm font-semibold leading-6 text-gray-900 ml-2">Timetable <span aria-hidden="true">&rarr;</span></Link>
      </div>
    </div>
    <!-- cols -->
  </div>
  </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import { CalendarDaysIcon, CreditCardIcon, UserCircleIcon } from '@heroicons/vue/20/solid'

const props = defineProps({
    'data': Object,
})
</script>
