import { defineStore } from "pinia";

export const useUserStore = defineStore('user', {
    state: (): UserState => ({
        list: [],
        user: null
    }),
    actions: {
        async getUsers() {
            const response = await this.http.get('/users')
            this.list = response.data.data
        }
    }
})

type UserState = {
    list: Array<UserResource>,
    user: UserResource | null
}

export type UserResource = {
    id: number,
    name: string,
    email: string,
    role: string,
    status: string,
}