<script setup lang="js">
import {
  SidebarGroup,
  SidebarGroupLabel,
  SidebarMenu,
  SidebarMenuButton,
  SidebarMenuItem,
} from '@/components/ui/sidebar'
import { Link, usePage } from '@inertiajs/vue3'
import { computed } from 'vue'


const props = defineProps({
  items: {
    type: Array,
    required: true,
  },
})

const page = usePage()

const normalItems = computed(() =>
  (props.items || []).filter(i => i.provehub === 'normal')
)
const socialItems = computed(() =>
  (props.items || []).filter(i => i.provehub === 'social')
)
const devItems = computed(() =>
  (props.items || []).filter(i => i.provehub === 'dev')
)
const botItems = computed(() =>
  (props.items || []).filter(i => i.provehub === 'bot')
)
const graphicsItems = computed(() =>
  (props.items || []).filter(i => i.provehub === 'graphics')
)
const billingItems = computed(() =>
  (props.items || []).filter(i => i.provehub === 'billing')
)

</script>

<template>
  <SidebarGroup class="px-2 py-0">
    <!-- Platform group -->
    <template v-if="normalItems.length">
      <SidebarGroupLabel>Account</SidebarGroupLabel>
      <SidebarMenu>
        <SidebarMenuItem v-for="item in normalItems" :key="item.title">
          <SidebarMenuButton as-child :is-active="item.href === page.url">
            <Link :href="item.href">
              <component :is="item.icon" />
              <span>{{ item.title }}</span>
            </Link>
          </SidebarMenuButton>
        </SidebarMenuItem>
      </SidebarMenu>
    </template>

    <!-- Social Media group -->
    <template v-if="socialItems.length">
      <SidebarGroupLabel>Social Media</SidebarGroupLabel>
      <SidebarMenu>
        <SidebarMenuItem v-for="item in socialItems" :key="item.title">
          <SidebarMenuButton as-child :is-active="item.href === page.url">
            <Link :href="item.href">
              <component :is="item.icon" />
              <span>{{ item.title }}</span>
            </Link>
          </SidebarMenuButton>
        </SidebarMenuItem>
      </SidebarMenu>
    </template>

    <!-- Web dev group -->
    <template v-if="devItems.length">
      <SidebarGroupLabel>Web Development</SidebarGroupLabel>
      <SidebarMenu>
        <SidebarMenuItem v-for="item in devItems" :key="item.title">
          <SidebarMenuButton as-child :is-active="item.href === page.url">
            <Link :href="item.href">
              <component :is="item.icon" />
              <span>{{ item.title }}</span>
            </Link>
          </SidebarMenuButton>
        </SidebarMenuItem>
      </SidebarMenu>
    </template>
    <!-- Bot group -->
    <template v-if="botItems.length">
      <SidebarGroupLabel>Bot</SidebarGroupLabel>
      <SidebarMenu>
        <SidebarMenuItem v-for="item in botItems" :key="item.title">
          <SidebarMenuButton as-child :is-active="item.href === page.url">
            <Link :href="item.href">
              <component :is="item.icon" />
              <span>{{ item.title }}</span>
            </Link>
          </SidebarMenuButton>
        </SidebarMenuItem>
      </SidebarMenu>
    </template>
    <!-- graphics group -->
    <template v-if="graphicsItems.length">
      <SidebarGroupLabel>Graphics</SidebarGroupLabel>
      <SidebarMenu>
        <SidebarMenuItem v-for="item in graphicsItems" :key="item.title">
          <SidebarMenuButton as-child :is-active="item.href === page.url">
            <Link :href="item.href">
              <component :is="item.icon" />
              <span>{{ item.title }}</span>
            </Link>
          </SidebarMenuButton>
        </SidebarMenuItem>
      </SidebarMenu>
    </template>
    <!-- billing group -->
    <template v-if="billingItems.length">
      <SidebarGroupLabel>Billing</SidebarGroupLabel>
      <SidebarMenu>
        <SidebarMenuItem v-for="item in billingItems" :key="item.title">
          <SidebarMenuButton as-child :is-active="item.href === page.url">
            <Link :href="item.href">
              <component :is="item.icon" />
              <span>{{ item.title }}</span>
            </Link>
          </SidebarMenuButton>
        </SidebarMenuItem>
      </SidebarMenu>
    </template>

  </SidebarGroup>
</template>
