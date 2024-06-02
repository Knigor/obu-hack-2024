<template>
  <div class="flex flex-col gap-8">
    <Header />
    <main class="flex gap-8 px-16">
      <Card class="h-fit">
        <nav class="flex flex-col gap-1">
          <RouterLink to="/profilePage/favorites">
            <Button
              @click="
                () => {
                  changeMenuSelect(1)
                }
              "
              :variant="btnVariant1"
              class="flex gap-2 justify-start w-[250px]"
              ><Heart /> Избранное</Button
            >
          </RouterLink>
          <RouterLink to="/profilePage/history">
            <Button
              @click="
                () => {
                  changeMenuSelect(2)
                }
              "
              :variant="btnVariant2"
              class="flex gap-2 justify-start w-[250px]"
              ><History /> История</Button
            >
          </RouterLink>
          <RouterLink to="/profilePage/settings">
            <Button
              @click="
                () => {
                  changeMenuSelect(3)
                }
              "
              :variant="btnVariant3"
              class="flex gap-2 justify-start w-[250px]"
              ><Settings /> Настройки</Button
            >
          </RouterLink>
        </nav>
      </Card>
      <router-view />
    </main>
  </div>
</template>

<script setup>
import Header from '@/components/custom/profile/header.vue'
import { Button } from '@/components/ui/button'

import { Heart, History, Settings } from 'lucide-vue-next'
import { Card } from '@/components/ui/card'
import { ref } from 'vue'

let btnVariant1 = 'ghost'
let btnVariant2 = 'ghost'
let btnVariant3 = 'ghost'

function changeMenuSelect(btnID) {
  btnVariant1 = 'ghost'
  btnVariant2 = 'ghost'
  btnVariant3 = 'ghost'

  if (btnID == 1) btnVariant1 = ''
  else if (btnID == 2) btnVariant2 = ''
  else if (btnID == 3) btnVariant3 = ''
}
</script>
