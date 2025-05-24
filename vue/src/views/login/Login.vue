<template>
    <div class="hero bg-base-200 min-h-screen">
        <div class="hero-content">
            <!-- <div class="card card-border w-100 bg-base-100 card-xl shadow-sm">
                <div class="card-body p-3">
                    <img src="" alt="" class="logo">
                    <h1 class="card-title">Log In</h1>
        
                    <div class="mb-3">
                        <label class="input validator">
                            <svg class="h-[1em] opacity-50" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                <g stroke-linejoin="round" stroke-linecap="round" stroke-width="2.5" fill="none" stroke="currentColor">
                                    <rect width="20" height="16" x="2" y="4" rx="2"></rect>
                                    <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"></path>
                                </g>
                            </svg>
                            <input type="text" v-bind="email" placeholder="Email Address" required>
                        </label>
                        <div class="validator-hint hidden">{{ errors.email }}</div>
                    </div>
        
                    <div class="mb-3">
                        <label class="input validator">
                            <svg class="h-[1em] opacity-50" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                <g stroke-linejoin="round" stroke-linecap="round" stroke-width="2.5" fill="none" stroke="currentColor">
                                    <path d="M2.586 17.414A2 2 0 0 0 2 18.828V21a1 1 0 0 0 1 1h3a1 1 0 0 0 1-1v-1a1 1 0 0 1 1-1h1a1 1 0 0 0 1-1v-1a1 1 0 0 1 1-1h.172a2 2 0 0 0 1.414-.586l.814-.814a6.5 6.5 0 1 0-4-4z"></path>
                                    <circle cx="16.5" cy="7.5" r=".5" fill="currentColor"></circle>
                                </g>
                            </svg>
                            <input type="password" v-bind="password" placeholder="Password" required>
                        </label>
                        <div class="validator-hint hidden">{{ errors.password }}</div>
                    </div>
        
                    <button class="btn btn-primary" @click="submit">Login</button>
                    
                </div>
            </div> -->

            <div class="relative flex flex-col justify-center h-screen overflow-hidden">
                <div class="w-full p-6 m-auto bg-base-100 rounded-md shadow-md lg:max-w-lg">
                    <h1 class="text-3xl font-semibold text-center">Log In</h1>
                    <form class="space-y-4">
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
                            <button class="btn-primary btn btn-block">Login</button>
                        </div>
                    </form>
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
   