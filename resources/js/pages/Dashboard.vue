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
import { Button } from '@/components/ui/button'
import ProjectSwitcher from '@/components/ours/ProjectSwitcher.vue';
import ProjectStepper from '@/components/ours/ProjectStepper.vue';

const props = defineProps({
  message: String,
  project: { type: [Array, Object, null], default: null },
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
          <h2 class="text-2xl font-bold tracking-tight sm:text-3xl">
            Dashboard
          </h2>

          <div class="flex w-full flex-col items-stretch gap-2 sm:w-auto sm:flex-row sm:items-center">
            <!-- <DateRangePicker class="w-full sm:w-auto" />
            <Button class="w-full sm:w-auto">Download</Button> -->
          </div>
        </div>

        <!-- steper -->
         <ProjectStepper :project="project" />
        <!-- steper -->
        <!-- Tabs -->
        <Tabs default-value="overview" class="space-y-4">
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
                  <CardTitle class="text-sm font-medium">Total Spent</CardTitle>
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                       stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                       class="h-4 w-4 text-muted-foreground">
                    <path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6" />
                  </svg>
                </CardHeader>
                <CardContent>
                  <div class="text-2xl font-bold">₦0.00</div>
                  <p class="text-xs text-muted-foreground">+0.00% from last month</p>
                </CardContent>
              </Card>

              <Card>
                <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
                  <CardTitle class="text-sm font-medium">Subscriptions</CardTitle>
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                       stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                       class="h-4 w-4 text-muted-foreground">
                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                    <circle cx="9" cy="7" r="4" />
                    <path d="M22 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75" />
                  </svg>
                </CardHeader>
                <CardContent>
                  <div class="text-2xl font-bold">+0</div>
                  <p class="text-xs text-muted-foreground">+0.00% from last month</p>
                </CardContent>
              </Card>

              <Card>
                <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
                  <CardTitle class="text-sm font-medium">Credits</CardTitle>
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                       stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                       class="h-4 w-4 text-muted-foreground">
                    <rect width="20" height="14" x="2" y="5" rx="2" />
                    <path d="M2 10h20" />
                  </svg>
                </CardHeader>
                <CardContent>
                  <div class="text-2xl font-bold">+0</div>
                  <p class="text-xs text-muted-foreground">+0% from last month</p>
                </CardContent>
              </Card>

              <Card>
                <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
                  <CardTitle class="text-sm font-medium">Active Now</CardTitle>
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                       stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                       class="h-4 w-4 text-muted-foreground">
                    <path d="M22 12h-4l-3 9L9 3l-3 9H2" />
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
