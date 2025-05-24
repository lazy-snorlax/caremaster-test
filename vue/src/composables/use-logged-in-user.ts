import { useAppStore, type LoggedInUserResource } from '../stores/app'
import { storeToRefs } from 'pinia'
import type { Ref } from 'vue'

export function useLoggedInUser() {
  const authStore = useAppStore()
  const { user } = storeToRefs(authStore)

  // Loudly fail if there is no logged in user so we can safely return the logged in user type without any possibility for a null value. 
  // To check if a user is logged in use the "isLoggedIn" composable.
  if (user.value === null) {
    // throw new Error('No logged in user.')
    return {
      loggedInUser: null
    }
  }

  return {
    loggedInUser: user as Ref<LoggedInUserResource>,
    getLoggedInUser: authStore.getUser,
  }
}
