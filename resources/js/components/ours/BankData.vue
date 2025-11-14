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
import { Label } from '@/components/ui/label'
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
    'message': String,
    'x_account': Object,
})

const form = useForm({
  statement: '',
});

const handleProposal = (event) => {
  form.statement = event.target.files[0];
};

const submit = () => {
    form.post(route('upload.bank'), {
        preserveScroll: true,
        onFinish: () => form.reset(),

    });
};
</script>

<template>
  <div class="flex h-[450px] shrink-0 items-center justify-center rounded-md border border-dashed">
    <div class="mx-auto flex max-w-[420px] flex-col items-center justify-center text-center">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6 h-20 w-20">
  <path d="M11.584 2.376a.75.75 0 0 1 .832 0l9 6a.75.75 0 1 1-.832 1.248L12 3.901 3.416 9.624a.75.75 0 0 1-.832-1.248l9-6Z" />
  <path fill-rule="evenodd" d="M20.25 10.332v9.918H21a.75.75 0 0 1 0 1.5H3a.75.75 0 0 1 0-1.5h.75v-9.918a.75.75 0 0 1 .634-.74A49.109 49.109 0 0 1 12 9c2.59 0 5.134.202 7.616.592a.75.75 0 0 1 .634.74Zm-7.5 2.418a.75.75 0 0 0-1.5 0v6.75a.75.75 0 0 0 1.5 0v-6.75Zm3-.75a.75.75 0 0 1 .75.75v6.75a.75.75 0 0 1-1.5 0v-6.75a.75.75 0 0 1 .75-.75ZM9 12.75a.75.75 0 0 0-1.5 0v6.75a.75.75 0 0 0 1.5 0v-6.75Z" clip-rule="evenodd" />
  <path d="M12 7.875a1.125 1.125 0 1 0 0-2.25 1.125 1.125 0 0 0 0 2.25Z" />
</svg>


      <h3 class="mt-4 text-lg font-semibold" v-if="!props.x_account">
        You can keep adding {{ props.message }} 
      </h3>
      <p class="mb-4 mt-2 text-sm text-muted-foreground">
        You can always add more bank statements to keep building your profile
      </p>
      <Dialog>
        <DialogTrigger>
          <Button size="sm" class="relative">
            Add {{ props.message }}
          </Button>
        </DialogTrigger>
        <DialogContent>
          <DialogHeader>
            <DialogTitle>Add {{ props.message }}</DialogTitle>
            <DialogDescription>
              Go to your banking platform and export your statements for the past 90 days.
            </DialogDescription>
          </DialogHeader>
          <form @submit.prevent="submit" class="space-y-6">
            <div class="col-span-6 mt-2 mb-4">
              <label class="block text-sm font-medium text-gray-700 mb-2">
                Upload Your Bank Statement in PDF or CSV format <br> <i>(Do not no upload edited document).</i>
              </label>
              <input type="file" @change="handleProposal" class="flex h-10 w-fit rounded-md border border-input bg-background px-3 py-2 text-base ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 md:text-sm" />
              <div v-if="form.errors.statement" class="text-red-500">{{ form.errors.statement }}</div>
          </div>
            
          <DialogFooter>
            <Button type="submit">Proceed</Button>
          </DialogFooter>
          </form>
        </DialogContent>
      </Dialog>
    </div>
  </div>
</template>