 <template>
   <div class="lg:col-start-3 lg:row-end-1">
    <h2 class="sr-only">Summary</h2>
    
    <div class="mt-6 grid grid-cols-1 gap-x-6 gap-y-8 lg:grid-cols-3 xl:gap-x-8">
    <!-- cols -->
    <div v-for="datum in props.data.data" :key="datum.id" class="rounded-lg bg-gray-50 shadow-sm ring-1 ring-gray-900/5">
      <dl class="flex flex-wrap">
        <div class="flex-auto pl-6 pt-6">
          <dt class="text-sm font-semibold leading-6 text-gray-900">Admission into {{ datum.schoolclass.name }}</dt>
          <dd class="mt-1 text-base font-semibold leading-6 text-gray-900">{{ datum.admission_no }}</dd>
        </div>
        <div class="flex-none self-end px-6 pt-4">
          <dt class="sr-only">Status</dt>
          <dd v-if="datum.students.studentpayment[0]?.payment?.status == 1" class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">Paid</dd>
          <dd v-else class="inline-flex items-center rounded-md bg-red-50 px-2 py-1 text-xs font-medium text-red-700 ring-1 ring-inset ring-red-600/20">Un-Paid</dd>
        </div>
        <div class="mt-6 flex w-full flex-none gap-x-4 border-t border-gray-900/5 px-6 pt-6">
          <dt class="flex-none">
            <span class="sr-only">Client</span>
            <UserCircleIcon class="h-6 w-5 text-gray-400" aria-hidden="true" />
          </dt>
          <dd class="text-sm font-medium leading-6 text-gray-900">{{ datum.students.user.name }}</dd>
        </div>
        <div class="mt-4 flex w-full flex-none gap-x-4 px-6">
          <dt class="flex-none">
            <span class="sr-only">Due date</span>
            <CalendarDaysIcon class="h-6 w-5 text-gray-400" aria-hidden="true" />
          </dt>
          <dd class="text-sm leading-6 text-gray-500">
            <time datetime="2023-01-31">{{ datum.created_at_formatted }}</time>
          </dd>
        </div>
        <div class="mt-4 flex w-full flex-none gap-x-4 px-6">
          <dt class="flex-none">
            <span class="sr-only">Status</span>
            <CreditCardIcon class="h-6 w-5 text-gray-400" aria-hidden="true" />
          </dt>
          <dd class="text-sm leading-6 text-gray-500">₦ {{ datum.students.studentpayment[0]?.payment?.amount_formatted }}</dd>
        </div>
      </dl>
      <div class="mt-6 border-t border-gray-900/5 px-6 py-6">
        <Link v-if="datum.students.studentpayment[0]?.payment?.status == 1" :href="route('take.exam',{ exam: datum.students.studentpayment[0]?.payment?.id })" class="text-sm font-semibold leading-6 text-gray-900">Take Exam <span aria-hidden="true">&rarr;</span></Link>
        <Link v-else :href="route('checkout',{ payment: datum.students.studentpayment[0]?.payment?.id })" class="text-sm font-semibold leading-6 text-gray-900">Pay Now <span aria-hidden="true">&rarr;</span></Link>
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
