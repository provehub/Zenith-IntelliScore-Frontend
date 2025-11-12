<script setup lang="ts">
import {
  Table,
  TableBody,
  TableCaption,
  TableCell,
  TableHead,
  TableHeader,
  TableRow,
} from '@/components/ui/table'
</script>

<template>
  <Table>
    <TableCaption>A daily donation of N100 per day by our members will mean we are feeding the above number of vulnerable Nigerians every single day.</TableCaption>
    <TableHeader>
      <TableRow>
        <TableHead>NO OF MEMBERS</TableHead>
        <TableHead>AMOUNT RAISED (/N5,000)</TableHead>
        <TableHead>VULNERABLE NIGERIANS FED</TableHead>
      </TableRow>
    </TableHeader>
    <TableBody>
      <TableRow>
        <TableCell>1,000</TableCell>
        <TableCell>100,000</TableCell>
        <TableCell>20</TableCell>
      </TableRow>
      <TableRow>
        <TableCell>100,000</TableCell>
        <TableCell>10,000,000</TableCell>
        <TableCell>2,000</TableCell>
      </TableRow>
      <TableRow>
        <TableCell>1,000,000</TableCell>
        <TableCell>100,000,000</TableCell>
        <TableCell>20,000</TableCell>
      </TableRow>
      <TableRow>
        <TableCell>10,000,000</TableCell>
        <TableCell>1,000,000,000</TableCell>
        <TableCell>200,000</TableCell>
      </TableRow>
      <TableRow>
        <TableCell>50,000,000</TableCell>
        <TableCell>5,000,000,000</TableCell>
        <TableCell>1,000,000</TableCell>
      </TableRow>
    </TableBody>
  </Table>
</template>