<template>
    <div id="sidebar-wrapper">
		<div class="top">
			<div class="logo">
				<router-link :to="{ name: 'dashboard' }">
					<h5 class="text-3xl">DASHBOARD</h5>
				</router-link>
			</div>
        </div>

		<div class="middle flex flex-column">
			<ul class="nav" v-if="loggedInUser.role.name == 'admin'">
				<li class="nav-item">
					<router-link :to="{ name: 'companies' }" class="nav-link">Companies</router-link>
				</li>
			</ul>
		</div>
		
		<div class="bottom">
			<ul class="nav">
				<li class="nav-item">
					<a class="nav-link" @click="logout">Logout</a>
				</li>
			</ul>
		</div>
    </div>
</template>

<script lang="ts" setup>
import { computed } from 'vue'
import logoDefault from '@/assets/logo.svg'
import { useLogout } from '@/composables/use-logout'
import { useLoggedInUser } from '@/composables/use-logged-in-user'

const logo = computed(() => { return logoDefault })

const { logout } = useLogout()
const { loggedInUser } = useLoggedInUser()

</script>

<style lang="scss" scoped>

</style>