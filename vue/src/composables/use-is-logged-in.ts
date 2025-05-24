import { useAppStore } from '../stores/app'
import { storeToRefs } from 'pinia'
import { computed } from 'vue'

export function useIsLoggedIn() {
  const authStore = useAppStore()
  const { user } = storeToRefs(authStore)

  return {
    isLoggedIn: computed(() => user.value !== null),
    getLoggedInUser: authStore.getUser,
  }
}
