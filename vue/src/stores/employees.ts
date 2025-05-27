import { defineStore } from "pinia";

export const useEmployeeStore = defineStore('employee', {
    state: (): EmployeeState => ({
        employee: null
    }),
    actions: {
        async getEmployee(id: number) {
            const response = await this.http.get(`/employees/${id}`)
            this.employee = response.data.data
        },

        async saveEmployee(payload) {
            const response = await this.http.post(`/employees/add`, payload)
            this.employee = response.data.data
        },

        async updateEmployee(payload) {
            const response = await this.http.put(`/employees/${payload.id}`, payload)
            this.employee = response.data.data
        },

        async deleteEmployee(id: number) {
            const response = await this.http.delete(`/employees/${id}`)
            this.employee = response.data.data
        },
    }
})

type EmployeeState = {
    employee: EmployeeResource | null
}

export type EmployeeResource = {
    id: number,
    first_name: string,
    last_name: string,
    email: string,
    address: string,
}

export type EmployeeForm = {
    first_name: string,
    last_name: string,
    email: string,
    address: string,
}