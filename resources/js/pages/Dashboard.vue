<script setup>
import AppLayout from '@/layouts/AppLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref,computed } from 'vue';
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
          <div class="ml-auto flex w-full items-center justify-between gap-3 sm:w-auto sm:justify-end">
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
          </div>
        </div>

        <!-- steper -->
         <ProjectStepper :project="project" />
        <!-- steper -->
        
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
