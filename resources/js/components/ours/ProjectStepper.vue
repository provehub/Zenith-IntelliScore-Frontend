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
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'

import { useToast } from '@/components/ui/toast/use-toast'

const { toast } = useToast()

const showErrorToast = () => {
  toast({
    title: 'Uh oh! Something went wrong.',
    description: 'There was a problem with your request.',
    variant: 'destructive',
    action: {
      label: 'Try again',
      altText: 'Try again',
      onClick: () => {
        // Optional: retry logic
        toast({
          title: 'Retrying...',
          description: 'We’re attempting your request again.',
        })
      },
    },
  })
}

const stepIndex = ref(1)

const form = useForm({
  phone: '',
  nin: '',
  bvn: '',
})

const steps = [
  { step: 1, title: 'Your phone', description: 'Provide your main phone number' },
  { step: 2, title: 'Your NIN', description: 'Provide your NIN' },
  { step: 3, title: 'Your BVN', description: 'Provide your BVN' },
]

const onSubmit = () => {

  form.post(route('project.verify'), {
    preserveScroll: true,
    onSuccess: () => {
      showErrorToast()
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
          <div class="space-y-2">
            <Label for="name">Phone number</Label>
            <Input id="name" placeholder="e.g. 08037099011" v-model="form.phone" required />
          </div>
        </div>

      </div>

      <!-- Step 2 -->
      <div v-if="stepIndex === 2" class="space-y-4">
        <div class="space-y-2">
            <Label for="name">Phone NIN</Label>
            <Input id="name" placeholder="e.g. 1234567890" v-model="form.nin" required />
          </div>

      </div>

      <!-- Step 3 -->
      <div v-if="stepIndex === 3" class="space-y-4">
        <div class="space-y-2">
            <Label for="name">Phone BVN</Label>
            <Input id="name" placeholder="e.g. 1234567890" v-model="form.bvn" required />
          </div>
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
