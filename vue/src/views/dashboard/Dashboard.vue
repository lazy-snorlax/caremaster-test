<template>
    <Header :title="'Dashboard'" :subtitle="''" />

    <Container class="dashboard">
        <template v-if="loggedInUser.role.name == 'admin'">
            <AdminDashboard class="container" />
        </template>
        <template v-else>
            <UserDashboard class="container" />
        </template>
    </Container>
</template>

<script lang="ts" setup>
import { useLoggedInUser } from '@/composables/use-logged-in-user'
import AdminDashboard from './AdminDashboard.vue';
import UserDashboard from './UserDashboard.vue';


const { loggedInUser } = useLoggedInUser()

</script>
