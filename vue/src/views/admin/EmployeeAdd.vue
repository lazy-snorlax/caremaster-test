<template>
    <Header :title="`Add Employee to ${companyName}`" :subtitle="''" />

    <Container class="w-1/2 ms-auto me-auto">
        <div class="card bg-gray-700 card-md shadow-sm mb-2">
            <div class="card-body text-green-500 m-4">
                <div class="card-title text-2xl">Employee Details</div>
                <div class="mb-1">
                    <label class="label">
                        <span class="text-green-500 label-text font-bold">First Name</span>
                    </label>
                    <input type="text" class="input w-full rounded-md border border-gray-600" v-bind="first_name" />
                    <small class="text-red-500">{{ errors.first_name }}</small>
                </div>
                <div class="mb-1">
                    <label class="label">
                        <span class="text-green-500 label-text font-bold">Last Name</span>
                    </label>
                    <input type="text" class="input w-full rounded-md border border-gray-600" v-bind="last_name" />
                    <small class="text-red-500">{{ errors.last_name }}</small>
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
                    <button class="btn btn-success" @click="submit">Add Employee</button>
                </div>
            </div>
        </div>
    </Container>
</template>

<script lang="ts" setup>
import { useForm } from 'vee-validate'
import { useCompanyStore } from '../../stores/companies';
import { getCompanyComputedVals } from '../../composables/company-computed';
import { type EmployeeForm, useEmployeeStore } from '../../stores/employees';
import { useRoute, useRouter } from 'vue-router';
import { number, object, string } from 'yup'
import { onBeforeMount } from 'vue';

const { getCompany } = useCompanyStore()
const { companyId, companyName } = getCompanyComputedVals()
const { saveEmployee } = useEmployeeStore()

const router = useRouter()
const route = useRoute()

onBeforeMount(async () => {
    await getCompany(route.params.company)
})

const { values, meta, errors, defineInputBinds, handleSubmit } = useForm<EmployeeForm>({
    validationSchema: object({
        first_name: string().required(),
        last_name: string().required(),
        email: string().email().required(),
        address: string().required(),
    })
})

const first_name = defineInputBinds('first_name')
const last_name = defineInputBinds('last_name')
const email = defineInputBinds('email')
const address = defineInputBinds('address')

const submit = handleSubmit(async (values) => {
    try {
        // Object.assign(values, { company_id: companyId.value })
        await saveEmployee({...values, ...{ company_id: companyId.value }})
        router.replace({ name: 'companies.single', params: { id: companyId.value } })

    } catch (error) {
        console.log(">>>> Employee add error: ", error)
    }
})

</script>