import { useAppStore } from "../../stores/app";
import type { Router } from "vue-router";

export default (router: Router) => 
    router.beforeEach(async (to) => {
        const authStore = useAppStore()
        
        try {
            if (authStore.user === null) {
                if (authStore.authenticationAttempted) {
                    throw new Error('Authentication has already been attempted.')
                }
                await authStore.getUser()
            }
        } catch {
            // If the intended route is restricted we'll redirect back to the login page with the intended path.
            console.log('>>> Route Redirect: ', to.meta, to.meta.restricted, to.meta.authenticate)
            if (to.meta.restricted !== false) {
                return {
                    name: 'dashboard',
                    replace: true,
                    query: {
                        redirect: to.path
                    }
                }
            }
        }

        // Public facing routes
        if (to.meta.authenticate === false || to.meta.restricted === false) {
            return true
        }
    })