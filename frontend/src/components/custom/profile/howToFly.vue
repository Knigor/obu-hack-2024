<template>
  <div class="flex flex-col items-center justify-center mt-4">
    <h1 class="text-xl font-semibold">Куда летим?</h1>
    <div class="flex flex-wrap gap-2 mt-4">
      <div class="flex flex-col gap-1">
        <p>Откуда</p>
        <DropdownMenu>
          <DropdownMenuTrigger as-child>
            <Button variant="outline"> Open </Button>
          </DropdownMenuTrigger>
          <DropdownMenuContent class="w-56">
            <DropdownMenuLabel>Panel Position</DropdownMenuLabel>
            <DropdownMenuSeparator />
            <DropdownMenuRadioGroup v-model="position">
              <DropdownMenuRadioItem value="top"> Top </DropdownMenuRadioItem>
              <DropdownMenuRadioItem value="bottom"> Bottom </DropdownMenuRadioItem>
              <DropdownMenuRadioItem value="right"> Right </DropdownMenuRadioItem>
            </DropdownMenuRadioGroup>
          </DropdownMenuContent>
        </DropdownMenu>
      </div>
      <div class="flex flex-col gap-1">
        <p>Куда</p>
        <Input type="email" placeholder="Стамбул" />
        <div class="flex flex-col gap-2"></div>
      </div>
      <div class="flex flex-col gap-1">
        <p>Вылетаем</p>
        <Popover>
          <PopoverTrigger as-child>
            <Button variant="outline">
              <CalendarIcon class="mr-2 h-4 w-4" />
              {{ valueTo ? df.format(valueTo.toDate(getLocalTimeZone())) : 'Выберите дату' }}
            </Button>
          </PopoverTrigger>
          <PopoverContent class="w-auto p-0">
            <Calendar v-model="valueTo" initial-focus />
          </PopoverContent>
        </Popover>
      </div>

      <div class="flex flex-col gap-1">
        <p>Количество пассажиров</p>
        <div
          class="flex flex-wrap items-center justify-between h-[40px] border-[1px] border-slate-300 rounded-md"
        >
          <Button @click="minusCount" variant="outline" class="h-[30px] w-[20px] ml-4">-</Button>
          <p>{{ countPeople }} чел.</p>
          <Button @click="plusCount" variant="outline" class="h-[30px] w-[20px] mr-4">+</Button>
        </div>
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
import { Input } from '@/components/ui/input'
import {
  DropdownMenu,
  DropdownMenuContent,
  DropdownMenuLabel,
  DropdownMenuRadioGroup,
  DropdownMenuRadioItem,
  DropdownMenuSeparator,
  DropdownMenuTrigger
} from '@/components/ui/dropdown-menu'

const position = ref('bottom')

const minusCount = () => {
  if (countPeople.value > 1) {
    countPeople.value--
  }
}

const plusCount = () => {
  if (countPeople.value < 9) countPeople.value++
}

const df = new DateFormatter('ru', {
  dateStyle: 'long'
})

const countPeople = ref(1)

const valueTo = ref()
const valueBack = ref()
</script>
<style lang="scss" scoped></style>
