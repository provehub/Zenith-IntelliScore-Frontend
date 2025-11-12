<template>
  <div class="px-4 sm:px-6 lg:px-8">
    

    <div class="mt-8 flow-root">
      <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
          <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 sm:rounded-lg">
              <form @submit.prevent="upload" class="py-2 px-2">
                <table class="min-w-full divide-y divide-gray-300">
                  
                  <tbody class="divide-y divide-gray-200 bg-white">
                    <tr>
                      <td>
                        Next Term Begins:
                      </td>
                      
                    </tr>
                    <tr>
                      <td>
                        {{ props.begins }}
                      </td>
                      
                    </tr>
                    <tr v-if="$page.props.auth.user.user_type == 'admin' || $page.props.auth.user.user_type == 'teachers'">
                      <td>
                        <input type="date" v-model="form.begins" class="border-gray-300 rounded-md" required />
                      </td>
                    </tr>
                    
                    
                    <!-- Row for showing average of total, grade, and remark -->
                    
                  </tbody>
                </table>
      <div class="mt-4 sm:ml-16 sm:mt-0 flex justify-end" v-if="$page.props.auth.user.user_type == 'admin' || $page.props.auth.user.user_type == 'teachers'">
        <button v-if="$page.props.auth.user.user_type == 'admin' || $page.props.auth.user.user_type == 'teachers'"
              class="block rounded-md bg-indigo-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600" :class="{ 'opacity-25': form.processing }"
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


<script setup>
import { ref, watch, computed } from 'vue';
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
  grade: Number,
  begins: String,
});

// Initialize the form with empty subjects
const form = useForm({
  begins: '',
});


// The function to handle form submission
const upload = () => {
  form.post(
    route('post.student.report.nexttermbegins', { grade: props.grade }),
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
