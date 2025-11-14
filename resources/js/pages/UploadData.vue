<script setup>
import AppLayout from '@/layouts/AppLayout.vue';
import { Head,Link } from '@inertiajs/vue3';
import { WifiIcon } from '@heroicons/vue/20/solid'
import { ref } from 'vue';

import { Button } from '@/components/ui/button'
import { Separator } from '@/components/ui/separator'

import {
  Tabs,
  TabsContent,
  TabsList,
  TabsTrigger,
} from '@/components/ui/tabs'

import BankData from '@/components/ours/BankData.vue'
import XSetting from '@/components/ours/XSetting.vue'
import FacebookSetting from '@/components/ours/FacebookSetting.vue'
import EmptySetting from '@/components/ours/EmptySetting.vue'


const props = defineProps({
    'message': String,
    'x_account': Object,
    'facebook_account': Object,
})

const breadcrumbs = ref([
    {
        title: 'Upload Data',
        href: '/upload/data',
    },
]);

</script>

<template>
    <Head title="Upload Data" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="col-span-3 lg:col-span-4 lg:border-l">
            <div class="h-full px-4 py-6 lg:px-8">
              <!-- {{ $page.props.site.current_project }} -->
              <!-- {{ props.x_account }} -->
              <Tabs default-value="bank" class="h-full space-y-6">
                <div class="space-between flex items-center">
                  <TabsList>
                    <TabsTrigger value="bank" class="relative">
                      Bank Statement
                    </TabsTrigger>
                    <TabsTrigger value="telco">
                      Telcom Data
                    </TabsTrigger>
                    <TabsTrigger value="utility">
                      Utility Data
                    </TabsTrigger>
                    <TabsTrigger value="facebook">
                      Facebook
                    </TabsTrigger>
                    <TabsTrigger value="instagram">
                      Instagram
                    </TabsTrigger>
                    <TabsTrigger value="x">
                      X
                    </TabsTrigger>
                    <TabsTrigger value="tiktok">
                      TikTok
                    </TabsTrigger>
                    <TabsTrigger value="linkedin">
                      LinkedIn
                    </TabsTrigger>
                    <TabsTrigger value="live" disabled>
                      eCommerce Data
                    </TabsTrigger>
                    <TabsTrigger value="live" disabled>
                      Freelance Data
                    </TabsTrigger>
                  </TabsList>
                  <div class="ml-auto mr-4">
                    <Button as-child>                            
                      <Link :href="route('user.dashboard')"><WifiIcon class="mr-2 h-4 w-4" />Dashboard</Link>
                    </Button>
                  </div>
                </div>
                
                <TabsContent
                  value="bank"
                  class="h-full flex-col border-none p-0 data-[state=active]:flex"
                >
                  <div class="flex items-center justify-between">
                    <div class="space-y-1">
                      <h2 class="text-2xl font-semibold tracking-tight">
                        Add Bank Statement
                      </h2>
                      <p class="text-sm text-muted-foreground">
                        Your active bank data. 90 day transaction is better.
                      </p>
                    </div>
                  </div>
                  <Separator class="my-4" />
                  <BankData :message="'Bank Statement'" :facebook_account="props.facebook_account" />
                </TabsContent>
                <TabsContent
                  value="telco"
                  class="h-full flex-col border-none p-0 data-[state=active]:flex"
                >
                  <div class="flex items-center justify-between">
                    <div class="space-y-1">
                      <h2 class="text-2xl font-semibold tracking-tight">
                        Telcom Data
                      </h2>
                      <p class="text-sm text-muted-foreground">
                        Your main phone usage activities. Updated daily from your provided phone verification.
                      </p>
                    </div>
                  </div>
                  <Separator class="my-4" />
                  <!-- <FacebookSetting :message="'Facebook'" :facebook_account="props.facebook_account" /> -->
                </TabsContent>
                <TabsContent
                  value="utility"
                  class="h-full flex-col border-none p-0 data-[state=active]:flex"
                >
                  <div class="flex items-center justify-between">
                    <div class="space-y-1">
                      <h2 class="text-2xl font-semibold tracking-tight">
                        Utility Data
                      </h2>
                      <p class="text-sm text-muted-foreground">
                        Your utility usage activities. Updated daily from your provided data.
                      </p>
                    </div>
                  </div>
                  <Separator class="my-4" />
                  <!-- <FacebookSetting :message="'Facebook'" :facebook_account="props.facebook_account" /> -->
                </TabsContent>
                <TabsContent
                  value="facebook"
                  class="h-full flex-col border-none p-0 data-[state=active]:flex"
                >
                  <div class="flex items-center justify-between">
                    <div class="space-y-1">
                      <h2 class="text-2xl font-semibold tracking-tight">
                        Add Facebook Account
                      </h2>
                      <p class="text-sm text-muted-foreground">
                        Your social profile. Updated daily.
                      </p>
                    </div>
                  </div>
                  <Separator class="my-4" />
                  <FacebookSetting :message="'Facebook'" :facebook_account="props.facebook_account" />
                </TabsContent>
                <TabsContent
                  value="instagram"
                  class="h-full flex-col border-none p-0 data-[state=active]:flex"
                >
                  <div class="flex items-center justify-between">
                    <div class="space-y-1">
                      <h2 class="text-2xl font-semibold tracking-tight">
                        Add Instagram Account
                      </h2>
                      <p class="text-sm text-muted-foreground">
                        Your social profile. Updated daily.
                      </p>
                    </div>
                  </div>
                  <Separator class="my-4" />
                  <EmptySetting :message="'Instagram'" />
                </TabsContent>

                <TabsContent
                  value="x"
                  class="h-full flex-col border-none p-0 data-[state=active]:flex"
                >
                  <div class="flex items-center justify-between">
                    <div class="space-y-1">
                      <h2 class="text-2xl font-semibold tracking-tight">
                        Add X Account
                      </h2>
                      <p class="text-sm text-muted-foreground">
                        Your social profile. Updated daily.
                      </p>
                    </div>
                  </div>
                  <Separator class="my-4" />
                  <XSetting :message="'X'" :x_account="props.x_account" />
                </TabsContent>

                <TabsContent
                  value="tiktok"
                  class="h-full flex-col border-none p-0 data-[state=active]:flex"
                >
                  <div class="flex items-center justify-between">
                    <div class="space-y-1">
                      <h2 class="text-2xl font-semibold tracking-tight">
                        Add TikTok Account
                      </h2>
                      <p class="text-sm text-muted-foreground">
                        Your social profile. Updated daily.
                      </p>
                    </div>
                  </div>
                  <Separator class="my-4" />
                  <EmptySetting :message="'TikTok'" />
                </TabsContent>
                
                <TabsContent
                  value="linkedin"
                  class="h-full flex-col border-none p-0 data-[state=active]:flex"
                >
                  <div class="flex items-center justify-between">
                    <div class="space-y-1">
                      <h2 class="text-2xl font-semibold tracking-tight">
                        Add LinkedIn Account
                      </h2>
                      <p class="text-sm text-muted-foreground">
                        Your social profile. Updated daily.
                      </p>
                    </div>
                  </div>
                  <Separator class="my-4" />
                  <EmptySetting :message="'LinkedIn'" />
                </TabsContent>
              </Tabs>
            </div>
          </div>
        </div>
    </AppLayout>
</template>
