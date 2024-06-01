<template>
  <div class="flex flex-col gap-8 justify-center">
    <!-- Шапка сайта -->
    <div class="flex flex-col">
      <Header :is-calculator-opened="true" />
      <!-- Поле полей ввода -->
      <div
        class="flex flex-col gap-6 items-center justify-center shadow-md rounded-br-[999px] rounded-bl-[999px] bg-white pb-8"
      >
        <h1 class="text-xl font-semibold">Куда летим?</h1>
        <div class="flex flex-col gap-6">
          <!-- Первая строка параметров -->
          <div class="flex justify-between">
            <!-- Откуда/куда -->
            <div class="flex gap-4 items-end">
              <!-- Откуда -->
              <div class="flex flex-col gap-1">
                <p>Откуда</p>
                <DropdownMenu>
                  <DropdownMenuTrigger as-child>
                    <Button variant="outline" class="text-gray-500 w-[200px] flex justify-start">
                      <p>{{ cityNames[fromCityPosition] }}</p>
                    </Button>
                  </DropdownMenuTrigger>
                  <DropdownMenuContent class="w-56">
                    <DropdownMenuLabel>Откуда</DropdownMenuLabel>
                    <DropdownMenuSeparator />
                    <DropdownMenuRadioGroup v-model="fromCityPosition">
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
              <!-- Кнопка замены местами -->
              <Button @click="swapCities" variant="outline" size="icon" class="rounded-full"
                ><ArrowLeftRight size="16px"
              /></Button>
              <!-- Куда -->
              <div class="flex flex-col gap-1">
                <p>Куда</p>
                <DropdownMenu>
                  <DropdownMenuTrigger as-child>
                    <Button variant="outline" class="text-gray-500 w-[200px] flex justify-start">
                      <p>{{ cityNames[toCityPosition] }}</p>
                    </Button>
                  </DropdownMenuTrigger>
                  <DropdownMenuContent class="w-56">
                    <DropdownMenuLabel>Откуда</DropdownMenuLabel>
                    <DropdownMenuSeparator />
                    <DropdownMenuRadioGroup v-model="toCityPosition">
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
            </div>

            <!-- Вылет/посадка -->
            <div class="flex gap-4 items-end">
              <!-- Вылет -->
              <div class="flex flex-col gap-1">
                <p>Вылетаем</p>
                <Popover>
                  <PopoverTrigger as-child>
                    <Button variant="outline">
                      <CalendarIcon class="mr-2 h-4 w-4" />
                      {{
                        valueTo ? df.format(valueTo.toDate(getLocalTimeZone())) : 'Выберите дату'
                      }}
                    </Button>
                  </PopoverTrigger>
                  <PopoverContent class="w-auto p-0">
                    <Calendar v-model="valueTo" initial-focus />
                  </PopoverContent>
                </Popover>
              </div>
              <!-- Посадка -->
              <div class="flex flex-col gap-1">
                <p>Прилетаем</p>
                <Popover>
                  <PopoverTrigger as-child>
                    <Button variant="outline">
                      <CalendarIcon class="mr-2 h-4 w-4" />
                      {{
                        valueBack
                          ? df.format(valueBack.toDate(getLocalTimeZone()))
                          : 'Выберите дату'
                      }}
                    </Button>
                  </PopoverTrigger>
                  <PopoverContent class="w-auto p-0">
                    <Calendar v-model="valueBack" initial-focus />
                  </PopoverContent>
                </Popover>
              </div>
            </div>
          </div>

          <!-- Вторая строка параметров -->
          <div class="flex gap-8 items-end">
            <!-- Кол-во пассажиров, остановок, класс обслуж. и авиакомпания -->
            <div class="flex gap-4 items-end">
              <!-- Кол-во пассажиров -->
              <div class="flex flex-col gap-1">
                <p>Кол-во пассажиров</p>
                <div class="flex flex-wrap items-center justify-between h-[40px] w-[190px]">
                  <Button
                    @click="minusPeopleCount"
                    variant="outline"
                    size="icon"
                    class="rounded-full"
                    >–</Button
                  >
                  <p>{{ countPeople }} чел.</p>
                  <Button
                    @click="plusPeopleCount"
                    variant="outline"
                    size="icon"
                    class="rounded-full"
                    >+</Button
                  >
                </div>
              </div>
              <!-- Кол-во пересадок -->
              <div class="flex flex-col gap-1">
                <p>Кол-во остановок</p>
                <div class="flex flex-wrap items-center justify-between h-[40px] w-[190px]">
                  <Button
                    @click="minusStopsCount"
                    variant="outline"
                    size="icon"
                    class="rounded-full"
                    >–</Button
                  >
                  <p>{{ countStops }}</p>
                  <Button @click="plusStopsCount" variant="outline" size="icon" class="rounded-full"
                    >+</Button
                  >
                </div>
              </div>
              <!-- Класс -->
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
              <!-- Авиакомпания -->
              <div class="flex flex-col gap-1">
                <p>Авиакомпания</p>
                <DropdownMenu>
                  <DropdownMenuTrigger as-child>
                    <Button variant="outline" class="text-gray-500 w-[200px] flex justify-start">
                      <p>{{ airCompaniesNames[airCompanyPosition] }}</p>
                    </Button>
                  </DropdownMenuTrigger>
                  <DropdownMenuContent class="w-56">
                    <DropdownMenuLabel>Авиакомпания</DropdownMenuLabel>
                    <DropdownMenuSeparator />
                    <DropdownMenuRadioGroup v-model="airCompanyPosition">
                      <DropdownMenuRadioItem value="AirIndia"> Air India </DropdownMenuRadioItem>
                      <DropdownMenuRadioItem value="Vistara"> Vistara </DropdownMenuRadioItem>
                      <DropdownMenuRadioItem value="Indigo"> Indigo </DropdownMenuRadioItem>
                      <DropdownMenuRadioItem value="AirAsia"> AirAsia </DropdownMenuRadioItem>
                      <DropdownMenuRadioItem value="GoFirst"> GO FIRST </DropdownMenuRadioItem>
                      <DropdownMenuRadioItem value="SpiceJet"> SpiceJet </DropdownMenuRadioItem>
                      <DropdownMenuRadioItem value="StarAir"> StarAir </DropdownMenuRadioItem>
                      <DropdownMenuRadioItem value="Trujet"> Trujet </DropdownMenuRadioItem>
                    </DropdownMenuRadioGroup>
                  </DropdownMenuContent>
                </DropdownMenu>
              </div>
            </div>
            <Button @click="searchTicket" class="flex gap-2 w-full"><Calculator />Расчитать</Button>
          </div>
        </div>
      </div>
    </div>
    <!-- Область просмотра -->
    <div class="flex flex-col">
      <!-- Популярные направления -->
      <div v-if="visiblePopular" class="flex justify-center items-center">
        <div class="flex flex-col items-start gap-4">
          <h3>Популярные направления</h3>
          <!-- Фильтры и сортировка -->
          <div class="flex flex-wrap gap-4">
            <DropdownMenu>
              <DropdownMenuTrigger as-child>
                <Button class="flex gap-2" variant="outline">
                  <Filter /> {{ filterRoute[filter] }}
                </Button>
              </DropdownMenuTrigger>
              <DropdownMenuContent class="w-56">
                <DropdownMenuLabel>Фильтрация</DropdownMenuLabel>
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
          <!-- TODO: подумать, действительно ли необходим скролл или можно всё в одну линию выстроить -->
          <!-- Просмотр популярных направлений -->
          <ScrollArea class="h-[800px] w-[850px] rounded-md border p-4">
            <div class="flex gap-4">
              <PopularTour
                tour-name="Бангалор"
                tour-description="И нет сомнений, что представители современных социальных резервов формируют глобальную экономическую сеть и при этом — функционально разнесены на независимые элементы. Предварительные выводы неутешительны: глубокий уровень погружения создаёт предпосылки для инновационных методов управления процессами.И нет сомнений, что представители современных социальных резервов формируют глобальную экономическую сеть и при этом — функционально разнесены на независимые элементы. Предварительные выводы неутешительны: глубокий уровень погружения создаёт предпосылки для инновационных методов управления процессами."
                tour-image-u-r-l="https://place-hold.it/256px"
              ></PopularTour>
              <PopularTour
                tour-name="Дели"
                tour-description="И нет сомнений, что представители современных социальных резервов формируют глобальную экономическую сеть и при этом — функционально разнесены на независимые элементы. Предварительные выводы неутешительны: глубокий уровень погружения создаёт предпосылки для инновационных методов управления процессами.И нет сомнений, что представители современных социальных резервов формируют глобальную экономическую сеть и при этом — функционально разнесены на независимые элементы. Предварительные выводы неутешительны: глубокий уровень погружения создаёт предпосылки для инновационных методов управления процессами."
                tour-image-u-r-l="https://place-hold.it/256px"
              ></PopularTour>
            </div>
          </ScrollArea>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import Header from '../components/custom/profile/header.vue'
