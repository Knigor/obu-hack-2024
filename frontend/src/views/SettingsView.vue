<template>
  <section class="flex flex-col gap-6 w-full">
    <div class="flex gap-8">
      <div class="flex flex-col gap-4">
        <Avatar class="w-[128px] h-[128px] rounded-2xl">
          <AvatarImage src="https://github.com/radix-vue.png" alt="@radix-vue" />
          <AvatarFallback>CN</AvatarFallback>
        </Avatar>
        <Button variant="outline" class="max-w-[128px]">Изменить фото</Button>
      </div>
      <div class="flex flex-col gap-8 w-full">
        <!-- Личная информация и безопасность -->
        <div class="flex gap-8 w-full">
          <!-- Личная информация -->
          <div class="flex gap-6 flex-col w-full">
            <div class="flex justify-between">
              <h3>Личная информация</h3>
              <Button>Сохранить</Button>
            </div>
            <div class="flex flex-col gap-3">
              <div class="flex gap-4 items-center">
                <p class="w-[96px]">ФИО</p>
                <Input type="text" placeholder="Ваш ФИО..." v-bind="componentField" />
              </div>
              <div class="flex gap-4 items-center">
                <p class="w-[96px]">Почта</p>
                <Input type="text" placeholder="Ваша почта..." v-bind="componentField" />
              </div>
              <div class="flex gap-4 items-center">
                <p class="w-[96px]">Телефон</p>
                <Input type="text" placeholder="Ваш телефон..." v-bind="componentField" />
              </div>
              <div class="flex gap-4 items-center">
                <p class="w-[96px]">Дата рождения</p>
                <Popover>
                  <PopoverTrigger as-child>
                    <Button
                      variant="outline"
                      :class="
                        cn(
                          'w-full justify-start text-left font-normal',
                          !value && 'text-muted-foreground'
                        )
                      "
                    >
                      <CalendarIcon class="mr-2 h-4 w-4" />
                      {{ value ? df.format(value.toDate(getLocalTimeZone())) : 'Выберите дату' }}
                    </Button>
                  </PopoverTrigger>
                  <PopoverContent class="w-auto p-0">
                    <Calendar v-model="value" initial-focus />
                  </PopoverContent>
                </Popover>
              </div>
            </div>
          </div>
          <!-- Безопасность -->
          <div class="flex gap-6 flex-col w-full">
            <div class="flex justify-between">
              <h3>Безопасность</h3>
              <Button type="submit">Обновить</Button>
            </div>
            <div class="flex flex-col gap-3">
              <div class="flex gap-4 items-center">
                <p class="w-[96px]">ФИО</p>
                <Input
                  type="password"
                  placeholder="Ваш текущий пароль..."
                  v-bind="componentField"
                />
              </div>
              <div class="flex gap-4 items-center">
                <p class="w-[96px]">Почта</p>
                <Input type="password" placeholder="Ваш новый пароль..." v-bind="componentField" />
              </div>
            </div>
          </div>
        </div>
        <!-- Рассылки -->
        <div class="flex gap-8 w-full">
          <div class="flex">
            <div class="flex gap-6 flex-col w-full">
              <div class="flex justify-between">
                <h3>Рассылки</h3>
              </div>
              <div class="flex flex-col gap-3">
                <!-- Чекбокс с подписью -->
                <div class="items-top flex gap-x-2">
                  <Checkbox id="terms1" />
                  <div class="grid gap-1.5 leading-none">
                    <label
                      for="terms1"
                      class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70"
                    >
                      Крутая рассылка!
                    </label>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar'
import { Button } from '@/components/ui/button'

import { Input } from '@/components/ui/input'

import { ref } from 'vue'
import { DateFormatter, getLocalTimeZone } from '@internationalized/date'

import { Calendar as CalendarIcon } from 'lucide-vue-next'
import { Calendar } from '@/components/ui/calendar'
import { Popover, PopoverContent, PopoverTrigger } from '@/components/ui/popover'
import { cn } from '@/lib/utils'

import { Checkbox } from '@/components/ui/checkbox'

const df = new DateFormatter('en-US', {
  dateStyle: 'long'
})

const value = ref()
</script>
