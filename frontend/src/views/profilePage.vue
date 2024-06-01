<template>
  <div class="flex flex-col gap-8">
    <Header />
    <main class="flex gap-8">
      <Card>
        <nav class="flex flex-col gap-1">
          <Button class="flex gap-2 justify-start w-[320px]"><Heart /> Избранное</Button>
          <Button variant="ghost" class="flex gap-2 justify-start w-[320px]"
            ><History /> История</Button
          >
          <Button variant="ghost" class="flex gap-2 justify-start w-[320px]"
            ><Settings /> Настройки</Button
          >
        </nav>
      </Card>
      <section>
        <h3>Всего {{ placesAmount }} мест</h3>
      </section>
    </main>
  </div>
</template>

<script setup>
import Header from '@/components/custom/profile/header.vue'
import { Button } from '@/components/ui/button'

import { Heart, History, Settings } from 'lucide-vue-next'
import { Card } from '@/components/ui/card'

import { ref } from 'vue'

const placesAmount = ref(69) // Сколько всего избранных мест
</script>
