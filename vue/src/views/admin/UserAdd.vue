<template>
    <Header :title="'Add User'" :subtitle="''" />

    <Container class="w-1/2 ms-auto me-auto">
        <div class="card bg-gray-700 card-md shadow-sm mb-2">
            <div class="card-body text-green-500 m-4">
                <div class="card-title text-2xl">User Details</div>
                <div class="mb-1">
                    <label class="label">
                        <span class="text-green-500 label-text font-bold">Name</span>
                    </label>
                    <input type="text" class="input w-full rounded-md border border-gray-600" v-bind="name" />
                    <small class="text-red-500">{{ errors.name }}</small>
                </div>
                <div class="mb-1">
                    <label class="label">
                        <span class="text-green-500 label-text font-bold">Email</span>
                    </label>
                    <input type="text" class="input w-full rounded-md border border-gray-600" v-bind="email" />
                    <small class="text-red-500">{{ errors.email }}</small>
                </div>
                <div class="mb-1">
                    <label class="label">
                        <span class="text-green-500 label-text font-bold">Password</span>
                    </label>
                    <input type="password" class="input w-full rounded-md border border-gray-600" v-bind="password" />
                    <small class="text-red-500">{{ errors.password }}</small>
                </div>
                <div class="mt-1 text-right">
                    <button class="btn btn-success" @click="submit">Add User</button>
                </div>
            </div>
        </div>
    </Container>
</template>

<script lang="ts" setup>
import { useRouter } from 'vue-router';
import { useForm } from 'vee-validate'
import { number, object, string } from 'yup'
import { type UserForm, useUserStore } from '../../stores/users';

const router = useRouter()
const { saveUser } = useUserStore()

const passwordRules = /^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/;
// 1 upper case letter, 1 lower case letter, 1 numeric digit.


const { values, meta, errors, defineInputBinds, handleSubmit } = useForm<UserForm>({
    validationSchema: object({
        name: string()
            .required("Please enter a username"),
        email: string()
            .required("Please enter a valid email")
            .email("Not a valid email"),
        password: string()
            .required("Please enter a valid password")
            .min(8, "Password should be 8 characters minimum")
            .matches(passwordRules, "Password must contain  1 upper case letter, 1 lower case letter, 1 numeric & 1 symbol"),
    })
})

const name = defineInputBinds('name')
const email = defineInputBinds('email')
const password = defineInputBinds('password')

const submit = handleSubmit(async (values) => {
    try {
        await saveUser(values)
        router.replace({ name: 'users' })

    } catch (error) {
        console.log(">>>> Company add error: ", error)
    }
})

</script>