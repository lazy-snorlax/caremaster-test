import { defineStore } from "pinia";

export const useCompanyStore = defineStore('company', {
    state: (): CompanyState => ({
        list: [],
        company: null
    }),
    actions: {
        async getCompanies() {
            const response = await this.http.get('/companies')
            this.list = response.data.data
        },
        async getCompany(id: number) {
            const response = await this.http.get(`/companies/${id}`)
            console.log(">>>> ", response.data.data)
            this.company = response.data.data
        },
        async saveCompany(payload) {
            const response = await this.http.post(`/companies/add`, payload)
            console.log(">>>> ", response.data.data)
            this.company = response.data.data
        },
        async updateCompany(payload) {
            const response = await this.http.put(`/companies/${payload.id}`, payload)
            console.log(">>>> ", response.data.data)
            this.company = response.data.data
        },
    }
})

type CompanyState = {
    list: Array<CompanyListResource>,
    company: CompanyResource | null
}
export type CompanyListResource = {
    id: number,
    name: string,
    email: string,
    abn: string,
    address: string,
}
export type CompanyResource = {
    id: number,
    name: string,
    email: string,
    abn: string,
    address: string,
    employees: Array<{}>
}

export type CompanyForm = {
    name: string
    abn: string
    email: string
    address: string
}