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
                      HWMS GRADING SYSTEM DETAILS.
                    </tr>
                  </thead>
                  <tbody class="divide-y divide-gray-200 bg-white">
                    <tr>
                      <td>
                        % Range.
                      </td>
                      <td>
                        Grade.
                      </td>
                      <td>
                        Remark.
                      </td>
                      <td>
                        
                      </td>
                      <td>
                        % Range.
                      </td>
                      <td>
                        Grade.
                      </td>
                      <td>
                        Remark.
                      </td>
                    </tr>
                    <tr>
                      <td>
                        90 - 100
                      </td>
                      <td>
                        A<sup>+</sup>
                      </td>
                      <td>
                        Distinction.
                      </td>
                      <td>
                        
                      </td>
                      <td>
                        50 - 59.9
                      </td>
                      <td>
                        C
                      </td>
                      <td>
                        Average.
                      </td>
                    </tr>
                    <tr>
                      <td>
                        80 - 89.9
                      </td>
                      <td>
                        A
                      </td>
                      <td>
                        Very Good.
                      </td>
                      <td>
                        
                      </td>
                      <td>
                        40- 49.9
                      </td>
                      <td>
                        D
                      </td>
                      <td>
                        Pass.
                      </td>
                    </tr>

                    <tr>
                      <td>
                        70 - 79.9
                      </td>
                      <td>
                        B<sup>+</sup>
                      </td>
                      <td>
                        Good.
                      </td>
                      <td>
                        
                      </td>
                      <td>
                        0 - 39.9
                      </td>
                      <td>
                        N.I.
                      </td>
                      <td>
                        Needs Improvement.
                      </td>
                    </tr>

                    <tr>
                      <td>
                        60 - 69.9
                      </td>
                      <td>
                        B
                      </td>
                      <td>
                        Above Average.
                      </td>
                      <td>
                        
                      </td>
                      <td>
                        
                      </td>
                      <td>
                        
                      </td>
                      <td>
                        
                      </td>
                    </tr>
                    
                    
                    <!-- Row for showing average of total, grade, and remark -->
                    
                  </tbody>
                </table>
              </form>

          </div>
        </div>
      </div>
    </div>
  </div>
</template>


<script setup>
import { ref, watch, computed } from 'vue';
import { useForm } from '@inertiajs/vue3';

// Initialize the form with empty subjects
const form = useForm({
  subjects: [],  // This will be populated based on classSubjects
  student: '',
  studentclass: '',
});


// The function to handle form submission
const upload = () => {
  form.post(
    route('post.student.report'),
    {
      preserveScroll: true,
      onSuccess: () => form.reset(),
    }
  );
};
</script>
