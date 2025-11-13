<script setup>
import { ref, onMounted, onBeforeUnmount } from 'vue'
import * as faceapi from 'face-api.js'
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
    'vendor': Object,
})

const videoRef = ref(null)
const canvasRef = ref(null)
const statusMsg = ref('Click "Start AI Liveness"')
const livenessPassed = ref(false)
const loading = ref(true)
const livenessStep = ref(parseInt(localStorage.getItem('liveness_step') || '0'))
const detectedAge = ref(null)
const detectedGender = ref(null)
const snapshots = ref([])
const showVerifying = ref(false)
const steps = [
  { label: 'Open Mouth', icon: '👄' },
  { label: 'Turn Left', icon: '👈' },
  { label: 'Turn Right', icon: '👉' },
]

let detectInterval = null
let stream = null

const loadModels = async () => {
  statusMsg.value = "Loading face detection models..."
  await faceapi.nets.tinyFaceDetector.load('/models/')
  await faceapi.nets.faceLandmark68Net.load('/models/')
  await faceapi.nets.ageGenderNet.load('/models/')
  loading.value = false
  statusMsg.value = "Click 'Start AI Liveness' to begin."
}

onMounted(loadModels)
onBeforeUnmount(() => {
  if (detectInterval) clearInterval(detectInterval)
  if (stream) stream.getTracks().forEach(track => track.stop())
})

const drawOverlay = (detection) => {
  const canvas = canvasRef.value
  const video = videoRef.value
  if (!canvas || !video) return
  const ctx = canvas.getContext('2d')
  ctx.clearRect(0, 0, canvas.width, canvas.height)

  // Responsive oval: always taller than wide
  const ovalW = canvas.width * 0.34    // about 68% of width, adjust as needed
  const ovalH = canvas.height * 0.48   // about 96% of height, adjust as needed

  ctx.save()
  ctx.strokeStyle = '#B22222'
  ctx.lineWidth = 4
  ctx.globalAlpha = 0.7
  ctx.beginPath()
  ctx.ellipse(
    canvas.width / 2,
    canvas.height / 2,
    ovalW,
    ovalH,
    0,
    0,
    2 * Math.PI
  )
  ctx.stroke()
  ctx.globalAlpha = 1
  ctx.restore()

  // Draw face rectangle if detected
  if (detection && detection.detection && detection.detection.box) {
    ctx.save()
    ctx.strokeStyle = 'lime'
    ctx.lineWidth = 3
    const box = detection.detection.box
    ctx.strokeRect(box.x, box.y, box.width, box.height)
    ctx.restore()
  }
}


const resetProgress = () => {
  livenessStep.value = 0
  localStorage.setItem('liveness_step', '0')
  livenessPassed.value = false
  snapshots.value = []
  detectedAge.value = null
  detectedGender.value = null
}

const nextStep = () => {
  livenessStep.value += 1
  localStorage.setItem('liveness_step', livenessStep.value.toString())
}

const takeSnapshot = () => {
  const video = videoRef.value
  if (!video) return
  const canvas = document.createElement('canvas')
  canvas.width = video.videoWidth
  canvas.height = video.videoHeight
  const ctx = canvas.getContext('2d')
  ctx.drawImage(video, 0, 0, canvas.width, canvas.height)
  return canvas.toDataURL('image/jpeg', 0.85)
}

function dataURLtoFile(dataurl, filename) {
  const arr = dataurl.split(',');
  const mime = arr[0].match(/:(.*?);/)[1];
  const bstr = atob(arr[1]);
  let n = bstr.length;
  const u8arr = new Uint8Array(n);
  while (n--) {
    u8arr[n] = bstr.charCodeAt(n);
  }
  return new File([u8arr], filename, { type: mime });
}



  const form = useForm({
    project_id: props.vendor.id,
    extras: props.vendor.id,
    age: null,
    gender: null,
    steps: ['mouth_open', 'turn_left', 'turn_right'],
    snapshots: [],
});

const sendResult = () => {
  // Convert each snapshot to File
  form.snapshots = snapshots.value.map((snap, i) =>
    dataURLtoFile(snap, `snapshot_${i + 1}.jpg`)
  )
  form.age = detectedAge.value
  form.gender = detectedGender.value
  form.steps = ['mouth_open', 'turn_left', 'turn_right']

  form.post(
    route('create.liveness'),
    {
      preserveScroll: true,
      onSuccess: () => form.reset(),
    }
  )
}



