<template>
    <Header :title="companyName" :subtitle="''" />

    <Container class="ms-auto me-auto">
        <div class="card bg-gray-700 card-md shadow-sm mb-2">
            <div class="card-body grid grid-cols-5 text-green-500">
                <div class="mb-1">
                    <label class="label">
                        <span class="text-green-500 label-text font-bold">Name</span>
                    </label>
                    <input type="text" class="input w-full rounded-md border border-gray-600" v-model="companyName" />
                </div>
                <div class="mb-1">
                    <label class="label">
                        <span class="text-green-500 label-text font-bold">ABN</span>
                    </label>
                    <input type="text" class="input w-full rounded-md border border-gray-600" v-model="companyAbn" />
                </div>
                <div class="mb-1">
                    <label class="label">
                        <span class="text-green-500 label-text font-bold">Email</span>
                    </label>
                    <input type="text" class="input w-full rounded-md border border-gray-600" v-model="companyEmail" />
                </div>
                <div class="mb-1">
                    <label class="label">
                        <span class="text-green-500 label-text font-bold">Address</span>
                    </label>
                    <input type="text" class="input w-full rounded-md border border-gray-600" v-model="companyAddress" />
                </div>
                <div class="mt-auto mb-auto text-right">
                    <button class="btn btn-success" @click="submit">Update Company</button>
                </div>
            </div>
        </div>

        <div class="flex">
            <h2 class="text-3xl text-left text-green-500 mt-10">EMPLOYEES</h2>
            <button class="mt-auto ms-auto btn btn-success">+ Employee</button>
        </div>
        <div class="card bg-gray-700 text-green-500 card-md shadow-sm mb-2">
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
            <div v-else class="card-body grid grid-cols-5 listitem">
                <template v-for="employee in company?.employees">
                    <div class="card-title">{{ employee?.name }}</div>
                    <div class="card-title">{{ employee?.name }}</div>
                    <div class="card-title">{{ employee?.name }}</div>
                    <div class="card-title">{{ employee?.name }}</div>
                    <div class="card-title">
                        <button class="btn btn-soft btn-success">Edit</button>
                        <button class="btn btn-outline btn-error">Delete</button>
                    </div>
                </template>
            </div>
        </div>
    </Container>
</template>

<script lang="ts" setup>
import { computed, onBeforeMount } from 'vue';
import { useCompanyStore } from '../../stores/companies';
import { storeToRefs } from 'pinia';

import { useRoute } from 'vue-router';

const route = useRoute()

const { company } = storeToRefs(useCompanyStore())
const { getCompany, updateCompany } = useCompanyStore()

const companyName = computed({
    get() { return company.value?.name },
    set(newVal) { company.value.name = newVal }
})
const companyAbn = computed({
    get() { return company.value?.abn },
    set(newVal) { company.value.abn = newVal }
})
const companyEmail = computed({
    get() { return company.value?.email },
    set(newVal) { company.value.email = newVal }
})
const companyAddress = computed({
    get() { return company.value?.address },
    set(newVal) { company.value.address = newVal }
})

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

</script>

<style scoped>
.listitem:hover {
    background-color: var(--dark);
}
</style>