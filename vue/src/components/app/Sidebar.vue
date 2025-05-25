<template>
    <div id="sidebar-wrapper">
		<div class="top">
			<div class="logo">
				<h5 class="text-3xl">DASHBOARD</h5>
				<button class="close-sidebar"  @click="sidebarToggle">
					<i class="fa fa-times"></i>
				</button>
			</div>
        </div>

		<div class="middle flex flex-column">
			<ul class="nav">
				<li class="nav-item" v-if="loggedInUser.role.name == 'admin'">
					<a class="nav-link">Companies</a>
				</li>
				<li class="nav-item" v-if="loggedInUser.role.name == 'admin'">
					<a class="nav-link">Users</a>
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
import { computed, reactive, watchEffect } from 'vue'
import logoDefault from '@/assets/logo.svg'
import { useLogout } from '@/composables/use-logout'
import { useIsLoggedIn } from '@/composables/use-is-logged-in'
import { useLoggedInUser } from '@/composables/use-logged-in-user'

import { useAppStore } from '../../stores/app'
import { storeToRefs } from 'pinia'

const logo = computed(() => { return logoDefault })

const { logout } = useLogout()
const { isLoggedIn } = useIsLoggedIn()
const { loggedInUser } = useLoggedInUser()

const appStore = useAppStore()
const { is_expanded } = storeToRefs(appStore)

const { toggleSidebar } = useAppStore()
const sidebarToggle = () => {

    const wrapper = document.getElementById('wrapper')
    toggleSidebar()
    wrapper.classList.add('transitioning')
    
    setTimeout(() => { 
        wrapper.classList.remove('transitioning')
    }, 300)
}
</script>

<style lang="scss" scoped>

</style>