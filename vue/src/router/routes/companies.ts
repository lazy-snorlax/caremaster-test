import { routes } from "../../utilities/routes";
import CompanyList from "../../views/admin/CompanyList.vue";
import Company from "../../views/admin/Company.vue";
import CompanyAdd from "../../views/admin/CompanyAdd.vue";
import Employee from "../../views/admin/Employee.vue";
import EmployeeAdd from "../../views/admin/EmployeeAdd.vue";

export default routes(
    {
        template: 'app',
        restricted: true,
        admin: true,
    },
    [
        {
            path: '/companies',
            name: 'companies',
            component: CompanyList,
        },
        {
            path: '/companies/add',
            name: 'companies.add',
            component: CompanyAdd,
        },
        {
            path: '/companies/:id',
            name: 'companies.single',
            component: Company,
        },
        {
            path: '/companies/:company/employee/:employee',
            name: 'employee.single',
            component: Employee,
        },
        {
            path: '/companies/:company/employee/add',
            name: 'employee.add',
            component: EmployeeAdd,
        },
    ]
)