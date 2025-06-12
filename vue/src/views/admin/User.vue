<template>
    <Header :title="'User'" :subtitle="''" />

    <Container class="w-1/2 ms-auto me-auto">
        <div class="card bg-gray-700 card-md shadow-sm mb-2">
            <div class="card-body grid grid-cols-1 text-green-500">
                <div class="">
                    <label class="label">
                        <span class="text-green-500 label-text font-bold">Name</span>
                    </label>
                    <input type="text" class="input w-full rounded-md border border-gray-600" v-model="userName" />
                </div>
                <div class="">
                    <label class="label">
                        <span class="text-green-500 label-text font-bold">Email</span>
                    </label>
                    <input type="text" class="input w-full rounded-md border border-gray-600" v-model="userEmail" />
                </div>
            </div>
            <div class="text-center mb-2">
                <button class="btn btn-success" @click="submit">Update User Details</button>
            </div>
        </div>
    </Container>
</template>

<script lang="ts" setup>
import { storeToRefs } from 'pinia';
import { useRoute, useRouter } from 'vue-router';
import { onBeforeMount } from 'vue';
import { useUserStore } from '../../stores/users';
import { getUserComputedVals } from '../../composables/user-computed';

const route = useRoute()
const router = useRouter()

const { getUser, updateUser } = useUserStore()
const {
    userId,
    userName,
    userEmail
 } = getUserComputedVals()

onBeforeMount(async () => { await getUser(route.params.id) })
const submit = async () => {
    try {
        const payload = {
            id: userId.value,
            name: userName.value,
            email: userEmail.value,
        }
        console.log(">>> Update Payload: ", payload)
    } catch (error) {
        console.log(">>>> Errors: ", error)
    }
}

</script>