import { useAppStore } from '../stores/app'
import { useRouter } from 'vue-router'

export function useLogout() {
  const router = useRouter()
  const auth = useAppStore()

  const logout = async () => {
    await auth.logout()
    router.replace({ name: 'login' })
  }

  return {
    logout,
  }
}
