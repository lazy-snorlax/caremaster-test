<template>
    <div class="hero bg-base-200 min-h-screen">
        <div class="hero-content">
            <div class="relative flex flex-col justify-center h-screen overflow-hidden">
                <div class="w-full p-6 m-auto bg-base-100 rounded-md shadow-md lg:max-w-lg">
                    <h1 class="text-3xl font-semibold text-center">Log In</h1>
                    <div class="space-y-4">
                        <div>
                            <label class="label">
                                <span class="label-text">Email</span>
                            </label>
                            <input type="text" placeholder="Email Address" class="w-full input input-bordered" v-bind="email" />
                        </div>
                        <div>
                            <label class="label">
                                <span class="label-text">Password</span>
                            </label>
                            <input type="password" placeholder="Enter Password" class="w-full input input-bordered" v-bind="password" />
                        </div>
                        <a href="#" class="text-xs hover:underline hover:text-blue-600">Forget Password?</a>
                        <div>
                            <button class="btn-primary btn btn-block" @click="submit">Login</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
  
<script lang="ts" setup>
import { AxiosError, isAxiosError } from 'axios'
import { storeToRefs } from 'pinia'
import { onMounted, watch } from 'vue';

import { useAppStore, type LoginForm } from '../../stores/app';
import { useRouter, useRoute } from 'vue-router'

import { useLoggedInUser } from '../../composables/use-logged-in-user';

import { useForm } from 'vee-validate'
import { object, string, number, date, InferType } from 'yup'

const authStore  = useAppStore()
const { login }  = useAppStore()
const { loggedInUser } = useLoggedInUser()

const { user, error } = storeToRefs(authStore)

const router = useRouter()
const route = useRoute()

const { values, meta, errors, defineInputBinds, handleSubmit } = useForm<LoginForm>({
    validationSchema: object({
        email: string().email().required(),
        password: string().required()
    })
})

const email = defineInputBinds('email')
const password = defineInputBinds('password')

const submit = handleSubmit(async (values) => {
    try {
        await login(values)

        if (route.query.redirect) {
            router.replace(route.query.redirect as string)
        } else {
            router.replace({ name: 'dashboard' })
        }
    } catch (error) {
        if (isAxiosError(error) && error.response && error.response.status === 429) {
            // TODO: Too many attempts error
            return
        }
        if (isAxiosError(error) && error.response && error.response.status === 422) {
            alert(error.response.data.message)
            return
        }
        throw error.response
    }
})


</script>
   