<script setup lang="js">
import { Button } from '@/components/ui/button'
import {
  Dialog,
  DialogContent,
  DialogDescription,
  DialogFooter,
  DialogHeader,
  DialogTitle,
  DialogTrigger,
} from '@/components/ui/dialog'
import InputError from '@/components/InputError.vue';
import { Input } from '@/components/ui/input'
import { Textarea } from "@/components/ui/textarea"
import { Label } from '@/components/ui/label'
import { useForm } from '@inertiajs/vue3';

import { today, DateFormatter, getLocalTimeZone } from '@internationalized/date'

import { Calendar as CalendarIcon } from 'lucide-vue-next'
import { ref, watch } from 'vue'
import { cn } from '@/lib/utils'
import {
  Popover,
  PopoverContent,
  PopoverTrigger,
} from '@/components/ui/popover'
import { RangeCalendar } from '@/components/ui/range-calendar'

import {
  Select,
  SelectContent,
  SelectGroup,
  SelectItem,
  SelectLabel,
  SelectTrigger,
  SelectValue,
} from "@/components/ui/select"


const df = new DateFormatter('en-US', {
  dateStyle: 'medium',
})

// const calendarDate = new CalendarDate(2025, 0, 20)

const calendarDate = today(getLocalTimeZone())


// const calendarDate = CalendarDate.fromDate(new Date(), getLocalTimeZone())


const value = ref({
  start: calendarDate,
  end: calendarDate.add({ days: 29 }),
})

const props = defineProps({
    'message': String,
})

const pricePerSession = ref(1000) // e.g. ₦5,000 per post

const form = useForm({
  name: '',
  audience: '',
  facebook: 0,
  instagram: 0,
  youtube: 0,
  tiktok: 0,
  linkedin: 0,
  x: 0,
  frequency: '',
  start_date: value.value.start ? value.value.start.toString() : '',
  end_date: value.value.end ? value.value.end.toString() : '',
  amount: 0,
});

const submit = () => {
    form.post(route('project.store.new.campaign'), {
        preserveScroll: true,
        onFinish: () => form.reset(),

    });
};

watch(() => form.recentlySuccessful, (newValue) => {
    if (newValue) {
        // Perform a hard refresh
        window.location.reload();
    }
});




// --- helpers
function parseYMD(ymd) {
  // expects "YYYY-MM-DD"
  if (!ymd) return null
  const [y, m, d] = ymd.split('-').map(Number)
  // construct as UTC to avoid TZ shifts
  return new Date(Date.UTC(y, m - 1, d))
}

function daysBetweenInclusive(startStr, endStr) {
  const s = parseYMD(startStr)
  const e = parseYMD(endStr)
  if (!s || !e) return 0
  const ms = e - s
  if (ms < 0) return 0
  // +1 to count both start and end dates
  return Math.floor(ms / (1000 * 60 * 60 * 24)) + 1
}

function weeksFromDays(days) {
  // count partial weeks as a whole week
  return Math.ceil(days / 7)
}

function monthsFromDays(days) {
  // simple, predictable: 30-day months for pricing buckets
  return Math.max(1, Math.ceil(days / 30))
}

function sessionsForFrequency(freq, startStr, endStr) {
  const days = daysBetweenInclusive(startStr, endStr)
  if (!freq || days === 0) return 0

  switch (freq) {
    // Daily
    case 'once_per_day':    return days
    case 'twice_per_day':   return 2 * days
    case 'thrice_per_day':  return 3 * days

    // Weekly
    case 'once_per_week':   return weeksFromDays(days) * 1
    case 'twice_per_week':  return weeksFromDays(days) * 2
    case 'thrice_per_week': return weeksFromDays(days) * 3

    // Monthly
    case 'once_per_month':   return monthsFromDays(days) * 1
    case 'twice_per_month':  return monthsFromDays(days) * 2
    case 'thrice_per_month': return monthsFromDays(days) * 3

    default: return 0
  }
}

function recalcAmount() {
  const sessions = sessionsForFrequency(form.frequency, form.start_date, form.end_date)
  form.amount = sessions * (Number(pricePerSession.value) || 0)
}

