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
    'facebook_account': Object,
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
      <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="100" height="100" viewBox="0,0,256,256">
<g fill="none" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal"><g transform="scale(5.33333,5.33333)"><path d="M24,5c-10.49341,0 -19,8.50659 -19,19c0,10.49341 8.50659,19 19,19c10.49341,0 19,-8.50659 19,-19c0,-10.49341 -8.50659,-19 -19,-19z" fill="#000000"></path><path d="M26.572,29.036h4.917l0.772,-4.995h-5.69v-2.73c0,-2.075 0.678,-3.915 2.619,-3.915h3.119v-4.359c-0.548,-0.074 -1.707,-0.236 -3.897,-0.236c-4.573,0 -7.254,2.415 -7.254,7.917v3.323h-4.701v4.995h4.701v13.729c0.931,0.14 1.874,0.235 2.842,0.235c0.875,0 1.729,-0.08 2.572,-0.194z" fill="#ffffff"></path></g></g>
</svg>

      <h3 class="mt-4 text-lg font-semibold" v-if="!props.facebook_account">
        No {{ props.message }} added 
      </h3>
      <h3 class="mt-4 text-lg font-semibold" v-else>
        {{ props.message }} already added 
      </h3>
      <p class="mb-4 mt-2 text-sm text-muted-foreground">
        You can always add/edit. Add one below. - <a href="https://resources.Zenith IntelliScore.com/2025/10/13/how-to-add-your-facebook-account-to-Zenith IntelliScore-project/" target="_blank" class="underline">Get your keys here</a>
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