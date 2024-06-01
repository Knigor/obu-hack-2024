<template>
  <div class="flex items-center justify-between mt-2">
    <div @click="goToMain" class="flex items-center gap-2 ml-12 cursor-pointer">
      <Plane color="green" />
      <p class="text-2xl text-green-900 font-semibold">5-fly</p>
    </div>
    <div class="flex gap-2 items-center mr-12">
      <div class="flex gap-2 items-center" v-if="isVisible">
        <img class="w-[30px] h-[30px]" :src="`http://localhost:8080/img/${avatar}`" />
        <p>{{ user }}</p>
        <Button @click="goToProfile" variant="link">Профиль</Button>
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
import { Plane } from 'lucide-vue-next'

console.log(localStorage)

let isVisible = ref(false)

let user = ref('')

let avatar = ref('')

let router = useRouter()

if (localStorage.length !== 0) {
  isVisible.value = true
  user.value = localStorage.full_name
  avatar.value = localStorage.photo_user
} else {
  isVisible.value = false
}

const outUser = async () => {
  isVisible.value = false
  localStorage.clear()
}

const goToMain = () => {
  router.push('/')
}

const goToProfile = () => {
  router.push('/profilePage')
}

const authPage = () => {
  router.push('/authPage')
}
</script>

<style lang="scss" scoped></style>
