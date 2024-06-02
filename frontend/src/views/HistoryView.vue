<template>
  <section class="flex flex-col gap-6 w-full pb-16">
    <div class="flex flex-col gap-2">
      <h3>Вы искали раньше</h3>
      <p>
        Нажмите на строку в таблице, чтобы вернуться в то прекрасное время, когда вы делали этот
        запрос.
      </p>
    </div>
    <div class="flex flex-col">
      <Table class="w-full">
        <TableHeader>
          <TableRow>
            <TableHead class="font-bold">Откуда</TableHead>
            <TableHead class="font-bold">Куда</TableHead>
            <TableHead class="font-bold">Дата вылета </TableHead>
            <TableHead class="font-bold">Дата просмотра</TableHead>
          </TableRow>
        </TableHeader>
        <TableBody v-for="item in historyData" :key="item[0]">
          <TableRow>
            <TableCell>{{ item[1] }}</TableCell>
            <TableCell>{{ item[2] }}</TableCell>
            <TableCell>{{ item[3] }}</TableCell>
            <TableCell>{{ item[4] }}</TableCell>
          </TableRow>
        </TableBody>
      </Table>
    </div>
  </section>
</template>

<script setup>
import {
  Table,
  TableBody,
  TableCell,
  TableHead,
  TableHeader,
  TableRow
} from '@/components/ui/table'

import { ref } from 'vue'

const historyData = ref([
  [1, 'Липецк', 'Санкт-Петербург', '20.10.2023', '10.10.2023'],
  [2, 'Москва', 'Самара', '10.10.2022', '05.10.2022']
])
</script>
