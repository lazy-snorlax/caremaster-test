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
                <div class="flex gap-5">
                    <div class="w-1/2">
                        <label class="label">
                            <span class="text-green-500 label-text font-bold">Role</span>
                        </label>
                        <select class="select w-full" v-model="selectedRole">
                            <option disabled value="">Please select one</option>
                            <option>User</option>
                            <option>Admin</option>
                        </select>
                    </div>
                    <div class="w-1/2">
                        <label class="label">
                            <span class="text-green-500 label-text font-bold">Status</span>
                        </label>
                        <select class="select w-full" v-model="selectedStatus">
                            <option disabled value="">Please select one</option>
                            <option>ENABLED</option>
                            <option>PENDING</option>
                            <option>DISABLED</option>
                        </select>
                    </div>
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
import { onBeforeMount, ref } from 'vue';
import { useUserStore } from '../../stores/users';
import { getUserComputedVals } from '../../composables/user-computed';

const route = useRoute()
const router = useRouter()

const { getUser, updateUser } = useUserStore()
const {
    userId,
    userName,
    userEmail,
    userRole,
    userStatus,
} = getUserComputedVals()
const selectedRole = ref(userRole)
const selectedStatus = ref(userStatus)

onBeforeMount(async () => { await getUser(route.params.id) })
const submit = async () => {
    try {
        if (!userRole.value) {
            console.log(">>> UserRole: ", userRole.value)
            return
        }
        const payload = {
            id: userId.value,
            name: userName.value,
            email: userEmail.value,
            role: userRole.value,
            status: userStatus.value,
        }
        console.log(">>> Update Payload: ", payload)
        updateUser(payload)
    } catch (error) {
        console.log(">>>> Errors: ", error)
    }
}

</script>