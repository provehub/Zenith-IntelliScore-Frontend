<template>
  <div class="px-4 sm:px-6 lg:px-8">
    <div class="mt-8 flow-root">
      <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
          <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 sm:rounded-lg">
            <div v-if="form.subjects.length > 0">

              <form @submit.prevent="upload" class="py-2 px-2">
                <table class="min-w-full divide-y divide-gray-300">
                  <thead class="bg-gray-50">
                    <tr>
                      <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">SUBJECT</th>
                      <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">CA1 (20)</th>
                      <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">CA2 (20)</th>
                      <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Exam (60)</th>
                      <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">TOTAL (100)</th>
                      <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">1st Term<br> (100)</th>
                      <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Cum. Avg.<br> (100)</th>
                      <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">GRADE</th>
                      <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">REMARK</th>
                    </tr>
                  </thead>
                  <tbody class="divide-y divide-gray-200 bg-white">
                    <tr v-for="(subject, index) in form.subjects" :key="subject.class_subject_id">
                      <td>{{ classSubjects[index]?.name }}</td>
                      <td>
                        <input v-if="$page.props.auth.user.user_type == 'admin' || $page.props.auth.user.user_type == 'teachers'" v-model="form.subjects[index].ca1" type="number" class="border-gray-300 rounded-md w-16" />
                        <span v-else>{{ form.subjects[index].ca1 }}</span>
                      </td>
                      <td>
                        <input v-if="$page.props.auth.user.user_type == 'admin' || $page.props.auth.user.user_type == 'teachers'" v-model="form.subjects[index].ca2" type="number" class="border-gray-300 rounded-md w-16" />
                        <span v-else>{{ form.subjects[index].ca2 }}</span>
                      </td>
                      <td>
                        <input v-if="$page.props.auth.user.user_type == 'admin' || $page.props.auth.user.user_type == 'teachers'" v-model="form.subjects[index].exam" type="number" class="border-gray-300 rounded-md w-16" />
                        <span v-else>{{ form.subjects[index].exam }}</span>
                      </td>
                      <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ form.subjects[index].total || 0 }}</td>
                      <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ form.subjects[index].firstTerm.total || 0 }}</td>
                      <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ form.subjects[index].cumulativeAverage || 0 }}
                      </td>
                      <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ form.subjects[index].grade }}</td>
                      <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ form.subjects[index].remark }}</td>
                    </tr>
                    <!-- Row for showing average of total, grade, and remark -->
                    <tr>
                      <td>Average (%)</td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ averageData.averageTotal }}</td>
                      <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ averageData.averageGrade }}</td>
                      <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ averageData.averageRemark }}</td>
                    </tr>
                  </tbody>
                </table>
      <div class="mt-4 sm:ml-16 sm:mt-0 flex justify-end">
        <button v-if="$page.props.auth.user.user_type == 'admin' || $page.props.auth.user.user_type == 'teachers'"
              class="block rounded-md bg-indigo-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600" :class="{ 'opacity-25': form.processing }"
              :disabled="form.processing">
              Save
            </button>
      </div>
              </form>
            </div>

            <div v-else>
              <p>Loading subjects...</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>


<script setup>
import { ref, watch, computed } from 'vue';
import { useForm } from '@inertiajs/vue3';

// Define props to receive studentclass
const props = defineProps({
  studentclass: Object, 
  grade: Object, 
});

// Initialize classSubjects as a ref
const classSubjects = ref([]);


// Initialize the form with empty subjects
const form = useForm({
  subjects: [],  // This will be populated based on classSubjects
  student: '',
  studentclass: '',
});

// Function to calculate grade based on total
const calculateGrade = (total) => {
  if (total >= 90) return { grade: 'A+', remark: 'Distinction' };
  if (total >= 80) return { grade: 'A', remark: 'Very Good' };
  if (total >= 70) return { grade: 'B+', remark: 'Good' };
  if (total >= 60) return { grade: 'B', remark: 'Above Average' };
  if (total >= 50) return { grade: 'C', remark: 'Average' };
  if (total >= 40) return { grade: 'D', remark: 'Pass' };
  return { grade: 'N.I.', remark: 'Needs Improvement' }; // For scores below 40
};

