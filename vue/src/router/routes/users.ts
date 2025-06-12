import { routes } from "../../utilities/routes";
import User from "../../views/admin/User.vue";
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
        },
        {
            path: '/users/:id',
            name: 'users.single',
            component: User
        },
    ]
)