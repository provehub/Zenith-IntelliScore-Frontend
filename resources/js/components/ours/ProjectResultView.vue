<template>
  <div class="max-w-3xl mx-auto p-6 space-y-8">
    <!-- Header -->
    <div class="flex items-center justify-between">
      <div>
        <h1 class="text-xl font-semibold text-gray-900">Zenith IntelliScore Result</h1>
        <p class="text-sm text-gray-500 mt-1">
          {{ data.account_name }} • {{ maskedAccount }} • {{ data.period }}
        </p>
      </div>

      <span
        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold"
        :class="riskClass"
      >
        Risk Band: {{ riskBand }}
      </span>
    </div>

    <!-- Score + PD -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
      <div class="md:col-span-2 bg-white border rounded-xl p-5 shadow-sm relative overflow-hidden">
        <div class="flex items-center justify-between">
          <div>
            <div class="text-gray-500 text-sm">Credit Trust Score</div>
            <div class="text-4xl font-bold text-gray-900">
              {{ trustScore }}
              <span class="text-base text-gray-400 font-normal">/ 1000</span>
            </div>
          </div>

          <div
            class="w-20 h-20 rounded-full border-4 flex items-center justify-center"
            :class="circleClass"
          >
            <span class="text-sm font-semibold">
              {{ riskBand }}
            </span>
          </div>
        </div>

        <div class="mt-4 text-sm text-gray-600">
          Lower default probability = higher trust score.
        </div>
      </div>

      <div class="bg-white border rounded-xl p-5 shadow-sm">
        <div class="font-semibold text-gray-900 mb-2">Probability of Default</div>
        <div class="text-2xl font-bold text-gray-900">
          {{ (pdValue * 100).toFixed(2) }}%
        </div>
        <p class="text-xs text-gray-500 mt-1">
          Estimated likelihood of default within the next 90 days.
        </p>
      </div>
    </div>

    <!-- Score Gauge -->
    <div class="bg-white border rounded-xl p-5 shadow-sm">
      <div class="flex items-center justify-between mb-4">
        <h2 class="text-base font-semibold text-gray-900">
          Score Gauge
        </h2>
        <div class="flex items-center gap-2 text-xs">
          <span class="inline-flex items-center">
            <span class="w-3 h-3 rounded-full bg-green-500 mr-1"></span> A (800–1000)
          </span>
          <span class="inline-flex items-center">
            <span class="w-3 h-3 rounded-full bg-lime-500 mr-1"></span> B (650–799)
          </span>
          <span class="inline-flex items-center">
            <span class="w-3 h-3 rounded-full bg-amber-500 mr-1"></span> C (500–649)
          </span>
          <span class="inline-flex items-center">
            <span class="w-3 h-3 rounded-full bg-red-500 mr-1"></span> D (0–499)
          </span>
        </div>
      </div>

      <div class="flex flex-col items-center">
        <svg viewBox="0 0 200 120" class="w-full max-w-md">
          <!-- Light track (full semicircle) -->
          <path
            d="M10 110 A90 90 0 0 1 190 110"
            fill="none"
            stroke="#E5E7EB"
            stroke-width="14"
          />

          <!-- D band (0–500) -->
          <path
            d="M10 110 A90 90 0 0 1 100 20"
            fill="none"
            stroke="#F87171"
            stroke-width="8"
          />
          <!-- C band (500–650) -->
          <path
            d="M100 20 A90 90 0 0 1 140.9 29.8"
            fill="none"
            stroke="#FBBF24"
            stroke-width="8"
          />
          <!-- B band (650–800) -->
          <path
            d="M140.9 29.8 A90 90 0 0 1 172.8 57.1"
            fill="none"
            stroke="#84CC16"
            stroke-width="8"
          />
          <!-- A band (800–1000) -->
          <path
            d="M172.8 57.1 A90 90 0 0 1 190 110"
            fill="none"
            stroke="#22C55E"
            stroke-width="8"
          />

          <!-- Needle -->
          <g :style="needleStyle">
            <line
              x1="100"
              y1="110"
              x2="100"
              y2="35"
              stroke="#111827"
              stroke-width="3"
              stroke-linecap="round"
            />
            <circle cx="100" cy="110" r="5" fill="#111827" />
          </g>

          <!-- Ticks -->
          <text x="10" y="118" font-size="9" fill="#6B7280">0</text>
          <text x="55" y="118" font-size="9" fill="#6B7280">250</text>
          <text x="100" y="118" font-size="9" fill="#6B7280" text-anchor="middle">500</text>
          <text x="145" y="118" font-size="9" fill="#6B7280" text-anchor="end">750</text>
          <text x="190" y="118" font-size="9" fill="#6B7280" text-anchor="end">1000</text>
        </svg>

        <div class="mt-2 text-xs text-gray-500">
          Needle position reflects the current credit trust score on a 0–1000 scale.
        </div>
      </div>
    </div>

    <!-- Explanations -->
    <div class="bg-white border rounded-xl p-5 shadow-sm">
      <h2 class="text-base font-semibold text-gray-900 mb-4">
        Top Factors Driving This Score
      </h2>

      <ul v-if="explanations.length" class="divide-y divide-gray-100">
        <li
          v-for="(item, idx) in explanations"
          :key="idx"
          class="py-3 flex justify-between items-start"
        >
          <div>
            <div class="font-medium text-gray-900 text-sm">{{ item.label }}</div>
            <div class="text-xs text-gray-500 leading-relaxed">
              {{ item.detail }}
            </div>
          </div>

          <span
            class="text-xs font-semibold ml-4"
            :class="item.impact >= 0 ? 'text-red-600' : 'text-green-600'"
          >
            {{ item.impact.toFixed(3) }}
          </span>
        </li>
      </ul>

      <p v-else class="text-sm text-gray-500">
        No explanation data available for this assessment.
      </p>
    </div>

    <!-- Debug -->
    <details class="bg-gray-50 border rounded-xl p-4 text-xs text-gray-600">
      <summary class="cursor-pointer font-semibold">Developer Debug Data</summary>
      <pre class="mt-3 whitespace-pre-wrap">
{{ JSON.stringify(data, null, 2) }}
      </pre>
    </details>
  </div>
