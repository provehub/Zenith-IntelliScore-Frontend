<script setup>
import { onMounted, ref, watch, computed } from 'vue'
import { CursorArrowRippleIcon, CheckIcon, PlusCircleIcon } from '@heroicons/vue/20/solid'
import { cn } from '@/lib/utils'
import { Avatar, AvatarFallback, AvatarImage } from "@/components/ui/avatar"
import { Button } from '@/components/ui/button'
import { Command, CommandEmpty, CommandGroup, CommandInput, CommandItem, CommandList, CommandSeparator } from '@/components/ui/command'
import { Dialog, DialogContent, DialogDescription, DialogFooter, DialogHeader, DialogTitle, DialogTrigger } from '@/components/ui/dialog'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import { Popover, PopoverContent, PopoverTrigger } from '@/components/ui/popover'
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select'
import { useForm } from '@inertiajs/vue3'
import axios from 'axios'

const props = defineProps({
  message: String,
  current: Number,
  // Accept Array|Object|null, but we will coerce to an array below
  project: {
    type: [Array, Object, null],
    default: undefined,
  },
})

// Coerce to an array so template/watch never sees null/objects
const projectList = computed(() => {
  if (Array.isArray(props.project)) return props.project
  if (props.project && typeof props.project === 'object') return [props.project]
  return [] // handles null/undefined
})

const plans = ref([])

onMounted(async () => {
  try {
    const p = route('load.plans')
    const { status, data } = await axios.get(p)
    if (status === 200) {
      plans.value = Array.isArray(data) ? data : []
    }
  } catch (err) {
    console.error(err)
  }
})

const form = useForm({
  name: '',
  plan_id: '',
})

const upload = () => {
  form.post(route('project.store'), {
    preserveScroll: true,
    onSuccess: () => form.reset(),
  })
}

const fallbackProject = { id: 'sp', name: 'Verify Account', slug: 'xx' }

const open = ref(false)
const showNewTeamDialog = ref(false)
const selectedTeam = ref(fallbackProject)

onMounted(() => {
  if (props.current && props.current !== 0) {
    // Try to find the project that matches the current id
    const found = projectList.value.find(t => t.id === props.current)
    selectedTeam.value = found || (projectList.value.length ? projectList.value[0] : fallbackProject)
  } else {
    // Fall back to the first project or the fallback
    selectedTeam.value = projectList.value.length ? projectList.value[0] : fallbackProject
  }
})


watch(
  () => projectList.value,
  (list) => {
    if (!list.length) {
      selectedTeam.value = fallbackProject
      return
    }
    const stillExists = selectedTeam.value && list.some(t => t.id === selectedTeam.value.id)
    if (!stillExists) selectedTeam.value = list[0]
  },
  { deep: true }
)

const handleTeamSelect = async (team) => {
  selectedTeam.value = team
  open.value = false

  try {
    // Example: load details for the selected team
    const { data } = await axios.get(route('set.current.project', { project: team.slug }))
    console.log('Team details:', data)

    // You can merge this into your state if you like:
    // selectedTeam.value = { ...team, details: data }

  } catch (error) {
    console.error('Failed to fetch team details:', error)
  }
}

</script>

<template>
  <Dialog v-model:open="showNewTeamDialog">
    <Popover v-model:open="open">
      <PopoverTrigger as-child>
        <Button
          variant="outline"
          role="combobox"
          aria-label="Select a project"
          :class="cn('w-[200px] justify-between', $attrs.class ?? '')"
        >
          <Avatar class="mr-2 h-5 w-5">
            <AvatarImage :src="`https://avatar.vercel.sh/${selectedTeam.slug}.png`" :alt="selectedTeam.name" />
            <AvatarFallback>SC</AvatarFallback>
          </Avatar>
          {{ selectedTeam.name }}
          <CursorArrowRippleIcon class="ml-auto h-4 w-4 shrink-0 opacity-50" />
        </Button>
      </PopoverTrigger>

      <PopoverContent class="w-[200px] p-0">
        <Command>
          <CommandList>
            <CommandInput placeholder="Search..." />
            <CommandEmpty>None found.</CommandEmpty>

            <CommandGroup :heading="'Your Accounts'">
              <CommandItem
                v-for="team in projectList"
                :key="team.id"
                :value="team.id"
                class="text-sm"
                @select="() => handleTeamSelect(team)"
              >
                <Avatar class="mr-2 h-5 w-5">
                  <AvatarImage :src="`https://avatar.vercel.sh/${team.slug || team.id}.png`" :alt="team.name" class="grayscale" />
                  <AvatarFallback>SC</AvatarFallback>
                </Avatar>

                {{ team.name }}

                <CheckIcon
                  :class="cn(
                    'ml-auto h-4 w-4',
                    selectedTeam && selectedTeam.id === team.id ? 'opacity-100' : 'opacity-0'
                  )"
                />
              </CommandItem>
            </CommandGroup>
          </CommandList>

          <CommandSeparator />

          <CommandList>
            <CommandGroup>
              <DialogTrigger as-child>
                <CommandItem
                  value="create-team"
                  @select="() => { open = false; showNewTeamDialog = true }"
                >
                  <PlusCircleIcon class="mr-2 h-5 w-5" />
                   Add Account 
                </CommandItem>
              </DialogTrigger>
            </CommandGroup>
          </CommandList>
        </Command>
      </PopoverContent>
    </Popover>

    <DialogContent>
      <form @submit.prevent="upload">
        <DialogHeader>
          <DialogTitle>Verify Your Personal/Business Account</DialogTitle>
          <DialogDescription>
            Verify Your Personal/Business Account easily with AI.
          </DialogDescription>
        </DialogHeader>

        <div class="space-y-4 py-2 pb-4">
          <div class="space-y-2">
            <Label for="name">Full Name</Label>
            <Input id="name" placeholder="Personal or Business Name" v-model="form.name" required />
          </div>

          <div class="space-y-2">
            <Label for="plan">Account type</Label>
            <Select v-model="form.plan_id" required>
              <SelectTrigger>
                <SelectValue placeholder="Select account type" />
              </SelectTrigger>
              <SelectContent>
                <SelectItem v-for="plan in plans" :key="plan.id" :value="String(plan.id)">
                  <span class="font-medium">{{ plan.name }}</span>
                  <span class="text-muted-foreground"> — {{ plan.plan_type }}</span>
                </SelectItem>
              </SelectContent>
            </Select>
          </div>
        </div>

        <DialogFooter>
          <Button variant="outline" @click="showNewTeamDialog = false">Cancel</Button>
          <Button type="submit" variant="destructive">Continue</Button>
        </DialogFooter>
      </form>
    </DialogContent>
  </Dialog>
</template>