// --- keep amount in sync when any input changes
watch(
  () => [form.frequency, form.start_date, form.end_date, pricePerSession.value],
  recalcAmount,
  { immediate: true }
)

// if your calendar component updates `value`, mirror it back to the form:
watch(() => value.value, (v) => {
  form.start_date = v?.start ? v.start.toString() : ''
  form.end_date   = v?.end ? v.end.toString() : ''
}, { deep: true })

</script>

<template>
      <Dialog>
        <DialogTrigger>
          <Button size="sm" class="relative">
            Automatic Campaign
          </Button>
        </DialogTrigger>
        <DialogContent>
          <DialogHeader>
            <DialogTitle>Create a Campaign</DialogTitle>
            <DialogDescription>
              Explain your audience aligning with your content and specific goals such as brand awareness, lead generation, education, demographs, age, location etc.
            </DialogDescription>
          </DialogHeader>
          <form @submit.prevent="submit" class="space-y-6">
            <div class="grid gap-2 py-2">
              <div class="grid gap-2">
                <Label for="name">Campaign Name</Label>
                <Input id="name" v-model="form.name" placeholder="e.g. My new product/services/idea" required />
                <InputError class="mt-2" :message="form.errors.name" />
              </div>
            </div>
            <div class="grid gap-2 py-2">
              <div class="grid gap-2">
                <Label for="audience">Who is your target audience for this content?</Label>
                <Textarea id="audience" v-model="form.audience" placeholder="Please provide details about their demographics, interests etc." required />
                  <p class="text-sm text-muted-foreground">
                    Anything you type, Your AI will understand and create content around it.
                  </p>
                <InputError class="mt-2" :message="form.errors.audience" />
              </div>
            </div>
            <div class="grid gap-2 py-2">
              <Label for="date-picking">Select at least one or all social media platform </Label>
              <div class="grid gap-2">
                <div class="flex items-center space-x-2">
                  <input
                      id="facebook"
                      type="checkbox"
                      class="peer h-4 w-4 shrink-0 rounded-sm border border-primary ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 data-[state=checked]:bg-primary data-[state=checked]:text-primary-foreground"
                      :checked="form.facebook === 1"
                      @change="form.facebook = $event.target.checked ? 1 : 0"
                    />
                  <label
                    for="terms"
                    class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70"
                  >
                    Post to Facebook
                  </label>
                </div>

                <div class="flex items-center space-x-2">
                  <input
                      id="facebook"
                      type="checkbox"
                      class="peer h-4 w-4 shrink-0 rounded-sm border border-primary ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 data-[state=checked]:bg-primary data-[state=checked]:text-primary-foreground"
                      :checked="form.instagram === 1"
                      @change="form.instagram = $event.target.checked ? 1 : 0"
                    />
                  <label
                    for="terms"
                    class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70"
                  >
                    Post to Instagram
                  </label>
                </div>

                <div class="flex items-center space-x-2">
                  <input
                      id="facebook"
                      type="checkbox"
                      class="peer h-4 w-4 shrink-0 rounded-sm border border-primary ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 data-[state=checked]:bg-primary data-[state=checked]:text-primary-foreground"
                      :checked="form.x === 1"
                      @change="form.x = $event.target.checked ? 1 : 0"
                    />
                  <label
                    for="terms"
                    class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70"
                  >
                    Post to X
                  </label>
                </div>

                <div class="flex items-center space-x-2">
                  <input
                      id="facebook"
                      type="checkbox"
                      class="peer h-4 w-4 shrink-0 rounded-sm border border-primary ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 data-[state=checked]:bg-primary data-[state=checked]:text-primary-foreground"
                      :checked="form.youtube === 1"
                      @change="form.youtube = $event.target.checked ? 1 : 0"
                    />
                  <label
                    for="terms"
                    class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70"
                  >
                    Post to YouTube
                  </label>
                </div>

                <div class="flex items-center space-x-2">
                  <input
                      id="facebook"
                      type="checkbox"
                      class="peer h-4 w-4 shrink-0 rounded-sm border border-primary ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 data-[state=checked]:bg-primary data-[state=checked]:text-primary-foreground"
                      :checked="form.tiktok === 1"
                      @change="form.tiktok = $event.target.checked ? 1 : 0"
                    />
                  <label
                    for="terms"
                    class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70"
                  >
                    Post to TikTok
                  </label>
                </div>

                <div class="flex items-center space-x-2">
                  <input
                      id="facebook"
                      type="checkbox"
                      class="peer h-4 w-4 shrink-0 rounded-sm border border-primary ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 data-[state=checked]:bg-primary data-[state=checked]:text-primary-foreground"
                      :checked="form.linkedin === 1"
                      @change="form.linkedin = $event.target.checked ? 1 : 0"
                    />
                  <label
                    for="terms"
                    class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70"
                  >
                    Post to LinkedIn
                  </label>
                </div>

              </div>
            </div>


            <!-- date range -->
             
             <div :class="cn('grid gap-2', $attrs.class ?? '')">
              <Label for="date-picking">Duration: Start date - End date</Label>
    <Popover>
      <PopoverTrigger as-child>
        <Button
          id="date"
          :variant="'outline'"
          :class="cn(
            'w-[300px] justify-start text-left font-normal',
            !value && 'text-muted-foreground',
          )"
        >
          <CalendarIcon class="mr-2 h-4 w-4" />

          <template v-if="value.start">
            <template v-if="value.end">
              {{ df.format(value.start.toDate(getLocalTimeZone())) }} - {{ df.format(value.end.toDate(getLocalTimeZone())) }}
            </template>

            <template v-else>
              {{ df.format(value.start.toDate(getLocalTimeZone())) }}
            </template>
          </template>
          <template v-else>
            Pick a date
          </template>
        </Button>
      </PopoverTrigger>
      <PopoverContent class="w-auto p-0" align="end">
        <RangeCalendar
          v-model="value"
          weekday-format="short"
          :number-of-months="2"
          initial-focus
          :placeholder="value.start"
          @update:start-value="(startDate) => value.start = startDate"
        />
      </PopoverContent>
    </Popover>
  </div>
            <!-- date range -->
            

            <!-- select frequency -->
             <div class="flex gap-4 items-center">
              
             <Select v-model="form.frequency" required>
    <SelectTrigger class="w-[280px]">
      <SelectValue placeholder="Select post frequency" />
    </SelectTrigger>
    <SelectContent>
      <SelectGroup>
        <SelectLabel>Daily Post</SelectLabel>
        <SelectItem value="once_per_day">
          Once per day
        </SelectItem>
        <SelectItem value="twice_per_day">
          Twice per day
        </SelectItem>
        <SelectItem value="thrice_per_day">
          Thrice per day
        </SelectItem>
      </SelectGroup>
      <SelectGroup>
        <SelectLabel>Weekly Post</SelectLabel>
        <SelectItem value="once_per_week">
          Once per week
        </SelectItem>
        <SelectItem value="twice_per_week">
          Twice per week
        </SelectItem>
        <SelectItem value="thrice_per_week">
          Thrice per week
        </SelectItem>
      </SelectGroup>
      <SelectGroup>
        <SelectLabel>Monthly Post</SelectLabel>
        <SelectItem value="once_per_month">
          Once per month
        </SelectItem>
        <SelectItem value="twice_per_month">
          Twice per month
        </SelectItem>
        <SelectItem value="thrice_per_month">
          Thrice per month
        </SelectItem>
      </SelectGroup>
    </SelectContent>
  </Select>

  <label
                    for="terms"
                    class="text-md font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70"
                  >Amount due: {{
    form.amount
      ? form.amount.toLocaleString('en-NG', {
          style: 'currency',
          currency: 'NGN',
          minimumFractionDigits: 2,
        })
      : '₦0.00'
  }}</label>
  </div>
            <!-- select frequency -->
          <DialogFooter>
            <Button type="submit">Create</Button>
          </DialogFooter>
          </form>
        </DialogContent>
      </Dialog>
</template>