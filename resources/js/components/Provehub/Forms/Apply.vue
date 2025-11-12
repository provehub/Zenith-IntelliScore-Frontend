<script setup lang="js">
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import { useToast } from '@/components/ui/toast/use-toast';
import { toTypedSchema } from '@vee-validate/zod';
import * as z from 'zod';
import { Button } from '@/components/ui/button';
import { Form, FormControl, FormField, FormItem, FormLabel, FormMessage } from '@/components/ui/form';
import { Input } from '@/components/ui/input';
import {
  Select,
  SelectContent,
  SelectGroup,
  SelectItem,
  SelectTrigger,
  SelectValue,
} from '@/components/ui/select';
import {
  Stepper,
  StepperDescription,
  StepperItem,
  StepperSeparator,
  StepperTitle,
  StepperTrigger,
} from '@/components/ui/stepper';
import { Check, Circle, Dot, LoaderCircle } from 'lucide-vue-next';

const { toast } = useToast();

const stepIndex = ref(1);

const form = useForm({
  fullName: '',
  email: '',
  password: '',
  confirmPassword: '',
  favoriteDrink: '',
});

const formSchema = [
  z.object({
    fullName: z.string().min(2),
    email: z.string().email(),
  }),
  z.object({
    password: z.string().min(2).max(50),
    confirmPassword: z.string(),
  }).refine(data => data.password === data.confirmPassword, {
    message: 'Passwords must match!',
    path: ['confirmPassword'],
  }),
  z.object({
    favoriteDrink: z.enum(['coffee', 'tea', 'soda']),
  }),
];

const steps = [
  { step: 1, title: 'Section 1', description: 'Team Information' },
  { step: 2, title: 'Section 2', description: 'Team Members’ Details' },
  { step: 3, title: 'Section 3', description: 'Policy Proposal Submission' },
];

function handlePrevStep() {
  if (stepIndex.value > 1) stepIndex.value--;
}

async function handleNextStep(validate, meta) {
  await validate();
  if (meta.valid && stepIndex.value < steps.length) stepIndex.value++;
}

async function handleSubmit(validate, meta) {
  await validate();
  if (stepIndex.value === steps.length && meta.valid) {
    form.post(route('applied'), {
      onSuccess: () => toast({ title: 'Form submitted successfully!' }),
      onError: (errors) => toast({ title: 'Submission error', description: JSON.stringify(errors) }),
    });
  }
}
</script>

<template>
  <Form v-slot="{ meta, validate }" :validation-schema="toTypedSchema(formSchema[stepIndex - 1])" keep-values>
    <Stepper v-model="stepIndex" class="block w-full">
      <form @submit.prevent="stepIndex === steps.length ? handleSubmit(validate, meta) : handleNextStep(validate, meta)">
        <div class="flex w-full flex-start gap-2">
          <StepperItem v-for="step in steps" :key="step.step" :step="step.step" class="relative flex w-full flex-col items-center justify-center">

            <StepperSeparator
              v-if="step.step !== steps[steps.length - 1].step"
              class="absolute left-[calc(50%+20px)] right-[calc(-50%+10px)] top-5 block h-0.5 shrink-0 rounded-full bg-muted group-data-[state=completed]:bg-primary"
            />
            <StepperTrigger as-child>
              <Button :variant="state === 'completed' || state === 'active' ? 'default' : 'outline'"
                size="icon"
                class="z-10 rounded-full shrink-0"
                :class="[state === 'active' && 'ring-2 ring-ring ring-offset-2 ring-offset-background']"
                :disabled="state !== 'completed' && !meta.valid">
                <Check v-if="step.step < stepIndex" class="size-5" />
                <Circle v-if="step.step === stepIndex" />
                <Dot v-if="step.step > stepIndex" />
              </Button>
            </StepperTrigger>
            <div class="mt-5 flex flex-col items-center text-center">

            <StepperTitle class="text-sm font-semibold transition lg:text-base"
            >{{ step.title }}</StepperTitle>
            <StepperDescription class="sr-only text-xs text-muted-foreground transition md:not-sr-only lg:text-sm"
            >{{ step.description }}</StepperDescription>
            </div>
          </StepperItem>
        </div>

        <div class="mt-4">
          <template v-if="stepIndex === 1">
            <FormField name="fullName" v-slot="{ componentField }">
              <FormItem>
                <FormLabel>Full Name</FormLabel>
                <FormControl>
                  <Input type="text" v-bind="componentField" v-model="form.fullName" />
                </FormControl>
                <FormMessage />
              </FormItem>
            </FormField>

            <FormField name="email" v-slot="{ componentField }">
              <FormItem>
                <FormLabel>Email</FormLabel>
                <FormControl>
                  <Input type="email" v-bind="componentField" v-model="form.email" />
                </FormControl>
                <FormMessage />
              </FormItem>
            </FormField>
          </template>

          <template v-if="stepIndex === 2">
            <FormField name="password" v-slot="{ componentField }">
              <FormItem>
                <FormLabel>Password</FormLabel>
                <FormControl>
                  <Input type="password" v-bind="componentField" v-model="form.password" />
                </FormControl>
                <FormMessage />
              </FormItem>
            </FormField>

            <FormField name="confirmPassword" v-slot="{ componentField }">
              <FormItem>
                <FormLabel>Confirm Password</FormLabel>
                <FormControl>
                  <Input type="password" v-bind="componentField" v-model="form.confirmPassword" />
                </FormControl>
                <FormMessage />
              </FormItem>
            </FormField>
          </template>

          <template v-if="stepIndex === 3">
            <FormField name="favoriteDrink" v-slot="{ componentField }">
              <FormItem>
                <FormLabel>Favorite Drink</FormLabel>
                <Select v-bind="componentField" v-model="form.favoriteDrink">
                  <FormControl>
                    <SelectTrigger>
                      <SelectValue placeholder="Select a drink" />
                    </SelectTrigger>
                  </FormControl>
                  <SelectContent>
                    <SelectGroup>
                      <SelectItem value="coffee">Coffee</SelectItem>
                      <SelectItem value="tea">Tea</SelectItem>
                      <SelectItem value="soda">Soda</SelectItem>
                    </SelectGroup>
                  </SelectContent>
                </Select>
                <FormMessage />
              </FormItem>
            </FormField>
          </template>
        </div>

        <div class="mt-4 flex justify-between">
          <Button variant="outline" @click.prevent="handlePrevStep" :disabled="stepIndex === 1">Back</Button>
          <Button type="submit">
            <LoaderCircle v-if="form.processing" class="animate-spin mr-2" />
            {{ stepIndex === steps.length ? 'Submit' : 'Next' }}
          </Button>
        </div>
      </form>
    </Stepper>
  </Form>
</template>
