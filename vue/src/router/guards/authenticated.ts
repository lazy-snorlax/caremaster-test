import { useAppStore } from "../../stores/app";
import type { Router } from "vue-router";

export default (router: Router) => 
    router.beforeEach(async (to) => {
        const appStore = useAppStore()
        
        try {
            if (appStore.user === null) {
                if (appStore.authenticationAttempted) {
                    throw new Error('Authentication has already been attempted.')
                }
                await appStore.getUser()
            }
        } catch {
            // If the intended route is restricted we'll redirect back to the login page with the intended path.
            console.log('>>> Route Redirect: ', to.meta, to.meta.restricted, to.meta.authenticate)
            if (to.meta.restricted !== false) {
                return {
                    name: 'login',
                    replace: true,
                    query: {
                        redirect: to.path
                    }
                }
            }
        }
    })