</template>

<script setup lang="js">
import { computed } from 'vue'

const props = defineProps({
  data: { type: Object, required: true },
})

const data = props.data

const pdValue = computed(() => {
  if (data.score && data.score.pd_90d != null) return Number(data.score.pd_90d)
  if (data.pd_90d != null) return Number(data.pd_90d)
  return 0
})

const trustScore = computed(() => {
  if (data.credit_trust_score != null) return Number(data.credit_trust_score)
  if (data.score && data.score.credit_trust_score != null) return Number(data.score.credit_trust_score)
  return 0
})

const riskBand = computed(() => data.risk_band || (data.score && data.score.risk_band) || 'N/A')

const maskedAccount = computed(() => {
  const n = data.account_no || ''
  return n ? '***' + n.slice(-4) : ''
})

const riskClass = computed(() => {
  switch (riskBand.value) {
    case 'A': return 'bg-green-100 text-green-800'
    case 'B': return 'bg-lime-100 text-lime-800'
    case 'C': return 'bg-amber-100 text-amber-800'
    case 'D': return 'bg-red-100 text-red-800'
    default:  return 'bg-gray-100 text-gray-800'
  }
})

const circleClass = computed(() => {
  switch (riskBand.value) {
    case 'A': return 'border-green-500 text-green-700'
    case 'B': return 'border-lime-500 text-lime-700'
    case 'C': return 'border-amber-500 text-amber-700'
    case 'D': return 'border-red-500 text-red-700'
    default:  return 'border-gray-400 text-gray-600'
  }
})

// 0–1000 mapped to -90..+90 deg (left → up → right), center at (100,110)
const needleStyle = computed(() => {
  const score = Math.max(0, Math.min(1000, trustScore.value || 0))
  const angle = -90 + (score / 1000) * 180   // 0→-90° (left), 500→0° (up), 1000→+90° (right)
  return {
    transform: `rotate(${angle}deg)`,
    transformOrigin: '100px 110px',
  }
})


const explanations = computed(() => {
  const list = (data.score && Array.isArray(data.score.top_feature_impacts))
    ? data.score.top_feature_impacts
    : []

  return list.map((item) => {
    const feature = item.feature || ''
    const value   = item.value
    const impact  = Number(item.impact || 0)
    const label   = featureLabel(feature)
    const direction = impact >= 0 ? 'increases risk' : 'reduces risk'
    const valueStr  = typeof value === 'number'
      ? value.toLocaleString('en-NG', { maximumFractionDigits: 2 })
      : String(value)
    const detail = `${label} (value: ${valueStr}) ${direction}.`
    return { label, detail, impact }
  })
})

function featureLabel(key) {
  switch (key) {
    case 'pos_volume_90d_ngn':    return 'Spending volume (last 90 days)'
    case 'pos_txn_cnt_90d':       return 'Transaction count (last 90 days)'
    case 'salary_inflow_90d_ngn': return 'Salary inflow (last 90 days)'
    case 'net_inflow_90d_ngn':    return 'Net inflow (last 90 days)'
    case 'tel_inactive_days_90d': return 'Inactive days on line (90 days)'
    case 'tel_topups_cnt_90d':    return 'Airtime top-ups (90 days)'
    case 'util_late_cnt_90d':     return 'Late utility payments (90 days)'
    default:
      return key.split('_').map(p => p.charAt(0).toUpperCase() + p.slice(1)).join(' ')
  }
}
</script>
