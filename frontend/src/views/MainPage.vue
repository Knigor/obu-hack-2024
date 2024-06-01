<template>
  <div class="flex flex-col justify-center">
    <Header />
    <div class="flex flex-col items-center justify-center mt-4">
      <h1 class="text-xl font-semibold">Куда летим?</h1>
      <div class="flex flex-wrap gap-2 mt-4">
        <div class="flex flex-col gap-1">
          <p>Откуда</p>
          <DropdownMenu>
            <DropdownMenuTrigger as-child>
              <Button variant="outline" class="text-gray-500 w-[200px] flex justify-start">
                <p>{{ cityNames[position] }}</p>
              </Button>
            </DropdownMenuTrigger>
            <DropdownMenuContent class="w-56">
              <DropdownMenuLabel>Откуда</DropdownMenuLabel>
              <DropdownMenuSeparator />
              <DropdownMenuRadioGroup v-model="position">
                <DropdownMenuRadioItem value="Bangalore"> Бангалор </DropdownMenuRadioItem>
                <DropdownMenuRadioItem value="Chennai"> Ченнаи </DropdownMenuRadioItem>
                <DropdownMenuRadioItem value="Delhi"> Дели </DropdownMenuRadioItem>
                <DropdownMenuRadioItem value="Hyderabad"> Хайдарабад </DropdownMenuRadioItem>
                <DropdownMenuRadioItem value="Kolkata"> Калькутта </DropdownMenuRadioItem>
                <DropdownMenuRadioItem value="Mumbai"> Мумбаи </DropdownMenuRadioItem>
              </DropdownMenuRadioGroup>
            </DropdownMenuContent>
          </DropdownMenu>
        </div>
        <div class="flex flex-col gap-1">
          <p>Куда</p>
          <DropdownMenu>
            <DropdownMenuTrigger as-child>
              <Button variant="outline" class="text-gray-500 w-[200px] flex justify-start">
                <p>{{ cityNames[positionTo] }}</p>
              </Button>
            </DropdownMenuTrigger>
            <DropdownMenuContent class="w-56">
              <DropdownMenuLabel>Откуда</DropdownMenuLabel>
              <DropdownMenuSeparator />
              <DropdownMenuRadioGroup v-model="positionTo">
                <DropdownMenuRadioItem value="Bangalore"> Бангалор </DropdownMenuRadioItem>
                <DropdownMenuRadioItem value="Chennai"> Ченнаи </DropdownMenuRadioItem>
                <DropdownMenuRadioItem value="Delhi"> Дели </DropdownMenuRadioItem>
                <DropdownMenuRadioItem value="Hyderabad"> Хайдарабад </DropdownMenuRadioItem>
                <DropdownMenuRadioItem value="Kolkata"> Калькутта </DropdownMenuRadioItem>
                <DropdownMenuRadioItem value="Mumbai"> Мумбаи </DropdownMenuRadioItem>
              </DropdownMenuRadioGroup>
            </DropdownMenuContent>
          </DropdownMenu>
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
          <p>Кол-во пассажиров</p>
          <div
            class="flex flex-wrap items-center justify-between h-[40px] w-[190px] border-[1px] border-slate-300 rounded-md"
          >
            <Button @click="minusCount" variant="outline" class="h-[30px] w-[20px] ml-4">-</Button>
            <p>{{ countPeople }} чел.</p>
            <Button @click="plusCount" variant="outline" class="h-[30px] w-[20px] mr-4">+</Button>
          </div>
        </div>
        <div class="flex flex-col gap-1">
          <p>Выберите класс</p>
          <DropdownMenu>
            <DropdownMenuTrigger as-child>
              <Button variant="outline" class="text-gray-500 w-[200px] flex justify-start">
                <p>{{ classNames[classPlane] }}</p>
              </Button>
            </DropdownMenuTrigger>
            <DropdownMenuContent class="w-56">
              <DropdownMenuLabel>Откуда</DropdownMenuLabel>
              <DropdownMenuSeparator />
              <DropdownMenuRadioGroup v-model="classPlane">
                <DropdownMenuRadioItem value="Zero"> Эконом </DropdownMenuRadioItem>
                <DropdownMenuRadioItem value="One"> Бизнес </DropdownMenuRadioItem>
              </DropdownMenuRadioGroup>
            </DropdownMenuContent>
          </DropdownMenu>
        </div>
      </div>
      <div class="flex justify-end">
        <Button @click="searchTicket" class="mt-4">Найти</Button>
      </div>
    </div>

    <div v-if="visiblePopular" class="flex justify-center items-center">
      <div class="flex flex-col items-start ml-12 mt-14">
        <h1 class="font-bold">Популярные направления</h1>
        <div class="flex flex-wrap gap-4">
          <DropdownMenu>
            <DropdownMenuTrigger as-child>
              <Button class="flex gap-2" variant="outline">
                <Filter /> {{ filterRoute[filter] }}
              </Button>
            </DropdownMenuTrigger>
            <DropdownMenuContent class="w-56">
              <DropdownMenuLabel>Сортировка</DropdownMenuLabel>
              <DropdownMenuSeparator />
              <DropdownMenuRadioGroup v-model="filter">
                <DropdownMenuRadioItem value="S7"> S7 </DropdownMenuRadioItem>
                <DropdownMenuRadioItem value="AeroFlot"> Аэрофлот </DropdownMenuRadioItem>
              </DropdownMenuRadioGroup>
            </DropdownMenuContent>
          </DropdownMenu>

          <DropdownMenu>
            <DropdownMenuTrigger as-child>
              <Button class="flex gap-2" variant="outline">
                <ArrowDownUp /> {{ sortRoute[sort] }}
              </Button>
            </DropdownMenuTrigger>
            <DropdownMenuContent class="w-56">
              <DropdownMenuLabel>Сортировка</DropdownMenuLabel>
              <DropdownMenuSeparator />
              <DropdownMenuRadioGroup v-model="sort">
                <DropdownMenuRadioItem value="cheap"> Сначала дешевые </DropdownMenuRadioItem>
                <DropdownMenuRadioItem value="exp"> Сначала дорогие </DropdownMenuRadioItem>
              </DropdownMenuRadioGroup>
            </DropdownMenuContent>
          </DropdownMenu>
        </div>
        <ScrollArea class="h-[400px] w-[850px] rounded-md border p-4 mt-4 mb-12">
          <div class="flex flex-wrap gap-12 mt-5">
            <div class="bg-purple-500 h-[92px] w-[642px]"></div>
            <div class="bg-purple-500 h-[92px] w-[642px]"></div>
            <div class="bg-purple-500 h-[92px] w-[642px]"></div>
            <div class="bg-purple-500 h-[92px] w-[642px]"></div>
            <div class="bg-purple-500 h-[92px] w-[642px]"></div>
            <div class="bg-purple-500 h-[92px] w-[642px]"></div>
            <div class="bg-purple-500 h-[92px] w-[642px]"></div>
            <div class="bg-purple-500 h-[92px] w-[642px]"></div>
            <div class="bg-purple-500 h-[92px] w-[642px]"></div>
          </div>
        </ScrollArea>
      </div>
    </div>
  </div>
