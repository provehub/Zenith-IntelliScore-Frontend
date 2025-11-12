<template>
  <div class="px-4 sm:px-6 lg:px-8">
    <div class="mt-8 flow-root">
      <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
          <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 sm:rounded-lg">
            <form @submit.prevent="upload" class="py-2 px-2">
              <table class="min-w-full divide-y divide-gray-300">
                <thead class="bg-gray-50">
                  <tr>
                    <th colspan="2">Student Attendance</th>
                  </tr>
                </thead>
                <tbody v-if="$page.props.auth.user.user_type == 'admin' || $page.props.auth.user.user_type == 'teachers'" class="divide-y divide-gray-200 bg-white">
                  <tr>
                    <td>Times School Opened</td>
                    <td>
                      <input type="number" class="border-gray-300 rounded-md w-24" v-model="form.e1" required />
                    </td>
                  </tr>
                  <tr>
                    <td>Times Present</td>
                    <td>
                      <input type="number" class="border-gray-300 rounded-md w-24" v-model="form.present" required />
                    </td>
                  </tr>
                  <tr>
                    <td>Times Absent</td>
                    <td>
                      <input type="number" class="border-gray-300 rounded-md w-24" v-model="form.absent" required />
                    </td>
                  </tr>
                  <tr>
                    <td>Attendance Rating (%)</td>
                    <td>
                      <input type="number" class="border-gray-300 rounded-md w-24" v-model="attendancePercentage" readonly />
                    </td>
                  </tr>
                </tbody>
                <tbody v-else class="divide-y divide-gray-200 bg-white">
                  <tr>
                    <td>Times School Opened</td>
                    <td>
                      <span class="border-gray-300 rounded-md w-24"> {{ form.e1 }} </span>
                    </td>
                  </tr>
                  <tr>
                    <td>Times Present</td>
                    <td>
                      <span class="border-gray-300 rounded-md w-24"> {{ form.present }} </span>
                    </td>
                  </tr>
                  <tr>
                    <td>Times Absent</td>
                    <td>
                      <span class="border-gray-300 rounded-md w-24"> {{ form.absent }} </span>
                    </td>
                  </tr>
                  <tr>
                    <td>Attendance Rating </td>
                    <td>
                      <span class="border-gray-300 rounded-md w-24"> {{ attendancePercentage }}(%) </span>
                    </td>
                  </tr>
                </tbody>
              </table>
              <div class="mt-4 sm:ml-16 sm:mt-0 flex justify-end">
                <button v-if="$page.props.auth.user.user_type == 'admin' || $page.props.auth.user.user_type == 'teachers'"
                  class="block rounded-md bg-indigo-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                  :class="{ 'opacity-25': form.processing }"
                  :disabled="form.processing">
                  Save
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="js">
import { ref, watch, computed } from 'vue';
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
  attendance: Object,
  term: Number,
  student_id: Number,
  student_class_id: Number,
});

// Initialize the form with empty subjects
const form = useForm({
  present: props.attendance && props.attendance.present ? props.attendance.present : '',
  absent: props.attendance && props.attendance.absent ? props.attendance.absent : '',
  e1: props.attendance && props.attendance.e1 ? props.attendance.e1 : '',
  e2: props.attendance && props.attendance.e2 ? props.attendance.e2 : '',
});


// Computed property to calculate attendance percentage
const attendancePercentage = computed(() => {
  if (form.e1 && form.present) {
    return form.e2 = ((form.present / form.e1) * 100).toFixed(2);
  }
  return 0;
});

// The function to handle form submission
const upload = () => {
  form.post(
    route('post.student.attendance', { student: props.student_id, studentclass: props.student_class_id, term: props.term }),
    {
      preserveScroll: true,
      onSuccess: () => form.reset(),
    }
  );
};

// Watch for changes in form.recentlySuccessful
watch(() => form.recentlySuccessful, (newValue) => {
  if (newValue) {
    // Perform a hard refresh
    window.location.reload();
  }
});
</script>
