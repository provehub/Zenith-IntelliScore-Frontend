<script setup>
import { ref } from 'vue'
import { useForm } from '@inertiajs/vue3'
import { Check, Circle, Dot } from 'lucide-vue-next'
import { Button } from '@/components/ui/button'
import {
  Select,
  SelectContent,
  SelectGroup,
  SelectItem,
  SelectTrigger,
  SelectValue,
} from '@/components/ui/select'
import {
  Stepper,
  StepperDescription,
  StepperItem,
  StepperSeparator,
  StepperTitle,
  StepperTrigger,
} from '@/components/ui/stepper'
import { toast } from '@/components/ui/toast'

const stepIndex = ref(1)

const form = useForm({
  fullName: '',
  email: '',
  password: '',
  confirmPassword: '',
  favoriteDrink: '',
})

const steps = [
  { step: 1, title: 'Your details', description: 'Provide your name and email' },
  { step: 2, title: 'Your password', description: 'Choose a password' },
  { step: 3, title: 'Your favorite drink', description: 'Choose a drink' },
]

const onSubmit = () => {
  if (form.password !== form.confirmPassword) {
    toast({ title: 'Passwords must match!' })
    return
  }

  form.post(route('project.store'), {
    preserveScroll: true,
    onSuccess: () => {
      toast({ title: 'Form submitted successfully!' })
      form.reset()
      stepIndex.value = 1
    },
  })
}
</script>

<template>
  <Stepper v-slot="{ isNextDisabled, isPrevDisabled, nextStep, prevStep }" v-model="stepIndex" class="block w-full">
    <form
      @submit.prevent="() => {
        if (stepIndex === steps.length) onSubmit()
        else nextStep()
      }"
      class="space-y-6"
    >
      <!-- Stepper Navigation -->
      <div class="flex w-full justify-between gap-2">
        <StepperItem
          v-for="step in steps"
          :key="step.step"
          v-slot="{ state }"
          class="relative flex flex-col items-center justify-center w-full"
          :step="step.step"
        >
          <StepperSeparator
            v-if="step.step !== steps[steps.length - 1].step"
            class="absolute left-[calc(50%+20px)] right-[calc(-50%+10px)] top-5 h-0.5 bg-muted group-data-[state=completed]:bg-primary rounded-full"
          />

          <StepperTrigger as-child>
            <Button
              :variant="state === 'completed' || state === 'active' ? 'default' : 'outline'"
              size="icon"
              class="z-10 rounded-full shrink-0"
              :class="[state === 'active' && 'ring-2 ring-ring ring-offset-2 ring-offset-background']"
            >
              <Check v-if="state === 'completed'" class="size-5" />
              <Circle v-if="state === 'active'" />
              <Dot v-if="state === 'inactive'" />
            </Button>
          </StepperTrigger>

          <div class="mt-3 text-center">
            <StepperTitle :class="[state === 'active' && 'text-primary']" class="text-sm font-semibold">
              {{ step.title }}
            </StepperTitle>
            <StepperDescription
              :class="[state === 'active' && 'text-primary']"
              class="text-xs text-muted-foreground"
            >
              {{ step.description }}
            </StepperDescription>
          </div>
        </StepperItem>
      </div>

      <!-- Step 1 -->
      <div v-if="stepIndex === 1" class="space-y-4">
        <div>
          <label class="block text-sm font-medium text-gray-700">Full Name</label>
          <input
            v-model="form.fullName"
            type="text"
            class="mt-1 w-full rounded-md border border-gray-300 p-2 text-sm focus:border-primary focus:ring focus:ring-primary/30"
          />
          <div v-if="form.errors.fullName" class="text-red-500 text-sm mt-1">{{ form.errors.fullName }}</div>
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700">Email</label>
          <input
            v-model="form.email"
            type="email"
            class="mt-1 w-full rounded-md border border-gray-300 p-2 text-sm focus:border-primary focus:ring focus:ring-primary/30"
          />
          <div v-if="form.errors.email" class="text-red-500 text-sm mt-1">{{ form.errors.email }}</div>
        </div>
      </div>

      <!-- Step 2 -->
      <div v-if="stepIndex === 2" class="space-y-4">
        <div>
          <label class="block text-sm font-medium text-gray-700">Password</label>
          <input
            v-model="form.password"
            type="password"
            class="mt-1 w-full rounded-md border border-gray-300 p-2 text-sm focus:border-primary focus:ring focus:ring-primary/30"
          />
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700">Confirm Password</label>
          <input
            v-model="form.confirmPassword"
            type="password"
            class="mt-1 w-full rounded-md border border-gray-300 p-2 text-sm focus:border-primary focus:ring focus:ring-primary/30"
          />
        </div>
      </div>

      <!-- Step 3 -->
      <div v-if="stepIndex === 3" class="space-y-4">
        <label class="block text-sm font-medium text-gray-700">Favorite Drink</label>
        <Select v-model="form.favoriteDrink">
          <SelectTrigger class="w-full">
            <SelectValue placeholder="Select a drink" />
          </SelectTrigger>
          <SelectContent>
            <SelectGroup>
              <SelectItem value="coffee">Coffee</SelectItem>
              <SelectItem value="tea">Tea</SelectItem>
              <SelectItem value="soda">Soda</SelectItem>
            </SelectGroup>
          </SelectContent>
        </Select>
      </div>

      <!-- Buttons -->
      <div class="flex items-center justify-between">
        <Button
          :disabled="isPrevDisabled || stepIndex === 1"
          variant="outline"
          size="sm"
          type="button"
          @click="prevStep"
        >
          Back
        </Button>

        <div class="flex items-center gap-3">
          <Button
            v-if="stepIndex !== steps.length"
            type="button"
            size="sm"
            @click="nextStep"
          >
            Next
          </Button>

          <Button
            v-if="stepIndex === steps.length"
            type="submit"
            size="sm"
            :disabled="form.processing"
          >
            Submit
          </Button>
        </div>
      </div>
    </form>
  </Stepper>
</template>
