import { routes } from "../../utilities/routes"

import Dashboard from "../../views/dashboard/Dashboard.vue"

export default routes(
    {
        template: 'app',
        restricted: true,
        guest: false,
    },
    [
        {
            path: '/dashboard',
            name: 'dashboard',
            component: Dashboard,
            meta: {
                authenticate: false
            }
        }
    ]
)