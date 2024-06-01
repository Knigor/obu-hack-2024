<template>
  <section class="flex flex-col gap-6">
    <h3>Всего {{ placesAmount }} мест</h3>
    <div class="flex flex-col gap-4">
      <div class="flex gap-4">
        <FavoritePlace />
        <FavoritePlace />
      </div>
      <div class="flex gap-4">
        <FavoritePlace />
        <FavoritePlace />
      </div>
      <div class="flex gap-4">
        <FavoritePlace />
        <FavoritePlace />
      </div>
    </div>
  </section>
</template>

<script setup>
import FavoritePlace from '@/components/custom/profile/FavoritePlace.vue'

import { ref } from 'vue'
const placesAmount = ref(69) // Сколько всего избранных мест
</script>
