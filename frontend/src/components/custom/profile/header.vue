<template>
  <div class="flex items-center justify-between mt-2">
    <div class="flex gap-2 ml-12">
      <p>Logo</p>
      <p>5-fly</p>
    </div>
    <div class="flex gap-2 items-center mr-12">
      <div class="flex gap-2 items-center" v-if="isVisible">
        <div class="w-[25px] h-[25px] rounded-xl bg-purple-400"></div>
        <p>Кретов Игорь Олегович</p>
        <Button variant="link">Профиль</Button>
        <Button @click="outUser" class="w-[50px] ml-2" variant="link">Выйти</Button>
      </div>
      <Button v-else @click="authPage" class="w-[50px] ml-2" variant="link">Войти</Button>
    </div>
  </div>
</template>

<script setup>
import { Button } from '@/components/ui/button'
import { onMounted, ref } from 'vue'
import axios from 'axios'
import { useRoute, useRouter } from 'vue-router'

let isVisible = ref(false)

const outUser = async () => {
  isVisible.value = false
}

const authPage = async () => {
  isVisible.value = true
}
</script>

<style lang="scss" scoped></style>