import PopularTour from '@/components/custom/profile/PopularTour.vue'
import { ref, onMounted } from 'vue'
import { DateFormatter, getLocalTimeZone } from '@internationalized/date'

import { Calendar as CalendarIcon, ArrowLeftRight, Calculator } from 'lucide-vue-next'
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

const airCompaniesNames = {
  Default: 'Выберите компанию',
  AirIndia: 'Air India',
  Vistara: 'Vistara',
  Indigo: 'Indigo',
  AirAsia: 'AirAsia',
  GoFirst: 'GO FIRST',
  SpiceJet: 'SpiceJet',
  StarAir: 'StarAir',
  Trujet: 'Trujet'
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
const fromCityPosition = ref('Default')
const toCityPosition = ref('Default')
const airCompanyPosition = ref('Default')
const classPlane = ref('Default')

const countPeople = ref(1)
const countStops = ref(1)

const valueTo = ref()
const valueBack = ref()

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
    position: fromCityPosition.value,
    positionTo: toCityPosition.value,
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

const plusPeopleCount = () => {
  if (countPeople.value < 9) countPeople.value++
}

const minusPeopleCount = () => {
  if (countPeople.value > 1) countPeople.value--
}

const plusStopsCount = () => {
  if (countStops.value < 9) countStops.value++
}

const minusStopsCount = () => {
  if (countStops.value > 1) countStops.value--
}

const swapCities = () => {
  let tempPos = fromCityPosition.value
  fromCityPosition.value = toCityPosition.value
  toCityPosition.value = tempPos
}

const df = new DateFormatter('ru', {
  dateStyle: 'long'
})
</script>

<style lang="scss" scoped></style>
