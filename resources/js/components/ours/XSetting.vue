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
      <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="100" height="100" viewBox="0 0 48 48">
      <path fill="#212121" fill-rule="evenodd" d="M38,42H10c-2.209,0-4-1.791-4-4V10c0-2.209,1.791-4,4-4h28	c2.209,0,4,1.791,4,4v28C42,40.209,40.209,42,38,42z" clip-rule="evenodd"></path><path fill="#fff" d="M34.257,34h-6.437L13.829,14h6.437L34.257,34z M28.587,32.304h2.563L19.499,15.696h-2.563 L28.587,32.304z"></path><polygon fill="#fff" points="15.866,34 23.069,25.656 22.127,24.407 13.823,34"></polygon><polygon fill="#fff" points="24.45,21.721 25.355,23.01 33.136,14 31.136,14"></polygon>
      </svg>

      <h3 class="mt-4 text-lg font-semibold" v-if="!props.x_account">
        No {{ props.message }} added 
      </h3>
      <h3 class="mt-4 text-lg font-semibold" v-else>
        {{ props.message }} already added 
      </h3>
      <p class="mb-4 mt-2 text-sm text-muted-foreground">
        You can always add/edit. Add one below. - <a href="https://resources.Zenith IntelliScore.com/2025/10/13/how-to-connect-your-x-twitter-account-to-Zenith IntelliScore-project/" target="_blank" class="underline">Get your keys here</a>
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