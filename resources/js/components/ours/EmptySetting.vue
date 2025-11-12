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
})

const form = useForm({
  access_token: '',
  access_token_secret: '',
  consumer_key: '',
  consumer_secret: '',
  bearer_token: '',
});

const submit = () => {
    form.post(route('project.store.x.account'), {
        preserveScroll: true,
        onFinish: () => form.reset(),

    });
};
</script>

<template>
  <div class="flex h-[450px] shrink-0 items-center justify-center rounded-md border border-dashed">
    <div class="mx-auto flex max-w-[420px] flex-col items-center justify-center text-center">
      <svg
        xmlns="http://www.w3.org/2000/svg"
        fill="none"
        stroke="currentColor"
        strokeLinecap="round"
        strokeLinejoin="round"
        strokeWidth="2"
        class="h-10 w-10 text-muted-foreground"
        viewBox="0 0 24 24"
      >
        <circle cx="12" cy="11" r="1" />
        <path d="M11 17a1 1 0 0 1 2 0c0 .5-.34 3-.5 4.5a.5.5 0 0 1-1 0c-.16-1.5-.5-4-.5-4.5ZM8 14a5 5 0 1 1 8 0" />
        <path d="M17 18.5a9 9 0 1 0-10 0" />
      </svg>

      <h3 class="mt-4 text-lg font-semibold">
        No {{ props.message }} added
      </h3>
      <p class="mb-4 mt-2 text-sm text-muted-foreground">
        You can always add/edit. Add one below.
      </p>
      <Dialog>
        <DialogTrigger>
          <Button size="sm" class="relative">
            Add {{ props.message }} Account
          </Button>
        </DialogTrigger>
        <DialogContent>
          <DialogHeader>
            <DialogTitle>Add {{ props.message }} Account</DialogTitle>
            <DialogDescription>
              Copy and paste all the keys needs from your account settings on {{ props.message }}.
            </DialogDescription>
          </DialogHeader>
          <form @submit.prevent="submit" class="space-y-6">
            <div class="grid gap-2 py-2">
              <div class="grid gap-2">
                <Label for="access_token">Access Token</Label>
                <Input id="access_token" v-model="form.access_token" placeholder="228575809043496960-yxuouqldFMbjWjtMWBNw7o22e5Hlgxd" />
                <InputError class="mt-2" :message="form.errors.access_token" />
              </div>
            </div>
            <div class="grid gap-2 py-2">
              <div class="grid gap-2">
                <Label for="access_token_secret">Access Token Secret</Label>
                <Input id="access_token_secret" v-model="form.access_token_secret" placeholder="3IJuYjZ2vpHTmAlCBegbCM1resgb5Z2221LH1549VH1jZ" />
                <InputError class="mt-2" :message="form.errors.access_token_secret" />
              </div>
            </div>
            <div class="grid gap-2 py-2">
              <div class="grid gap-2">
                <Label for="consumer_key">Consumer Key</Label>
                <Input id="consumer_key" v-model="form.consumer_key" placeholder="vvBmWPVksJRS222nhBwJxmhMR" />
                <InputError class="mt-2" :message="form.errors.consumer_key" />
              </div>
            </div>
            <div class="grid gap-2 py-2">
              <div class="grid gap-2">
                <Label for="consumer_secret">Consumer Secret</Label>
                <Input id="consumer_secret" v-model="form.consumer_secret" placeholder="80Sjwe8u222jpGIZlNRtpwzEp2VUUlbZs2SSYHY22KsSK22x2X" />
                <InputError class="mt-2" :message="form.errors.consumer_secret" />
              </div>
            </div>
            <div class="grid gap-2 py-2">
              <div class="grid gap-2">
                <Label for="bearer_token">Bearer Token</Label>
                <Input id="bearer_token" v-model="form.bearer_token" placeholder="AAAAAAAAAAAAAAAAAAAAAEWvtwEAAAAAfrm4AZxHFE22POkRCICizI0T%2Fuo%3DyVtRUrpHBvuRIyTJGGgG2ZkznJUtQIBXdCer5A5Pu31CFpyXGU" />
                <InputError class="mt-2" :message="form.errors.bearer_token" />
              </div>
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