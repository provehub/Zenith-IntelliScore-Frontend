<script setup>
import AppLayout from '@/layouts/AppLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref,computed } from 'vue';
import { Tabs, TabsContent, TabsList, TabsTrigger } from '@/components/ui/tabs'
import {
  Card,
  CardContent,
  CardDescription,
  CardHeader,
  CardTitle,
} from '@/components/ui/card'
import ProjectSwitcher from '@/components/ours/ProjectSwitcher.vue';
import ProjectSMSPin from '@/components/ours/ProjectSMSPin.vue';
import ProjectStepper from '@/components/ours/ProjectStepper.vue';
import ProjectStartData from '@/components/ours/ProjectStartData.vue';
import ProjectStartLivenes from '@/components/ours/ProjectStartLivenes.vue';
import ProjectResultView from '@/components/ours/ProjectResultView.vue';

const props = defineProps({
  message: String,
  project: { type: [Array, Object, null], default: null },
  procheck: { type: [Array, Object, null], default: null },
  ass: { type: [Array, Object, null], default: null },
  personal: { type: [Number, null], default: null },
  pro: { type: [Number, null], default: null },
})

// Always work with an array in the template
const projectList = computed(() => {
  if (Array.isArray(props.project)) return props.project
  if (props.project && typeof props.project === 'object') return [props.project]
  return []
})

// Single source of truth for the guard
const hasProjects = computed(() => projectList.value.length > 0)

const breadcrumbs = ref([
        {
            title: 'Dashboard',
            href: '/user/dashboard',
        },
    ]);
</script>

