import { storeToRefs } from "pinia"
import { useCompanyStore } from "../stores/companies"
import { computed } from "vue"

export function getCompanyComputedVals() {
    const { company } = storeToRefs(useCompanyStore())
    const companyId = computed(() => { return company.value?.id })
    const companyName = computed({
        get() { return company.value?.name },
        set(newVal) { company.value.name = newVal }
    })
    const companyAbn = computed({
        get() { return company.value?.abn },
        set(newVal) { company.value.abn = newVal }
    })
    const companyEmail = computed({
        get() { return company.value?.email },
        set(newVal) { company.value.email = newVal }
    })
    const companyAddress = computed({
        get() { return company.value?.address },
        set(newVal) { company.value.address = newVal }
    })

    return {
        companyId,
        companyName,
        companyAbn,
        companyEmail,
        companyAddress
    }
}