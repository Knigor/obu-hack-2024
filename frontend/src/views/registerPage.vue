<template>
  <div class="flex items-center justify-center h-screen">
    <div class="flex flex-col items-center gap-10">
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

const router = useRouter()

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

  console.log(userData)

  console.log('Клик')

  apiFormData.append('login', userData.login)
  apiFormData.append('fio', userData.FIO)
  apiFormData.append('password', userData.password)

  try {
    const response = await axios.post('http://localhost/add-user', apiFormData, {
      headers: {
        'Content-Type': 'multipart/form-data'
      }
    })

    console.log(response.data)

    // Всплывашка тостер

    const { toast } = useToast()

    if (response.data.status == 'error') {
      toast({
        description: 'Ошибка регистрации, пользователь с таким логином уже существует',
        variant: 'destructive'
      })
      return
    }

    if (response.data.status == 'success') {
      localStorage.clear()
      localStorage.setItem('id_user', response.data.User.id)
      localStorage.setItem('login', response.data.User.login)
      localStorage.setItem('full_name', response.data.User.fio)
      router.push('/')
    }
  } catch (error) {
    console.error('Ошибка при отправке данных:', error)
  }
})
</script>

<style lang="scss" scoped></style>