<template>
  <Head title="Dashboard" />

  <AppLayout :breadcrumbs="breadcrumbs">
    <!-- {{ props.project }} -->
    <!-- Shell -->
    <!-- {{ $page.props.site.current_project }} -->
    <div class="flex min-h-screen flex-col" v-if="hasProjects">
      <!-- Top bar -->
      <div class="border-b">
        <div class="flex flex-wrap items-center gap-3 px-4 py-3 sm:h-16 sm:gap-4 sm:px-6 lg:px-8">
          <ProjectSwitcher :project="project" :current="$page.props.site.current_project" class="shrink-0" />
          <!-- Main nav hidden on small, shows from md up -->
          <!-- <MainNav class="mx-0 hidden md:mx-6 md:flex" /> -->
          <!-- Right actions -->
          <div class="ml-auto flex w-full items-center justify-between gap-3 sm:w-auto sm:justify-end">
            <!-- Show compact search on mobile; keep as-is if your Search handles small screens -->
            <!-- <Search class="min-w-0 flex-1 sm:flex-none" /> -->
            <!-- <UserNav /> -->
          </div>
        </div>
      </div>

      <!-- Content -->
      <div class="flex-1 space-y-4 px-4 py-6 sm:px-6 sm:pt-6 lg:px-8">
        <!-- Page header -->
        <div class="flex flex-col items-start justify-between gap-3 sm:flex-row sm:items-center">
          <h2 class="text-2xl font-bold tracking-tight sm:text-3xl" v-if="personal == 4">
            Do your AI Liveness Check
          </h2>
          <h2 class="text-2xl font-bold tracking-tight sm:text-3xl" v-if="pro == 4">
            Dashboard
          </h2>
          <h2 class="text-2xl font-bold tracking-tight sm:text-3xl" v-if="personal == 1">
            Verify BVN and NIN
          </h2>
          <h2 class="text-2xl font-bold tracking-tight sm:text-3xl" v-if="personal == 0">
            Provide Personal Information for AI verification
          </h2>

          <div class="flex w-full flex-col items-stretch gap-2 sm:w-auto sm:flex-row sm:items-center">
            <!-- <DateRangePicker class="w-full sm:w-auto" />
            <Button class="w-full sm:w-auto">Download</Button> -->
          </div>
        </div>

        
        <!-- steper -->
         <ProjectStepper v-if="personal == 0" :project="project" />
        <!-- steper -->

        <!-- sms -->
         <ProjectSMSPin v-if="personal == 1" :project="project" />
        <!-- sms -->

        <!-- start liveness -->
         <ProjectStartLivenes v-if="personal == 4" :project="procheck" />
        <!-- start liveness -->

        

        <!-- Tabs -->
        <Tabs default-value="overview" class="space-y-4" v-if="pro == 4">
          <!-- Make tabs horizontally scrollable on mobile -->
          <!-- <div class="w-full overflow-x-auto">
            <TabsList class="inline-flex min-w-max">
              <TabsTrigger value="overview">Overview</TabsTrigger>
              <TabsTrigger value="analytics" disabled>Analytics</TabsTrigger>
              <TabsTrigger value="reports" disabled>Reports</TabsTrigger>
              <TabsTrigger value="notifications" disabled>Notifications</TabsTrigger>
            </TabsList>
          </div> -->

          <TabsContent value="overview" class="space-y-4">
            <!-- KPI Cards: single column on mobile, 2 cols md, 4 cols lg -->
            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
              <Card>
                <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
                  <CardTitle class="text-sm font-medium">Total Loan</CardTitle>
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z" />
                    </svg>

                </CardHeader>
                <CardContent>
                  <div class="text-2xl font-bold">₦0.00</div>
                  <p class="text-xs text-muted-foreground">₦0.00 from last month</p>
                </CardContent>
              </Card>

              <Card>
                <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
                  <CardTitle class="text-sm font-medium">Data</CardTitle>
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.375 19.5h17.25m-17.25 0a1.125 1.125 0 0 1-1.125-1.125M3.375 19.5h7.5c.621 0 1.125-.504 1.125-1.125m-9.75 0V5.625m0 12.75v-1.5c0-.621.504-1.125 1.125-1.125m18.375 2.625V5.625m0 12.75c0 .621-.504 1.125-1.125 1.125m1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125m0 3.75h-7.5A1.125 1.125 0 0 1 12 18.375m9.75-12.75c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125m19.5 0v1.5c0 .621-.504 1.125-1.125 1.125M2.25 5.625v1.5c0 .621.504 1.125 1.125 1.125m0 0h17.25m-17.25 0h7.5c.621 0 1.125.504 1.125 1.125M3.375 8.25c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125m17.25-3.75h-7.5c-.621 0-1.125.504-1.125 1.125m8.625-1.125c.621 0 1.125.504 1.125 1.125v1.5c0 .621-.504 1.125-1.125 1.125m-17.25 0h7.5m-7.5 0c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125M12 10.875v-1.5m0 1.5c0 .621-.504 1.125-1.125 1.125M12 10.875c0 .621.504 1.125 1.125 1.125m-2.25 0c.621 0 1.125.504 1.125 1.125M13.125 12h7.5m-7.5 0c-.621 0-1.125.504-1.125 1.125M20.625 12c.621 0 1.125.504 1.125 1.125v1.5c0 .621-.504 1.125-1.125 1.125m-17.25 0h7.5M12 14.625v-1.5m0 1.5c0 .621-.504 1.125-1.125 1.125M12 14.625c0 .621.504 1.125 1.125 1.125m-2.25 0c.621 0 1.125.504 1.125 1.125m0 1.5v-1.5m0 0c0-.621.504-1.125 1.125-1.125m0 0h7.5" />
                    </svg>

                </CardHeader>
                <CardContent>
                  <div class="text-2xl font-bold">+0</div>
                  <p class="text-xs text-muted-foreground">+0.00% from last month</p>
                </CardContent>
              </Card>

              <Card>
                <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
                  <CardTitle class="text-sm font-medium">Repayments</CardTitle>
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Z" />
                    </svg>

                </CardHeader>
                <CardContent>
                  <div class="text-2xl font-bold">₦0.00</div>
                  <p class="text-xs text-muted-foreground">₦0.00 from last month</p>
                </CardContent>
              </Card>

              <Card>
                <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
                  <CardTitle class="text-sm font-medium">Cases</CardTitle>
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" />
                    </svg>

                </CardHeader>
                <CardContent>
                  <div class="text-2xl font-bold">+0</div>
                  <p class="text-xs text-muted-foreground">+0 since last hour</p>
                </CardContent>
              </Card>
            </div>

            <!-- Charts / lists: single column on mobile, split on md+ -->
            <!-- <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-7">
              <Card class="col-span-1 md:col-span-1 lg:col-span-4">
                <CardHeader>
                  <CardTitle>Overview</CardTitle>
                </CardHeader>
                <CardContent class="pl-2">
                  <Overview />
                </CardContent>
              </Card>

              <Card class="col-span-1 md:col-span-1 lg:col-span-3">
                <CardHeader>
                  <CardTitle>Recent Sales</CardTitle>
                  <CardDescription>You made 265 sales this month.</CardDescription>
                </CardHeader>
                <CardContent>
                  <RecentSales />
                </CardContent>
              </Card>
            </div> -->
          </TabsContent>
        </Tabs>
        <!-- tabs -->

        <!-- start data providing -->
         <ProjectStartData v-if="pro == 3" />
        <!-- start data providing -->

        <!-- result scoring -->
         <ProjectResultView v-if="pro == 4" :data="ass" />
        <!-- result scoring -->
         <!-- {{ ass }} -->
      </div>
    </div>
    
    <div v-else class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4 overflow-x-auto">
      <div class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border">
        <div class="flex items-center justify-center min-h-screen">
          <ProjectSwitcher :project="project" />
        </div>
      </div>
    </div>
   
  </AppLayout>
</template>
