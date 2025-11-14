<script setup lang="js">
import { ArrowUpRightIcon, Cloud } from "lucide-vue-next"
import { Button } from "@/components/ui/button"
import {
  Empty,
  EmptyContent,
  EmptyDescription,
  EmptyHeader,
  EmptyMedia,
  EmptyTitle,
} from "@/components/ui/empty"
</script>

<template>
  <Empty>
    <EmptyHeader>
      <EmptyMedia variant="icon">
        <Cloud />
      </EmptyMedia>
      <EmptyTitle>No Data has been provided yet</EmptyTitle>
      <EmptyDescription>
        You haven't submitted any data yet. Get started by submitting your first
        data towards your credit score.
      </EmptyDescription>
    </EmptyHeader>
    <EmptyContent>
      <div class="flex gap-2">
        <Button variant="destructive">Get Started</Button>
        <!-- <Button variant="outline">
          Import Project
        </Button> -->
      </div>
    </EmptyContent>
    <Button variant="link" as-child class="text-muted-foreground" size="sm">
      <a href="#">
        Learn More <ArrowUpRightIcon />
      </a>
    </Button>
  </Empty>
</template>