const startLiveness = async () => {
  resetProgress()
  statusMsg.value = "Initializing camera..."
  livenessPassed.value = false
  stream = await navigator.mediaDevices.getUserMedia({ video: true })
  videoRef.value.srcObject = stream
  setTimeout(() => {
    const v = videoRef.value
    const c = canvasRef.value
    if (v && c) {
      c.width = v.videoWidth || 320
      c.height = v.videoHeight || 240
    }
  }, 500)

  detectInterval = setInterval(async () => {
    const detection = await faceapi
      .detectSingleFace(videoRef.value, new faceapi.TinyFaceDetectorOptions())
      .withFaceLandmarks()
      .withAgeAndGender()
    drawOverlay(detection)
    if (detection && detection.landmarks) {
      detectedAge.value = detection.age ? detection.age.toFixed(1) : null
      detectedGender.value = detection.gender || null
      // STEP 0: MOUTH OPEN
      if (livenessStep.value === 0) {
        statusMsg.value = "Step 1: Open your mouth wide"
        const topLip = detection.landmarks.positions[62]
        const bottomLip = detection.landmarks.positions[66]
        const mouthOpen = Math.abs(topLip.y - bottomLip.y) > 18
        if (mouthOpen) {
          snapshots.value.push(takeSnapshot())
          nextStep()
          statusMsg.value = "Step 2: Turn your head LEFT"
        }
      }
      // STEP 1: TURN LEFT
      else if (livenessStep.value === 1) {
        statusMsg.value = "Step 2: Turn your head LEFT"
        const leftCheek = detection.landmarks.positions[1].x
        const rightCheek = detection.landmarks.positions[15].x
        const nose = detection.landmarks.positions[30].x
        if (nose - leftCheek < (rightCheek - leftCheek) * 0.25) {
          snapshots.value.push(takeSnapshot())
          nextStep()
          statusMsg.value = "Step 3: Turn your head RIGHT"
        }
      }
      // STEP 2: TURN RIGHT
      else if (livenessStep.value === 2) {
        statusMsg.value = "Step 3: Turn your head RIGHT"
        const leftCheek = detection.landmarks.positions[1].x
        const rightCheek = detection.landmarks.positions[15].x
        const nose = detection.landmarks.positions[30].x
        if (rightCheek - nose < (rightCheek - leftCheek) * 0.25) {
          snapshots.value.push(takeSnapshot())
          livenessPassed.value = true
          statusMsg.value = "✅ All checks passed!"
          localStorage.removeItem('liveness_step')
          clearInterval(detectInterval)
          setTimeout(() => {
            if (stream) stream.getTracks().forEach(track => track.stop())
            videoRef.value.srcObject = null
            drawOverlay(null)
            sendResult()
          }, 1200)
        }
      }
    } else {
      detectedAge.value = null
      detectedGender.value = null
      if (!livenessPassed.value) statusMsg.value = "Align your face in the red oval"
      drawOverlay(null)
    }
  }, 250)
}
</script>

<template>
  
  <div class="w-full max-w-xs sm:max-w-md mx-auto my-8 p-4 rounded-2xl bg-white shadow-xl flex flex-col items-center">
    <p>Hi {{ vendor.name }}</p><br>
    <!-- Step Progress Bar -->
    <div class="flex items-center justify-center mb-3 w-full">
      

      <template v-for="(step, idx) in steps" :key="step.label">
        <div class="flex flex-col items-center">
          <div
            :class="[
              'w-8 h-8 flex items-center justify-center rounded-full text-xl font-bold',
              livenessStep > idx || livenessPassed ? 'bg-gray-500 text-white' :
              livenessStep === idx ? 'bg-red-500 text-white animate-pulse' : 'bg-gray-200 text-gray-500'
            ]"
          >
            {{ step.icon }}
          </div>
          <span class="text-xs mt-1 font-medium text-gray-600">{{ step.label }}</span>
        </div>
        <div
          v-if="idx < steps.length-1"
          :key="step.label + '-divider'"
          class="w-10 h-1 bg-gray-200 mx-1"
        ></div>
      </template>
    </div>

    <button
      class="bg-gray-600 hover:bg-gray-700 text-white px-5 py-2 rounded-xl font-semibold mb-4 w-full"
      :disabled="loading || livenessPassed || showVerifying"
      @click="startLiveness"
    >
      {{ loading ? 'Loading Models...' : (livenessPassed ? 'Checks Complete' : 'Start AI Liveness') }}
    </button>
    <!-- <button v-if="livenessStep > 0 && !livenessPassed && !showVerifying"
      class="mb-2 text-red-700 underline" @click="resetProgress">
      Restart Check
    </button> -->

    <div class="mb-3 text-center font-medium text-gray-700 min-h-[2em]">
      <span v-if="!showVerifying">{{ statusMsg }}</span>
      <span v-if="showVerifying" class="flex items-center justify-center gap-2">
        <svg class="animate-spin h-5 w-5 text-red-500" fill="none" viewBox="0 0 24 24">
          <circle class="opacity-25" cx="12" cy="12" r="10"
            stroke="currentColor" stroke-width="4"></circle>
          <path class="opacity-75" fill="currentColor"
            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
        </svg>
        Verifying... Please wait
      </span>
    </div>

    <div class="relative w-full" style="aspect-ratio: 4/3;">
      <video
        ref="videoRef"
        autoplay
        playsinline
        muted
        class="rounded-xl w-full h-auto object-cover bg-gray-900"
        style="aspect-ratio: 4/3;"
      ></video>
      <canvas
        ref="canvasRef"
        class="absolute top-0 left-0 w-full h-full pointer-events-none"
        style="aspect-ratio: 4/3;"
      ></canvas>
      <!-- Live Age/Gender -->
      <div
        v-if="detectedAge && detectedGender && !livenessPassed"
        class="absolute top-2 left-2 bg-white/80 text-xs px-3 py-1 rounded-xl shadow font-semibold text-gray-800 pointer-events-none"
      >
        Age: {{ detectedAge }}<br>
        Gender: {{ detectedGender }}
      </div>
    </div>

    <!-- Snapshots after completion -->
    <div v-if="livenessPassed && snapshots.length"
      class="w-full flex gap-2 justify-center items-center mt-5">
      <div v-for="(snap, idx) in snapshots" :key="idx"
        class="flex flex-col items-center">
        <img :src="snap" alt="step" class="w-16 h-16 object-cover rounded border" />
        <div class="text-xs mt-1 text-gray-600">{{ steps[idx].label }}</div>
      </div>
    </div>

    <div v-if="livenessPassed" class="mt-4 text-gray-700 font-bold text-lg">
      🎉 Liveness Passed!
    </div>
    <div v-if="livenessPassed && detectedAge && detectedGender"
      class="mt-2 text-sm text-gray-500 font-medium">
      Result: Age {{ detectedAge }}, Gender {{ detectedGender }}
    </div>
  </div>
</template>
