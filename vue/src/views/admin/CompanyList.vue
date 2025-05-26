<template>
    <Header :title="'Companies'" :subtitle="''" />

    <Container class="ms-auto me-auto">
        <div class="text-center mb-3">
            <router-link :to="{ name: 'companies.add' }">
                <button class="btn btn-success">+ Company</button>
            </router-link>
        </div>
        <div class="card bg-gray-700 card-md shadow-sm mb-2">
            <div class="card-body grid grid-cols-4 text-green-500 border-b-2">
                <div class="card-title">NAME</div>
                <div class="card-title">ABN</div>
                <div class="card-title">EMAIL</div>
                <div class="card-title">ADDRESS</div>
            </div>
            <template v-for="company in list">
                <router-link :to="{ name: 'companies.single', params: { id: company.id }}">
                    <div class="card-body grid grid-cols-4 listitem">
                        <div class="card-title">{{ company.name }}</div>
                        <div class="card-title">{{ company.abn }}</div>
                        <div class="card-title">{{ company.email }}</div>
                        <div class="card-title">{{ company.address }}</div>
                    </div>
                </router-link>
            </template>
        </div>
    </Container>
</template>

<script lang="ts" setup>
import { onBeforeMount } from 'vue';
import { useCompanyStore } from '../../stores/companies';
import { storeToRefs } from 'pinia';

const { list } = storeToRefs(useCompanyStore())
const { getCompanies } = useCompanyStore()

onBeforeMount(async () => {
    await getCompanies()
})

</script>

<style scoped>
.listitem:hover {
    background-color: var(--dark);
}
</style>