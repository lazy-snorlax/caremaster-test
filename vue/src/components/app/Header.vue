<template>
    <header class="page-header" v-if="title != null && title != ''">
        <div class="left">
            <button id="menu-toggle" class="btn" @click="sidebarToggle">X</button>
        </div>
        <div class="middle">
            <div class="page-title mx-3 my-3 text-center">
                <h1>{{ title }}</h1>
                <p v-if="subtitle" class="subheading">{{ subtitle }}</p>
            </div>
        </div>
        <div class="right">
            {{ loggedInUser.name }}
        </div>
    </header>
</template>

<script lang="ts" setup>
import { useAppStore } from '@/stores/app'
import { useIsLoggedIn } from '@/composables/use-is-logged-in'
import { useLoggedInUser } from '@/composables/use-logged-in-user'
import { toast } from 'vue3-toastify';

const props = defineProps<{
    headerKey?: Number | null,
    title?: string|null,
    subtitle?: string|null,
}>()

const { isLoggedIn } = useIsLoggedIn()
const { loggedInUser } = useLoggedInUser()
const { toggleSidebar, resendVerifyEmail } = useAppStore()

const sidebarToggle = () => {
    const wrapper = document.getElementById('wrapper')
    toggleSidebar()
    wrapper.classList.add('transitioning')
    
    setTimeout(() => { 
        wrapper.classList.remove('transitioning')
    }, 300)
}

const resend = async() => {
    try {
        resendVerifyEmail()
        toast("Verification email has been re-sent", {
            autoClose: 1500,
            position: toast.POSITION.TOP_CENTER,
            theme: 'colored',
            type: 'info'
        })
    } catch (error) {
        toast("Verification email could not re-sent", {
            autoClose: 1500,
            position: toast.POSITION.TOP_CENTER,
            theme: 'colored',
            type: 'error'
        })
        console.error(error)
    }
}
</script>

<style lang="scss">
header.page-header {
    padding: 2rem;
    background: var(--dark-alt);
    display: flex;
    flex-wrap: wrap;
    flex: 0 0 auto;

    .left {
        order: 1;
    }
    .middle {
        padding-top: 0;
        order: 2;
        flex: 1 1 auto;
        max-width: 100%;

        .page-title {
            max-width: 100%;
            flex: 1 1 100%;
            h1 {
                font-size: 1.25rem;
                font-weight: 700;
                margin-bottom: 0;
                width: 100%;
                overflow: hidden;
                text-overflow: ellipsis;
                white-space: nowrap;
            }
        }
    }
    .right {
        order: 3;
        flex: 0 0 auto;
        width: auto;
        max-width: 100%;
    }

    #menu-toggle {
        padding: 0 .5rem;
        font-size: 1.5rem;
        color: #767676;
        margin-left: -.5rem;
        margin-right: 1rem;
        box-shadow: none;
    }
}
</style>