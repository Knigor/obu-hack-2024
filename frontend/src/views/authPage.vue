<template>
  <div class="flex items-center justify-center h-screen gap-24">
    <div class="relative hidden h-full flex-col bg-muted p-10 text-white dark:border-r lg:flex">
      <div class="absolute inset-0 bg-image"></div>

      <div class="relative z-20 flex items-center text-lg font-medium gap-2">
        <PlaneTakeoff />
        5-fly
      </div>
      <div class="relative z-20 mt-auto">
        <blockquote class="space-y-2">
          <p class="text-lg">
            “Стратегия без тактики — это самый медленный путь к победе. Тактика без стратегии — это
            просто суета перед поражением.”
          </p>
          <footer class="text-sm">Сунь Цзы</footer>
        </blockquote>
      </div>
    </div>

    <div class="flex flex-col items-center gap-4 mr-12">
      <h1 class="font-bold">Добро пожаловать</h1>
      <div class="border-t h-5 w-96 border-green-600"></div>

      <div class="grid w-full max-w-sm items-center gap-1.5">
        <form class="w-96 space-y-6" @submit="onSubmit">
          <FormField v-slot="{ componentField: EmailField }" name="email">
            <FormItem>
              <FormLabel>Почта</FormLabel>
              <FormControl>
                <Input type="text" placeholder="Введите вашу почту" v-bind="EmailField" />
              </FormControl>
              <FormMessage />
            </FormItem>
          </FormField>
          <FormField v-slot="{ componentField: PasswordField }" name="password">
            <FormItem>
              <FormLabel>Пароль</FormLabel>
              <FormControl>
                <Input type="password" placeholder="Введите ваш пароль" v-bind="PasswordField" />
              </FormControl>
              <FormMessage />
            </FormItem>
          </FormField>

          <div class="flex flex-col">
            <Toaster />
            <div class="flex">
              <Button type="submit" class="bg-green-500 w-32 text-white mr-5"> Войти </Button>
              <Button @click="goToRegister" class="w-64 bg-slate-400"> Зарегистрироваться </Button>
            </div>

            <Button @click="goToMain" class="w-[50px] ml-36 mt-2" variant="link">На главную</Button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup>
import { useRoute, useRouter } from 'vue-router'
import { Toaster } from '@/components/ui/toast'
import { useToast } from '@/components/ui/toast/use-toast'
import { Input } from '@/components/ui/input'
import { Button } from '@/components/ui/button'
import { Label } from '@/components/ui/label'
import { toTypedSchema } from '@vee-validate/zod'
import { useForm } from 'vee-validate'
import * as z from 'zod'
import { h } from 'vue'
import {
  FormControl,
  FormDescription,
  FormField,
  FormItem,
  FormLabel,
  FormMessage
} from '@/components/ui/form'
import { ref } from 'vue'
import axios from 'axios'
import { PlaneTakeoff } from 'lucide-vue-next'
import CryptoJS from 'crypto-js'

// Переход на страницу регистрации

const router = useRouter()

const goToRegister = () => {
  router.push('/registerPage')
}

// Валидация полей ввода

const formSchema = toTypedSchema(
  z.object({
    email: z
      .string({ required_error: 'Поле не должно быть пустым' })
      .email('Это не действительная почта'),
    password: z
      .string({ required_error: 'Поле не должно быть пустым' })
      .min(3, { message: 'Пароль должен содержать минимум 3 символа' })
      .max(20, { message: 'Пароль должен содержать не больше 20 символов' })
  })
)

const { handleSubmit, errors } = useForm({
  validationSchema: formSchema
})

const goToMain = () => {
  localStorage.clear()
  router.push('/')
}

const onSubmit = handleSubmit(async (formData) => {
  const apiFormData = new FormData()
  const userData = formData

  const hashedPassword = CryptoJS.SHA256(userData.password).toString(CryptoJS.enc.Hex)

  apiFormData.append('email', userData.email)
  apiFormData.append('password', hashedPassword)

  try {
    const response = await axios.post('http://localhost:8080/auth.php', apiFormData, {
      headers: {
        'Content-Type': 'multipart/form-data'
      }
    })
    console.log(response.data)

    if (response.data.status == 'success') {
      localStorage.clear()
      localStorage.setItem('id_user', response.data.id_user)
      localStorage.setItem('role', response.data.role)
      localStorage.setItem('full_name', response.data.full_name)
      localStorage.setItem('photo_user', response.data.full_name)
      router.push('/')
    }

    // Высплывашка тостер

    const { toast } = useToast()

    if (response.data.status == 'error') {
      toast({
        description: 'Ошибка авторизации, введен не правильный логин или пароль',
        variant: 'destructive'
      })
    }
  } catch (error) {
    console.error('Ошибка при отправке данных:', error)
  }
})

// Сделать логику для авторизации
</script>

<style scoped>
.bg-image {
  background-image: url('../img/0312171055_1148655060.jpg');
  background-size: cover; /* Масштабировать изображение, чтобы оно покрывало весь элемент */
  background-position: center; /* Центрировать изображение */
  background-repeat: no-repeat; /* Не повторять изображение */
}
</style>
