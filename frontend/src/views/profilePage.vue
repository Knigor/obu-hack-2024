<template>
  <div class="flex flex-col gap-8">
    <Header />
    <main class="flex gap-8 px-16">
      <Card class="h-fit">
        <nav class="flex flex-col gap-1">
          <RouterLink to="/profilePage/favorites">
            <Button class="flex gap-2 justify-start w-[250px]"><Heart /> Избранное</Button>
          </RouterLink>
          <RouterLink to="/profilePage/history">
            <Button variant="ghost" class="flex gap-2 justify-start w-[250px]"
              ><History /> История</Button
            >
          </RouterLink>
          <RouterLink to="/profilePage/settings">
            <Button variant="ghost" class="flex gap-2 justify-start w-[250px]"
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
</script>
