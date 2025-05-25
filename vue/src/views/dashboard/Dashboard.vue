<template>
    <Header :title="'Dashboard'" :subtitle="''" />

    <Container class="dashboard">
        <template v-if="loggedInUser.role.name == 'admin'">
            Admin User
        </template>
        <template v-else>
            User
        </template>
    </Container>
</template>

<script lang="ts" setup>
import { useLoggedInUser } from '@/composables/use-logged-in-user'

const { loggedInUser } = useLoggedInUser()

</script>