// Watch classSubjects and update form.subjects when it changes
// Watch the grade prop and update classSubjects when it changes
watch(() => props.grade, (newGrade) => {
  if (Array.isArray(newGrade)) {
    // Populate classSubjects with unique subjects from the grades
    classSubjects.value = newGrade.map(grade => grade.first_term.classsubject).filter((subject, index, self) =>
      subject && index === self.findIndex(s => s.id === subject.id)
    );
  } else if (newGrade?.first_term?.classsubject) {
    // If newGrade is a single object, add its classsubject
    classSubjects.value = [newGrade.first_term.classsubject];
  } else {
    classSubjects.value = [];
  }
}, { immediate: true });

// Watch the grade prop and update form.subjects when it changes
watch(() => props.grade, (newGrade) => {
  if (Array.isArray(newGrade)) {
    form.subjects = newGrade.map(grade => ({
      class_subject_id: grade.second_term.class_subject_id,
      ca1: grade.second_term.ca1 || 0,
      ca2: grade.second_term.ca2 || 0,
      exam: grade.second_term.exam || 0,
      total: (grade.second_term.ca1 || 0) + (grade.second_term.ca2 || 0) + (grade.second_term.exam || 0), // Second term total initialized
      firstTerm: {
        ca1: grade.first_term?.ca1 || 0,
        ca2: grade.first_term?.ca2 || 0,
        exam: grade.first_term?.exam || 0,
        total: (grade.first_term?.ca1 || 0) + (grade.first_term?.ca2 || 0) + (grade.first_term?.exam || 0), // First term total initialized
      },
      cumulativeAverage: 0, // Initialize with 0
      comments: grade.second_term.comments,
      academic_session: grade.second_term.academic_session,
      term: 2,
      e1: grade.second_term.e1,
      e2: grade.second_term.e2,
      e3: grade.second_term.e3,
      grade: '', // Will be calculated later
      remark: '' // Will be calculated later
    }));

    // Calculate initial grade, remark, and cumulative average for each subject
    form.subjects.forEach((subject, index) => {
      const { grade, remark } = calculateGrade(subject.total);
      form.subjects[index].grade = grade;
      form.subjects[index].remark = remark;

      // Calculate cumulative average
      const firstTermTotal = subject.firstTerm?.total || 0;
      const cumulativeAverage = (subject.total + firstTermTotal) / 2;
      form.subjects[index].cumulativeAverage = cumulativeAverage.toFixed(2);
    });
  }
}, { immediate: true });



// Watch ca1, ca2, and exam to dynamically calculate the total, grade, and remark
watch(
  () => form.subjects,
  (newSubjects) => {
    newSubjects.forEach((subject, index) => {
      const ca1 = parseInt(subject.ca1) || 0;
      const ca2 = parseInt(subject.ca2) || 0;
      const exam = parseInt(subject.exam) || 0;

      // Calculate second term total
      const total = ca1 + ca2 + exam;
      form.subjects[index].total = total;

      // Calculate grade and remark for second term
      const { grade, remark } = calculateGrade(total);
      form.subjects[index].grade = grade;
      form.subjects[index].remark = remark;

      // Calculate cumulative average
      const firstTermTotal = parseInt(subject.firstTerm?.total) || 0;
      const cumulativeAverage = (total + firstTermTotal) / 2;
      form.subjects[index].cumulativeAverage = cumulativeAverage.toFixed(2);
    });
  },
  { deep: true }
);



// Computed property for calculating averages
const averageData = computed(() => {
  if (form.subjects.length === 0) {
    return { averageTotal: 0, averageGrade: '', averageRemark: '' };
  }

  const totalSum = form.subjects.reduce((sum, subject) => sum + subject.total, 0);
  const averageTotal = totalSum / form.subjects.length; // Calculate average total

  // Calculate average grade and remark based on the total average
  const { grade: averageGrade, remark: averageRemark } = calculateGrade(averageTotal);

  return { averageTotal: averageTotal.toFixed(2), averageGrade, averageRemark };
});

// const c = { student: props.studentclass?.student_id, studentclass: props.studentclass?.id};
// The function to handle form submission
const upload = () => {
  form.post(
    route('post.student.report',{ student: props.studentclass?.student_id, studentclass: props.studentclass?.id }),
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
