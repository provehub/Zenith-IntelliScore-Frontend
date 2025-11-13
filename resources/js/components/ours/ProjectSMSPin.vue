<script setup>
import { ref } from 'vue'
import { useForm } from '@inertiajs/vue3'
import { Button } from '@/components/ui/button'
import {
  PinInput,
  PinInputGroup,
  PinInputSlot,
} from '@/components/ui/pin-input'
import { toast } from '@/components/ui/toast'

// Initialize Inertia form
const form = useForm({
  pin: ['', '', '', '', ''],
})

// Update when input changes
const handlePinChange = (arr) => {
  form.pin = arr
}

// When all digits are filled
const handleComplete = (arr) => {
  console.log('Completed PIN:', arr.join(''))
}

// Submit handler
const onSubmit = () => {
  if (form.pin.some((val) => val === '')) {
    toast({ title: 'Please complete the PIN input' })
    return
  }

  // You can send to backend via Inertia
  form.post(route('pin.verify'), {
    preserveScroll: true,
    onSuccess: () => {
      toast({
        title: 'PIN submitted successfully!',
        description: form.pin.join(''),
      })
      form.reset()
    },
  })
}
</script>

<template>
  <form
    class="w-2/3 mx-auto space-y-6"
    @submit.prevent="onSubmit"
  >
    <div>
      <label for="pin-input" class="block text-sm font-medium text-gray-700">
        OTP
      </label>

      <PinInput
        id="pin-input"
        :model-value="form.pin"
        placeholder="○"
        class="flex gap-2 items-center mt-2"
        otp
        type="number"
        @complete="handleComplete"
        @update:model-value="handlePinChange"
      >
        <PinInputGroup>
          <PinInputSlot
            v-for="(id, index) in 5"
            :key="index"
            :index="index"
          />
        </PinInputGroup>
      </PinInput>

      <p class="text-xs text-gray-500 mt-2">
        Enter the 5-digit code sent to your email or phone.
      </p>

      <p v-if="form.errors.pin" class="text-red-500 text-sm mt-1">
        {{ form.errors.pin }}
      </p>
    </div>

    <Button type="submit" :disabled="form.processing">
      Submit
    </Button>
  </form>
</template>
