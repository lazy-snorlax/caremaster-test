import axios, { AxiosInstance, InternalAxiosRequestConfig, isAxiosError } from "axios";
import { Router } from "vue-router";
import { App } from "vue";
import { useIsLoggedIn } from '../composables/use-is-logged-in'
import { useLoggedInUser } from "../composables/use-logged-in-user";

export const http: AxiosInstance = axios.create({
    baseURL: import.meta.env.VITE_API_URL,
    withCredentials: true,
    headers: {
        'Content-Type': 'application/json',
        Accept: 'application/json',
    },
})

export default {
    install: (app: App, { router }: {router: Router}) => {
        //  TODO: For POST, PUT, & DELETE requests make a CSRF preflight if we have not already made on for this page load.
        // http.interceptors.request.use(async (config: InternalAxiosRequestConfig) => {})

        http.interceptors.request.use(async (config: InternalAxiosRequestConfig) => {
            if (config.method && config.data === undefined 
                && ['post', 'put'].includes(config.method.toLowerCase()))
            {
              config.data = {}
            }
      
            return config
        })

        http.interceptors.response.use(null, async (error) => {

            const { isLoggedIn } = useIsLoggedIn()
            const { loggedInUser } = useLoggedInUser()

            if (isAxiosError(error) && error.response) {
                const route = router.currentRoute.value
                
                // console.log('>>>> http.ts error: ', route)

                // TODO: Parsing files
                // if (error.response.request.responseType === 'blob')
                
                // 401: Unauthenticated
                if (error.response.status === 401) {
                    if (route.name === 'login' || route.path === "/") {
                        return Promise.reject(error)
                    }

                    const redirect = 
                        route.name !== 'login' &&
                        route.name !== 'logout' &&
                        route.name !== null &&
                        route.meta.restricted === true ? route.path : null

                    router.replace({ name: 'login', query: { redirect } })
                }

                // 403: Forbidden
                if (error.response.status === 403) {
                    // alert({
                    //     icon: 'warning',
                    //     title: 'Unauthorized',
                    //     message: 'You are not authorized to access the page you have requested.',
                    //     confirm: 'Return to dashboard',
                    //     confirmationOnly: true,
                    // })
                    alert( error.response.data.message )

                    const redirect = 
                        route.name !== 'login' &&
                        route.name !== 'logout' &&
                        route.name !== null &&
                        route.meta.restricted === true ? route.path : null
                    
                    if (isLoggedIn) {
                        router.replace({ name: 'dashboard', query: { redirect } })
                    } else {
                        router.replace({ name: 'login', query: { redirect } })
                    }
                }
        
                // 500: Internal Server Error
                if (error.response.status === 500) {
                    // alert({
                    // icon: 'warning',
                    // message: 'We encountered a server error. We have been alerted and will investigate.',
                    // confirmationOnly: true,
                    // })
                    alert( 'We encountered a server error. We have been alerted and will investigate.' )
                }
            }

            return Promise.reject(error)
        })
    }
}