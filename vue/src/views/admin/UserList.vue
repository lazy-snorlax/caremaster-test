<template>
    <Header :title="'Users'" :subtitle="''" />

    <Container class="ms-auto me-auto">
        <div class="text-center mb-3">
            <router-link :to="{ name: 'users.add' }">
                <button class="btn btn-success">+ User</button>
            </router-link>
        </div>
        <div class="card bg-gray-700 card-md shadow-sm mb-2">
            <div class="card-body grid grid-cols-4 text-green-500 border-b-2">
                <div class="card-title">NAME</div>
                <div class="card-title">EMAIL</div>
                <div class="card-title">ROLE</div>
                <div class="card-title">STATUS</div>
            </div>
            <template v-for="user in list">
                <router-link :to="{ name: 'users.single', params: { id: user.id }}">
                    <div class="card-body grid grid-cols-4 listitem">
                        <div class="card-title">{{ user.name }}</div>
                        <div class="card-title">{{ user.email }}</div>
                        <div class="card-title">{{ user.role }}</div>
                        <div class="card-title">{{ user.status.toUpperCase() }}</div>
                    </div>
                </router-link>
            </template>
        </div>
    </Container>
</template>

<script lang="ts" setup>

import { storeToRefs } from 'pinia';
import { useUserStore } from '../../stores/users';
import { onBeforeMount } from 'vue';

const { list } = storeToRefs(useUserStore())
const { getUsers } = useUserStore()

onBeforeMount(async () => {
    await getUsers()
})

</script>