import { defineStore } from "pinia";

export const useAdminStore = defineStore('admin', {
    state: (): AdminState => ({
        widgets: {
            total_companies: 0,
            total_employees: 0,
            total_users: 0,
        }
    }),
    actions: {
        async getWidgets() {
            const response = await this.http.get('/dashboard')
            console.log(">>>> ", response.data)
            this.widgets = response.data
        }
    }
})

type AdminState = {
    widgets: {
        total_companies: number
        total_employees: number
        total_users: number
    }
}

export type WidgetResource = {
    widgets: {
        total_companies: number
        total_employees: number
        total_users: number
    }
}