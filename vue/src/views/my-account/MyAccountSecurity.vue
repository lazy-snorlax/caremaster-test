<template>
    <Container class="container-max-sm mx-auto p-4">
        <div class="my-account card">
            <div class="card-body">
                <div class="mx-auto">
                    <h2>Change Password</h2>
        
                    <div class="mb-3">
                        <label for="password">Current Password</label>
                        <input class="form-control" type="password" v-bind="current_password">
                        <small class="text-danger">{{ errors.current_password }}</small>
                    </div>
        
                    <div class="mb-3">
                        <label for="password">New Password</label>
                        <input class="form-control" type="password" name="password" v-bind="password">
                        <small class="text-danger">{{ errors.password }}</small>
                    </div>
        
                    <div class="mb-3">
                        <label for="password">Repeat New Password</label>
                        <input class="form-control" type="password" v-bind="password_confirmation">
                        <small class="text-danger">{{ errors.password_confirmation }}</small>
                    </div>
        
                    <div class="text-end mt-4">
                        <button class="btn btn-primary" @click="save">Change Password</button>
                    </div>
                </div>
            </div>
        </div>
    </Container>
</template>
<script lang="ts" setup>

import { useForm } from 'vee-validate';
import { useAppStore, type UpdatePasswordForm } from '../../stores/auth'
import { object, string, ref } from 'yup';

const { updateAccountPassword } = useAppStore()

const { defineInputBinds, handleSubmit, errors } = useForm<UpdatePasswordForm>({
    validationSchema: object({
        current_password: string().required(),
        password: string().required(),
        password_confirmation: string().required().equals([ref('password')], 'The repeated password does not match'),
    })
})

const current_password = defineInputBinds('current_password')
const password = defineInputBinds('password')
const password_confirmation = defineInputBinds('password_confirmation')

const save = handleSubmit(async (values, { resetForm }) => {
    // TODO: Update Account Password - toast/alert on success?
    await updateAccountPassword(values)
    console.log('Password saved successfully?')
    resetForm()
})

</script>