</template>

<script setup>
import Header from '../components/custom/profile/header.vue'
import { ref, onMounted } from 'vue'
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
import { ScrollArea } from '@/components/ui/scroll-area'
import { ArrowDownUp } from 'lucide-vue-next'
import { Filter } from 'lucide-vue-next'
import axios from 'axios'

const cityNames = {
  Default: 'Выберите город',
  Bangalore: 'Бангалор',
  Chennai: 'Ченнаи',
  Delhi: 'Дели',
  Hyderabad: 'Хайдарабад',
  Kolkata: 'Калькутта',
  Mumbai: 'Мумбаи'
}

const classNames = {
  Default: 'Выберите класс',
  Zero: 'Эконом',
  One: 'Бизнес'
}

const sortRoute = {
  Default: 'Сортировка',
  cheap: 'Сначала дешевые',
  exp: 'Сначала дорогие'
}

const filterRoute = {
  Default: 'Фильтры',
  S7: 'S7',
  AeroFlot: 'Аэрофлот'
}

const sort = ref('Default')

const filter = ref('Default')

const position = ref('Default')

const positionTo = ref('Default')

const classPlane = ref('Default')

const minusCount = () => {
  if (countPeople.value > 1) {
    countPeople.value--
  }
}

// запрос на популярные данные из БД

const items = ref([])

const popularRoots = async () => {
  try {
    const response = await axios.get('http://localhost:8080/root_sort.php')
    items.value = response.data

    console.log(items.value)
  } catch (err) {
    console.error(err)
  }
}

onMounted(popularRoots)

// ниже логика отображение популярных

let visiblePopular = ref(true)

const searchTicket = async () => {
  console.log('КЛИК')

  const data = {
    position: position.value,
    positionTo: positionTo.value,
    classPlane: classPlane.value
  }

  console.log(data)

  try {
    const response = await axios.post('http://127.0.0.1:5000/getTicket', data, {
      headers: {
        'Content-Type': 'application/json'
      }
    })

    console.log(response.data)
  } catch (error) {
    console.error('Ошибка при отправке данных:', error)
  }

  visiblePopular.value = false
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
