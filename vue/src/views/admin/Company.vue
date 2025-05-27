<template>
    <Header :title="companyName" :subtitle="''" />

    <Container class="ms-auto me-auto">
        <div class="card bg-gray-700 card-md shadow-sm mb-2">
            <div class="card-body grid grid-cols-4 text-green-500">
                <div class="">
                    <label class="label">
                        <span class="text-green-500 label-text font-bold">Name</span>
                    </label>
                    <input type="text" class="input w-full rounded-md border border-gray-600" v-model="companyName" />
                </div>
                <div class="">
                    <label class="label">
                        <span class="text-green-500 label-text font-bold">ABN</span>
                    </label>
                    <input type="text" class="input w-full rounded-md border border-gray-600" v-model="companyAbn" />
                </div>
                <div class="">
                    <label class="label">
                        <span class="text-green-500 label-text font-bold">Email</span>
                    </label>
                    <input type="text" class="input w-full rounded-md border border-gray-600" v-model="companyEmail" />
                </div>
                <div class="">
                    <label class="label">
                        <span class="text-green-500 label-text font-bold">Address</span>
                    </label>
                    <input type="text" class="input w-full rounded-md border border-gray-600" v-model="companyAddress" />
                </div>
            </div>
            <div class="text-center mb-2">
                <button class="btn btn-success" @click="submit">Update Company Details</button>
            </div>
        </div>

        <div class="flex mt-10">
            <h2 class="text-3xl text-left text-green-500">EMPLOYEES</h2>
            <router-link :to="{ name: 'employee.add', params: { company: route.params.id }}" class="mt-auto ms-auto">
                <button class="btn btn-success">+ Employee</button>
            </router-link>
        </div>
        <div class="card bg-gray-700 text-green-500 card-md shadow-sm mt-3 mb-2">
            <div class="card-body grid grid-cols-5 text-green-500 border-b-2">
                <div class="card-title">FIRST</div>
                <div class="card-title">LAST</div>
                <div class="card-title">EMAIL</div>
                <div class="card-title">ADDRESS</div>
                <div class="card-title">ACTIONS</div>
            </div>
            <template v-if="company?.employees.length == 0">
                <div class="card-body">
                    <div class="text-2xl text-center">No employees found</div>
                </div>
            </template>
            <template v-else>
                <div v-for="employee in company?.employees" class="card-body py-3 grid grid-cols-5 listitem">
                    <div class="card-title">{{ employee?.first_name }}</div>
                    <div class="card-title">{{ employee?.last_name }}</div>
                    <div class="card-title">{{ employee?.email }}</div>
                    <div class="card-title">{{ employee?.address }}</div>
                    <div class="card-title">
                        <router-link :to="{ name: 'employee.single', params: { company: companyId, employee: employee.id }}">
                            <button class="btn btn-soft btn-success">Edit</button>
                        </router-link>
                        <button class="btn btn-outline btn-error" @click="removeEmployee(employee.id)">Delete</button>
                    </div>
                </div>
            </template>
        </div>
    </Container>
</template>

<script lang="ts" setup>
import { onBeforeMount } from 'vue';
import { storeToRefs } from 'pinia';

import { useCompanyStore } from '../../stores/companies';
import { useEmployeeStore } from '../../stores/employees';
import { getCompanyComputedVals } from '../../composables/company-computed';
import { useRoute } from 'vue-router';

const route = useRoute()

const { deleteEmployee } = useEmployeeStore()
const { getCompany, updateCompany } = useCompanyStore()
const { company } = storeToRefs(useCompanyStore())
const { 
        companyId,
        companyName,
        companyAbn,
        companyEmail,
        companyAddress
    } = getCompanyComputedVals()

onBeforeMount(async () => {
    await getCompany(route.params.id)
})

const submit = async () => {
    try {
        const payload = {
            id: company.value?.id,
            name: companyName.value,
            abn: companyAbn.value,
            email: companyEmail.value,
            address: companyAddress.value,
        }
        console.log(">>> Update Payload: ", payload)
        await updateCompany(payload)
    } catch (error) {
        console.log(">>>> Errors: ", error)
    }
}

const removeEmployee = async (empId) => {
    try {
        if (window.confirm("Are youe sure you want to delete this employee?")) {
            await deleteEmployee(empId).then(async () => await getCompany(route.params.id))
        }
    } catch (error) {
        console.log(">>>> Delete Employee err: ", error)
    }
}

</script>

<style scoped>
.listitem:hover {
    background-color: var(--dark);
}
</style>