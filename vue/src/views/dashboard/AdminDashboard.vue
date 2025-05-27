<template>
    <div class="grid grid-cols-3 gap-10 w-full text-green-500">
        <div class="card w-full bg-gray-700 card-md shadow-sm">
            <div class="card-body">
                <h2 class="card-title">Total Companies</h2>
                <p class="text-2xl">{{ widgets.total_companies }}</p>
            </div>
        </div>
        <div class="card w-full bg-gray-700 card-md shadow-sm">
            <div class="card-body">
                <h2 class="card-title">Total Employees</h2>
                <p class="text-2xl">{{ widgets.total_employees }}</p>
            </div>
        </div>
        <div class="card w-full bg-gray-700 card-md shadow-sm">
            <div class="card-body">
                <h2 class="card-title">Total Users</h2>
                <p class="text-2xl">{{ widgets.total_users }}</p>
            </div>
        </div>
    </div>
</template>
  
<script lang="ts" setup>
import { onBeforeMount, onMounted } from 'vue';
import { getAdminWidgets } from '../../composables/get-admin-widgets';

const { widgets, getWidgets} = getAdminWidgets()

onBeforeMount(async () => {
    await getWidgets()
})

</script>
  