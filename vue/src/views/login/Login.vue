<template>
    <div class="authentication">
        <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
            <div class="relative flex flex-col justify-center h-screen overflow-hidden">
                <div class="w-100 h-100 p-6 mx-auto rounded-md border border-gray-600 shadow-md lg:max-w-lg">
                    <h1 class="text-3xl font-semibold text-center" style="margin-top: 1rem;">Log In</h1>
                    <div class="space-y-4" style="margin: 2.5rem 1.5rem;">
                        <div style="margin-bottom: 1.5rem;">
                            <label class="label">
                                <span class="label-text">Email</span>
                            </label>
                            <input type="text" placeholder="Email Address" class="w-full rounded-md border border-gray-600" style="padding: 0.5rem 0.5rem;" v-bind="email" />
                        </div>
                        <div>
                            <label class="label">
                                <span class="label-text">Password</span>
                            </label>
                            <input type="password" placeholder="Enter Password" class="w-full rounded-md border border-gray-600" style="padding: 0.5rem 0.5rem;" v-bind="password" />
                        </div>
                        <a href="#" class="text-xs hover:underline hover:text-blue-600">Forget Password?</a>
                        <div style="margin-top: 1rem;">
                            <button class="btn btn-primary btn-block" @click="submit">Login</button>
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
import { onBeforeMount, onMounted, watch } from 'vue';

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

onBeforeMount(() => {
    if (loggedInUser) {
        console.log(">>>> User detected. Redirecting to dashboard --->")
        router.replace({ name: 'dashboard' })
    }
})
</script>

<style lang="scss" scoped>
.btn {
    text-align: center;
    padding: 0.25rem 1rem;
    color: var(--white);
    background-color: var(--primary);
    border-radius: 5px;
    align-items: center;
}

</style>
   