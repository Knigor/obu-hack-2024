<template>
  <div class="flex flex-col items-center justify-center mt-4">
    <h1 class="text-xl font-semibold">Куда летим?</h1>
    <div class="flex flex-wrap gap-2">
      <div class="flex flex-col gap-1">
        <p>Откуда</p>
        <Input type="email" placeholder="Липецк" />
      </div>
      <div class="flex flex-col gap-1">
        <p>Куда</p>
        <Input type="email" placeholder="Стамбул" />
      </div>
      <div class="flex flex-col gap-1">
        <p>Вылетаем</p>
        <Popover>
          <PopoverTrigger as-child>
            <Button variant="outline">
              <CalendarIcon class="mr-2 h-4 w-4" />
              Pick a date
            </Button>
          </PopoverTrigger>
          <PopoverContent class="w-auto p-0">
            <Calendar v-model="value" initial-focus />
          </PopoverContent>
        </Popover>
      </div>
      <div class="flex flex-col gap-1">
        <p>Возвращаемся</p>
        <div class="w-[50px] h-[50px] bg-yellow-500"></div>
      </div>
      <div class="flex flex-col gap-1">
        <p>Количество пассажиров</p>
        <div class="w-[50px] h-[50px] bg-yellow-500"></div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { DateFormatter, getLocalTimeZone } from '@internationalized/date'

import { Calendar as CalendarIcon } from 'lucide-vue-next'
import { Calendar } from '@/components/ui/calendar'
import { Button } from '@/components/ui/button'
import { Popover, PopoverContent, PopoverTrigger } from '@/components/ui/popover'

const value = ref()
</script>
<style lang="scss" scoped></style>
