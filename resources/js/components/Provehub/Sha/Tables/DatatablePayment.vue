<script setup>
import { FlexRender } from '@tanstack/vue-table'
import {
  Card,
  CardContent,
  CardDescription,
  CardHeader,
  CardTitle,
} from '@/components/ui/card'
import {
  getCoreRowModel,
  getExpandedRowModel,
  getFilteredRowModel,
  getPaginationRowModel,
  getSortedRowModel,
  useVueTable,
} from '@tanstack/vue-table'
import { valueUpdater } from '@/lib/utils'
import { Button } from '@/components/ui/button'
import { Checkbox } from '@/components/ui/checkbox'
import {
  DropdownMenu,
  DropdownMenuCheckboxItem,
  DropdownMenuContent,
  DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu'
import { Input } from '@/components/ui/input'
import {
  Table,
  TableBody,
  TableCell,
  TableHead,
  TableHeader,
  TableRow,
} from '@/components/ui/table'
import { ChevronDown } from 'lucide-vue-next'
import { h, ref, computed } from 'vue'
import NewCampaign from '@/components/ours/NewCampaign.vue'

const props = defineProps({
  payments: Object,
})

// Use the correct data reference
const data = computed(() => props.payments?.data || [])

const columns = [
  {
    id: 'select',
    header: ({ table }) => h(Checkbox, {
      modelValue: table.getIsAllPageRowsSelected() || (table.getIsSomePageRowsSelected() && 'indeterminate'),
      'onUpdate:modelValue': value => table.toggleAllPageRowsSelected(!!value),
      'ariaLabel': 'Select all',
    }),
    cell: ({ row }) => h(Checkbox, {
      modelValue: row.getIsSelected(),
      'onUpdate:modelValue': value => row.toggleSelected(!!value),
      'ariaLabel': 'Select row',
    }),
    enableSorting: false,
    enableHiding: false,
  },
  {
    accessorKey: 'description',
    header: 'Description',
    cell: ({ row }) => h('div', { class: 'capitalize' }, row.getValue('description')),
  },
  // {
  //   accessorKey: 'audience',
  //   header: 'Description',
  //   cell: ({ row }) => h('div', row.getValue('audience')),
  // },
  // {
  //   accessorKey: 'currency',
  //   header: 'Currency',
  //   cell: ({ row }) => h('div', row.getValue('currency')),
  // },
  {
    accessorKey: 'amount',
    header: () => h('div', { class: 'text-right' }, 'Amount'),
    cell: ({ row }) => {
      // const amount = Number.parseFloat(row.getValue('amount'))
      // const formatted = new Intl.NumberFormat('en-US', { style: 'currency', currency: 'NGN' }).format(row.getValue('amount'))

      const formatted = `₦ ${new Intl.NumberFormat('us').format(row.getValue('amount')).toString()}`
      // const formatted =  '₦ '+amount
      return h('div', { class: 'text-right font-medium' }, formatted)
    },
  },
  {
  accessorKey: 'status',
  header: 'Status',
  cell: ({ row }) => {
    const status = row.getValue('status')

    // Show button when status == 0
    if (status == 'processing') {
  return h(
    'button',
    {
      class:
        'px-3 py-1 text-sm bg-red-600 text-white rounded-md hover:bg-red-700 transition',
      onClick: () => {
        console.log('Pay campaign', row.original.id)
        window.location.href = route('checkout', row.original.payment_id)
      },
    },
    'Pay Now'
  )
}


    // Show status text otherwise
    const colorClass =
      status == 1
        ? 'text-green-600 font-medium'
        : 'text-yellow-500 font-medium'

    const label = status == 1 ? 'Running' : 'Paused'

    return h('div', { class: colorClass }, label)
  },
},

]

const sorting = ref([])
const columnFilters = ref([])
const columnVisibility = ref({})
const rowSelection = ref({})
const expanded = ref({})

const table = useVueTable({
  data,
  columns,
  getCoreRowModel: getCoreRowModel(),
  getPaginationRowModel: getPaginationRowModel(),
  getSortedRowModel: getSortedRowModel(),
  getFilteredRowModel: getFilteredRowModel(),
  getExpandedRowModel: getExpandedRowModel(),
  onSortingChange: updaterOrValue => valueUpdater(updaterOrValue, sorting),
  onColumnFiltersChange: updaterOrValue => valueUpdater(updaterOrValue, columnFilters),
  onColumnVisibilityChange: updaterOrValue => valueUpdater(updaterOrValue, columnVisibility),
  onRowSelectionChange: updaterOrValue => valueUpdater(updaterOrValue, rowSelection),
  onExpandedChange: updaterOrValue => valueUpdater(updaterOrValue, expanded),
  state: {
    get sorting() { return sorting.value },
    get columnFilters() { return columnFilters.value },
    get columnVisibility() { return columnVisibility.value },
    get rowSelection() { return rowSelection.value },
    get expanded() { return expanded.value },
  },
})
</script>


<template>
  <Card>
    <CardHeader class="pb-4">
      <CardTitle class="text-base">My Payments</CardTitle>
      <CardDescription>Here you can manage your payments.</CardDescription>
      <!-- <NewCampaign /> -->
    </CardHeader>

    

    <CardContent class="pb-2">
      <div class="w-full">
        <div class="flex items-center py-4">
          <!-- Date Filter -->
          <input
            class="max-w-sm flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-base ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 md:text-sm"
            placeholder="Filter payments..."
            :value="table.getColumn('name')?.getFilterValue() || ''"
            @input="table.getColumn('name')?.setFilterValue($event.target.value)"
          />

          <DropdownMenu>
            <DropdownMenuTrigger as-child>
              <Button variant="outline" class="ml-auto">
                Columns <ChevronDown class="ml-2 h-4 w-4" />
              </Button>
            </DropdownMenuTrigger>
            <DropdownMenuContent align="end">
              <DropdownMenuCheckboxItem
                v-for="column in table.getAllColumns().filter((column) => column.getCanHide())"
                :key="column.id"
                class="capitalize"
                :model-value="column.getIsVisible()"
                @update:model-value="(value) => {
                  column.toggleVisibility(!!value);
                }"
              >
                {{ column.id }}
              </DropdownMenuCheckboxItem>
            </DropdownMenuContent>
          </DropdownMenu>
        </div>

        <div class="rounded-md border">
          <Table>
            <TableHeader>
              <TableRow v-for="headerGroup in table.getHeaderGroups()" :key="headerGroup.id">
                <TableHead v-for="header in headerGroup.headers" :key="header.id">
                  <FlexRender v-if="!header.isPlaceholder" :render="header.column.columnDef.header" :props="header.getContext()" />
                </TableHead>
              </TableRow>
            </TableHeader>
            <TableBody>
              <template v-if="table.getRowModel().rows?.length">
                <template v-for="row in table.getRowModel().rows" :key="row.id">
                  <TableRow :data-state="row.getIsSelected() && 'selected'">
                    <TableCell v-for="cell in row.getVisibleCells()" :key="cell.id">
                      <FlexRender :render="cell.column.columnDef.cell" :props="cell.getContext()" />
                    </TableCell>

                    <!-- "Pay Now" Button (if status is not "success") -->
                    <TableCell v-if="row.original.status !== 'success'">
                      <Button class="w-full" as-child>
                        <!-- <a :href="route('checkout', { payment: row.original.id })">
                          Pay Now
                        </a> -->
                      </Button>
                    </TableCell>
                  </TableRow>

                  <!-- Expanded Row (if applicable) -->
                  <TableRow v-if="row.getIsExpanded()">
                    <TableCell :colspan="row.getAllCells().length">
                      {{ JSON.stringify(row.original) }}
                    </TableCell>
                  </TableRow>
                </template>
              </template>

              <TableRow v-else>
                <TableCell :colspan="columns.length" class="h-24 text-center">No results.</TableCell>
              </TableRow>
            </TableBody>
          </Table>
        </div>

        <div class="flex items-center justify-end space-x-2 py-4">
          <div class="flex-1 text-sm text-muted-foreground">
            {{ table.getFilteredSelectedRowModel().rows.length }} of
            {{ table.getFilteredRowModel().rows.length }} row(s) selected.
          </div>
          <div class="space-x-2">
            <Button
              variant="outline"
              size="sm"
              :disabled="!table.getCanPreviousPage()"
              @click="table.previousPage()"
            >
              Previous
            </Button>
            <Button
              variant="outline"
              size="sm"
              :disabled="!table.getCanNextPage()"
              @click="table.nextPage()"
            >
              Next
            </Button>
          </div>
        </div>
      </div>
    </CardContent>
  </Card>
</template>
