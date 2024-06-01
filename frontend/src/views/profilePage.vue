<template>
  <div>
    <header />
    <main class="flex gap-8">
      <nav class="flex flex-row">
        <Button variant="ghost" class="flex gap-2"><Heart /> Избранное</Button>
        <Button variant="ghost" class="flex gap-2"><History /> История</Button>
        <Button variant="ghost" class="flex gap-2"><Settings /> Настройки</Button>
      </nav>
    </main>
    <section>
      <h3>Всего {{ placesAmount }} мест</h3>
    </section>
  </div>
</template>

<script setup>
import header from '@/components/custom/profile/header.vue'
import Button from '@/components/ui/button'

import { Heart, History, Settings } from 'lucide-vue-next'

import { ref } from 'vue'

const placesAmount = ref(69) // Сколько всего избранных мест
</script>
