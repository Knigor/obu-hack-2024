<template>
  <div class="flex items-center justify-center h-screen">
    <div class="relative hidden h-full flex-col bg-muted p-10 text-white dark:border-r lg:flex">
      <div class="absolute inset-0 bg-image"></div>

      <div class="relative z-200 flex items-center text-lg font-medium gap-2">
        <Plane />
        <p class="text-2xl font-semibold">5-fly</p>
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

    <div class="flex flex-col items-center gap-4 ml-24 mr-12">
      <h2>Зарегистрируйтесь</h2>
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
          <FormField v-slot="{ componentField: FioField }" name="FIO">
            <FormItem>
              <FormLabel>ФИО</FormLabel>
              <FormControl>
                <Input type="text" placeholder="Введите ваше ФИО" v-bind="FioField" />
              </FormControl>
              <FormMessage />
            </FormItem>
          </FormField>
          <FormField v-slot="{ componentField: passwordField }" name="password">
            <FormItem>
              <FormLabel>Пароль</FormLabel>
              <FormControl>
                <Input type="password" placeholder="Придумайте пароль" v-bind="passwordField" />
              </FormControl>
              <FormMessage />
            </FormItem>
          </FormField>

          <div class="flex">
            <Toaster />
            <Button type="submit" class="bg-green-500 w-64 text-white mr-5">
              Зарегистрироваться
            </Button>
            <Button @click="gotToLogin" class="w-32 bg-slate-400"> Войти </Button>
          </div>
        </form>
      </div>
      <Button @click="goToMain" class="w-[50px] mt-2" variant="link">На главную</Button>
    </div>
  </div>
</template>

<script setup>
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import { Button } from '@/components/ui/button'
import { Toaster } from '@/components/ui/toast'
import { useToast } from '@/components/ui/toast/use-toast'
import { useRoute, useRouter } from 'vue-router'
import { toTypedSchema } from '@vee-validate/zod'
import { useForm } from 'vee-validate'
import * as z from 'zod'
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
import { Plane } from 'lucide-vue-next'

const router = useRouter()

const goToMain = () => {
  localStorage.clear()
  router.push('/')
}

const gotToLogin = () => {
  router.push('/authPage')
}

// Сделать логику для регистрации

const formSchema = toTypedSchema(
  z.object({
    email: z
      .string({ required_error: 'Поле не должно быть пустым' })
      .email('Это не действительная почта'),
    password: z
      .string({ required_error: 'Поле не должно быть пустым' })
      .min(3, { message: 'Пароль должен содержать минимум 3 символа' })
      .max(20, { message: 'Пароль должен содержать не больше 20 символов' }),
    FIO: z
      .string({ required_error: 'Поле не должно быть пустым' })
      .regex(/([А-ЯЁ][а-яё]+[\-\s]?){3,}/, { message: 'Заполните правильно ФИО' })
  })
)

const { handleSubmit, errors } = useForm({
  validationSchema: formSchema
})

const onSubmit = handleSubmit(async (formData) => {
  const apiFormData = new FormData()
  const userData = formData

  const hashedPassword = await hashPassword(userData.password)

  console.log(hashedPassword)

  console.log(userData)

  console.log('Клик')

  apiFormData.append('email', userData.email)
  apiFormData.append('password', hashedPassword)
  apiFormData.append('full_name', userData.FIO)

  try {
    const response = await axios.post('http://localhost:8080/registration.php', apiFormData, {
      headers: {
        'Content-Type': 'multipart/form-data'
      }
    })

    console.log(response.data)

    // Всплывашка тостер

    const { toast } = useToast()

    if (response.data.status == 'error') {
      toast({
        description: 'Ошибка регистрации, пользователь с такой почтой уже существует',
        variant: 'destructive'
      })
      return
    }

    if (response.data.status == 'success') {
      localStorage.clear()
      localStorage.setItem('id_user', response.data.user.id_user)
      localStorage.setItem('role', response.data.user.role_user)
      localStorage.setItem('full_name', response.data.user.full_name_user)
      localStorage.setItem('photo_user', response.data.user.photo_user)
      router.push('/')
    }
  } catch (error) {
    console.error('Ошибка при отправке данных:', error)
  }
})

async function hashPassword(password) {
  const encoder = new TextEncoder()
  const data = encoder.encode(password)
  const hashBuffer = await crypto.subtle.digest('SHA-256', data)
  const hashArray = Array.from(new Uint8Array(hashBuffer))
  const hashHex = hashArray.map((b) => b.toString(16).padStart(2, '0')).join('')
  return hashHex
}
</script>

<style scoped>
.bg-image {
  background-image: url('../img/Viceory-Bali.png');
  background-size: cover; /* Масштабировать изображение, чтобы оно покрывало весь элемент */
  background-position: center; /* Центрировать изображение */
  background-repeat: no-repeat; /* Не повторять изображение */
}
</style>
