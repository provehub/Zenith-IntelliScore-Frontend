<script setup lang="ts">
import { DonutChart } from '@/components/ui/chart-donut'
import {
  Card,
  CardContent,
  CardDescription,
  CardHeader,
  CardTitle,
} from '@/components/ui/card'

const data = [
  { name: 'Properties', total: Math.floor(Math.random() * 2000) + 500, predicted: Math.floor(Math.random() * 2000) + 500 },
  { name: 'Commissions', total: Math.floor(Math.random() * 2000) + 500, predicted: Math.floor(Math.random() * 2000) + 500 },
]

const valueFormatter = (tick: number | Date) => typeof tick === 'number' ? `₦ ${new Intl.NumberFormat('us').format(tick).toString()}` : ''
</script>

<template>

<Card>
    <CardHeader class="pb-4">
      <CardTitle class="text-base">
        Properties Today
      </CardTitle>
      <CardDescription>Random data here for Zenith IntelliScore demo.</CardDescription>
    </CardHeader>
    <CardContent class="pb-2">

        <DonutChart
        class="h-52"
    index="name"
    :category="'total'"
    :data="data"
    :value-formatter="valueFormatter"
    :colors="['red', 'green']"
  />

    </CardContent>
    </Card>
  
</template>