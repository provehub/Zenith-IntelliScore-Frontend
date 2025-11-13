<script setup>
import { ShieldAlertIcon } from "lucide-vue-next"
import { Button } from "@/components/ui/button"
import {
  Item,
  ItemActions,
  ItemContent,
  ItemDescription,
  ItemMedia,
  ItemTitle,
} from "@/components/ui/item"

const props = defineProps({
  message: String,
  project: { type: [Array, Object, null], default: null },
})


</script>

<template>
  <div class="flex w-full max-w-lg flex-col gap-6">
    <!-- {{ props.project }} -->
    <!-- {{ props.project.id }} -->
    <Item variant="outline">
      <ItemMedia variant="icon">
        <ShieldAlertIcon />
      </ItemMedia>

      <ItemContent>
        <ItemTitle>AI Liveness Check</ItemTitle>
        <ItemDescription>
          In other to get started on Zenith IntelliScore, you need to verify if you are real or not.
        </ItemDescription>
      </ItemContent>

      <ItemActions>
        <!-- open route('index') in new tab -->
        <Button asChild size="sm" variant="outline">
      <a :href="route('live.index', { 'vendor': props.project.id, 'extras' : props.project.id })" target="_blank" rel="noopener noreferrer">
        Proceed
      </a>
    </Button>
      </ItemActions>
    </Item>
  </div>
</template>
