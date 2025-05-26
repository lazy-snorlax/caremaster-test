<template>
    <Header :title="'Add Company'" :subtitle="''" />

    <Container class="w-1/2 ms-auto me-auto">
        <div class="card bg-gray-700 card-md shadow-sm mb-2">
            <div class="card-body text-green-500 m-4">
                <div class="card-title text-2xl">Company Details</div>
                <div class="mb-1">
                    <label class="label">
                        <span class="text-green-500 label-text font-bold">Name</span>
                    </label>
                    <input type="text" class="input w-full rounded-md border border-gray-600" v-bind="name" />
                    <small class="text-red-500">{{ errors.name }}</small>
                </div>
                <div class="mb-1">
                    <label class="label">
                        <span class="text-green-500 label-text font-bold">ABN</span>
                    </label>
                    <input type="text" class="input w-full rounded-md border border-gray-600" v-bind="abn" />
                    <small class="text-red-500">{{ errors.abn }}</small>
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
                        <span class="text-green-500 label-text font-bold">Address</span>
                    </label>
                    <input type="text" class="input w-full rounded-md border border-gray-600" v-bind="address" />
                    <small class="text-red-500">{{ errors.address }}</small>
                </div>
                <div class="mt-1 text-right">
                    <button class="btn btn-success" @click="submit">Add Company</button>
                </div>
            </div>
        </div>
    </Container>
</template>

<script lang="ts" setup>
import { useCompanyStore, type CompanyForm } from '../../stores/companies';
import { useRouter } from 'vue-router';
import { useForm } from 'vee-validate'
import { number, object, string } from 'yup'

const { saveCompany } = useCompanyStore()
const router = useRouter()

const { values, meta, errors, defineInputBinds, handleSubmit } = useForm<CompanyForm>({
    validationSchema: object({
        name: string().required(),
        abn: number().positive().min(1000000000).max(99999999999).required(),
        email: string().email().required(),
        address: string().required(),
    })
})

const name = defineInputBinds('name')
const abn = defineInputBinds('abn')
const email = defineInputBinds('email')
const address = defineInputBinds('address')

const submit = handleSubmit(async (values) => {
    try {
        await saveCompany(values)
        router.replace({ name: 'companies' })

    } catch (error) {
        console.log(">>>> Company add error: ", error)
    }
})

</script>