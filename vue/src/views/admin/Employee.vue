<template>
    <Header :title="employeeFirstName + ' ' + employeeLastName" :subtitle="''" />

    <Container class="w-1/2 ms-auto me-auto">
        <div class="card bg-gray-700 card-md shadow-sm mb-2">
            <div class="card-body grid grid-cols-1 text-green-500">
                <div class="">
                    <label class="label">
                        <span class="text-green-500 label-text font-bold">First Name</span>
                    </label>
                    <input type="text" class="input w-full rounded-md border border-gray-600" v-model="employeeFirstName" />
                </div>
                <div class="">
                    <label class="label">
                        <span class="text-green-500 label-text font-bold">Last Name</span>
                    </label>
                    <input type="text" class="input w-full rounded-md border border-gray-600" v-model="employeeLastName" />
                </div>
                <div class="">
                    <label class="label">
                        <span class="text-green-500 label-text font-bold">Email</span>
                    </label>
                    <input type="text" class="input w-full rounded-md border border-gray-600" v-model="employeeEmail" />
                </div>
                <div class="">
                    <label class="label">
                        <span class="text-green-500 label-text font-bold">Address</span>
                    </label>
                    <input type="text" class="input w-full rounded-md border border-gray-600" v-model="employeeAddress" />
                </div>
            </div>
            <div class="text-center mb-2">
                <button class="btn btn-success" @click="submit">Update Employee Details</button>
            </div>
        </div>
    </Container>
</template>

<script lang="ts" setup>
import { storeToRefs } from 'pinia';
import { useEmployeeStore } from '../../stores/employees';
import { useRoute, useRouter } from 'vue-router';
import { onBeforeMount } from 'vue';
import { getEmployeeComputedVals } from '../../composables/employee-computed';
import { getCompanyComputedVals } from '../../composables/company-computed';
import { useCompanyStore } from '../../stores/companies';

const { getEmployee, updateEmployee } = useEmployeeStore()
const { getCompany } = useCompanyStore()
const route = useRoute()
const router = useRouter()
const { companyId } = getCompanyComputedVals()
const { 
        employeeId,
        employeeFirstName,
        employeeLastName,
        employeeEmail,
        employeeAddress
    } = getEmployeeComputedVals()

onBeforeMount(async () => {
    await getEmployee(route.params.employee)
    await getCompany(route.params.company)
})

const submit = async () => {
    try {
        const payload = {
            id: employeeId.value,
            first_name: employeeFirstName.value,
            last_name: employeeLastName.value,
            email: employeeEmail.value,
            address: employeeAddress.value,
        }
        console.log(">>> Update Payload: ", payload)
        await updateEmployee(payload)

        router.replace({ name: 'companies.single', params: { id: companyId.value } })
    } catch (error) {
        console.log(">>>> Errors: ", error)
    }
}

</script>