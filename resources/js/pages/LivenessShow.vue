<script setup>
import { computed,ref } from 'vue'
import Modal from '@/Components/Modal.vue';
import ProjectResultView from '@/components/ours/ProjectResultView.vue';

const props = defineProps({
    vendor: [String, Number],
    extras: [String, Number],
    result: Object,
    ass: Object,
})

const snapshots = computed(() =>
    Array.isArray(props.result?.snapshots)
      ? props.result.snapshots
      : []
)

const confirmingDocuments = ref(false);
const dataFromButton = ref([]);

const confirmDocuments = (data) => {
    dataFromButton.value = data;
    confirmingDocuments.value = true;
};

const closeModalDocuments = () => {
    confirmingDocuments.value = false;
};

</script>

<template>
  <!-- {{ props.ass }} -->
  <div class="max-w-lg mx-auto my-10 p-6 bg-white rounded-xl shadow">
    <h1 class="text-2xl font-bold mb-4">Liveness Result for Account #{{ vendor }}</h1>
    <div v-if="!result" class="text-gray-500">No result found for this account.</div>
    <div v-else>
      <div class="mb-3 text-gray-700">
        <div><b>Extras:</b> {{ extras }}</div>
        <div><b>Submitted:</b> {{ result.created_at ? new Date(result.created_at).toLocaleString() : 'N/A' }}</div>
        <div><b>Age:</b> {{ result.age ?? 'N/A' }}</div>
        <div><b>Gender:</b> {{ result.gender ?? 'N/A' }}</div>
        <div>
          <b>Steps:</b>
          <br>
          <span v-for="(step, idx) in result.steps" :key="idx"
            class="inline-block bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs mr-2 mb-1">
            {{ step }}
          </span>
        </div>
      </div>
      <div class="flex gap-3 flex-wrap mt-3">
        <div v-for="(img, idx) in snapshots" :key="idx" class="flex flex-col items-center">
          
            <img @click="confirmDocuments(img)" :src="`/storage/${img}`" class="w-20 h-20 object-cover rounded border" alt="Snapshot" />
          
          <span class="text-xs mt-1 text-gray-600">Step {{ idx+1 }}</span>
        </div>
      </div>
    </div>
  </div>


<Modal :show="confirmingDocuments" @close="closeModalDocuments" >
                    <img :src="`/storage/${dataFromButton}`" class="w-fit h-fit object-cover rounded border" alt="Snapshot" />
                </Modal>


                <!-- result scoring -->
         <ProjectResultView :data="props.ass" />
        <!-- result scoring -->

</template>
