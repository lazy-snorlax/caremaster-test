import { routes } from "../../utilities/routes";
import UserList from "../../views/admin/UserList.vue";

export default routes(
    {
        template: 'app',
        restricted: true,
        admin: true
    },
    [
        {
            path: '/users',
            name: 'users',
            component: UserList
        }
    ]
)