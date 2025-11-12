 <template>
   <div v-for="datum in props.data.data" :key="datum.id" class="lg:col-start-3 lg:row-end-1">
  <h2 class="sr-only">Summary</h2>
  
  <div class="mt-6 grid grid-cols-1 gap-x-6 gap-y-8 lg:grid-cols-3 xl:gap-x-8">
    <!-- cols -->
    <div v-for="studentclass in datum.studentclass" :key="studentclass.id" class="rounded-lg bg-gray-50 shadow-sm ring-1 ring-gray-900/5">
      <dl class="flex flex-wrap">
        <div class="flex-auto pl-6 pt-6" >
          <dt class="text-sm font-semibold leading-6 text-gray-900"> {{ studentclass.schoolclass.name }}</dt>
          <!-- <dd class="mt-1 text-base font-semibold leading-6 text-gray-900">{{ datum.admission_no }}</dd> -->
        </div>
        <div class="flex-none self-end px-6 pt-4" >
          <dt class="sr-only">Status</dt>
          <dd v-if="studentclass.school_class_id == studentclass.current_class" class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">Current Class</dd>
        </div>
        <div class="mt-4 flex w-full flex-none gap-x-4 px-6" >
          <dt class="flex-none">
            <span class="sr-only">Due date</span>
            <CalendarDaysIcon class="h-6 w-5 text-gray-400" aria-hidden="true" />
          </dt>
          <dd class="text-sm leading-6 text-gray-500">
            <time datetime="2023-01-31">{{ studentclass.academic_session }}</time>
          </dd>
        </div>
        <div class="mt-4 flex w-full flex-none gap-x-4 px-6">
          <dt class="flex-none">
            <span class="sr-only">Status</span>
            <CreditCardIcon class="h-6 w-5 text-gray-400" aria-hidden="true" />
          </dt>
          <dd class="text-sm leading-6 text-gray-500">Timetable</dd>
        </div>
      </dl>
      <div class="mt-6 border-t border-gray-900/5 px-6 py-6">
        <span v-if="props.admission.school_class_id == studentclass.school_class_id && props.admission.term_admitted == 1"></span>

        <a v-else :href="route('view.student.report', { student : studentclass.student_id, studentclass: studentclass.id, term: 1 })" target="_blank" class="text-sm font-semibold leading-6 text-gray-900">First Term Report <span aria-hidden="true">&rarr;</span></a>

        <span v-if="props.admission.school_class_id == studentclass.school_class_id && props.admission.term_admitted == 2"></span>

        <a v-else :href="route('view.student.report.second.term', { student : studentclass.student_id, studentclass: studentclass.id, term: 2 })" target="_blank" class="text-sm font-semibold leading-6 text-gray-900 ml-4">Second Term Report <span aria-hidden="true">&rarr;</span></a>

        <span v-if="props.admission.school_class_id == studentclass.school_class_id && props.admission.term_admitted == 3"></span>

        <a v-else :href="route('view.student.report.third.term', { student : studentclass.student_id, studentclass: studentclass.id, term: 3 })" target="_blank" class="text-sm font-semibold leading-6 text-gray-900 ml-4">Third Term Report <span aria-hidden="true">&rarr;</span></a>

        <a :href="route('class.timetable', { schoolclass : studentclass.schoolclass.id })" target="_blank" class="text-sm font-semibold leading-6 text-gray-900 ml-4">See Timetable <span aria-hidden="true">&rarr;</span></a>
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
    'admission': Object,
})
</script>
