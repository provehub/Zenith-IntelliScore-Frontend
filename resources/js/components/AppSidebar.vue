<script setup lang="js">
import NavFooter from '@/components/NavFooter.vue'
import NavMain from '@/components/NavMain.vue'
import NavUser from '@/components/NavUser.vue'
import {
  Sidebar,
  SidebarContent,
  SidebarFooter,
  SidebarHeader,
  SidebarMenu,
  SidebarMenuButton,
  SidebarMenuItem,
} from '@/components/ui/sidebar'
import { Link } from '@inertiajs/vue3'
import { Home, LayoutGrid, BanknoteIcon, BotMessageSquareIcon, CogIcon, AppWindowIcon, TabletSmartphoneIcon, WaypointsIcon, BotIcon, BrickWallIcon, FileImageIcon, ProjectorIcon } from 'lucide-vue-next'
import { ChatBubbleLeftRightIcon } from '@heroicons/vue/24/outline'
import AppLogo from './AppLogo.vue'

const mainNavItems = [
  {
    provehub: 'normal',
    title: 'Dashboard',
    href: '/user/dashboard',
    icon: LayoutGrid,
  },
  // {
  //   provehub: 'normal',
  //   title: 'Train your AI',
  //   href: '/train/ai',
  //   icon: BrickWallIcon,
  // },
  {
    provehub: 'normal',
    title: 'Support',
    href: '/chat',
    icon: ChatBubbleLeftRightIcon,
  },
  // {
  //   provehub: 'normal',
  //   title: 'My Listings',
  //   href: '/agent/my/listing',
  //   icon: BanknoteIcon,
  // },
  // {
  //   provehub: 'social',
  //   title: 'Social Media',
  //   href: '/social',
  //   icon: WaypointsIcon,
  // },
  {
    provehub: 'social',
    title: 'Upload Data',
    href: '/project/upload/data',
    icon: BrickWallIcon,
  },
  // {
  //   provehub: 'dev',
  //   title: 'Website Builder',
  //   href: '/build/website',
  //   icon: AppWindowIcon,
  // },
  // {
  //   provehub: 'dev',
  //   title: 'Mobile App Builder',
  //   href: '/build/mobile/app',
  //   icon: TabletSmartphoneIcon,
  // },
  // {
  //   provehub: 'bot',
  //   title: 'Website Bot',
  //   href: '/create/website/bot',
  //   icon: BotMessageSquareIcon,
  // },
  // {
  //   provehub: 'bot',
  //   title: 'Social Bot',
  //   href: '/create/social/bot',
  //   icon: BotIcon,
  // },
  // {
  //   provehub: 'graphics',
  //   title: 'Graphics',
  //   href: '/create/graphics',
  //   icon: FileImageIcon,
  // },
  // {
  //   provehub: 'graphics',
  //   title: 'Slides',
  //   href: '/create/slides',
  //   icon: ProjectorIcon,
  // },
  {
    provehub: 'billing',
    title: 'Payments',
    href: '/payments',
    icon: BanknoteIcon,
  },
  // {
  //   title: 'Videos',
  //   href: '/videos',
  //   icon: PlayIcon,
  // },
]

const footerNavItems = [
  {
    title: 'Home',
    href: 'https://zenithintelliscore.com/',
    icon: Home,
  },
]
</script>

<template>
  <Sidebar collapsible="icon" variant="inset">
    <SidebarHeader>
      <SidebarMenu>
        <SidebarMenuItem>
          <SidebarMenuButton size="lg" as-child>
            <Link :href="route('dashboard')">
              <AppLogo />
            </Link>
          </SidebarMenuButton>
        </SidebarMenuItem>
      </SidebarMenu>
    </SidebarHeader>

    <SidebarContent>
      <NavMain :items="mainNavItems" />
    </SidebarContent>

    <SidebarFooter>
      <NavFooter :items="footerNavItems" />
      <NavUser />
    </SidebarFooter>
  </Sidebar>

  <slot />
</template>
