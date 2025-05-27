import { storeToRefs } from "pinia"
import { computed } from "vue"
import { useEmployeeStore } from "../stores/employees"

export function getEmployeeComputedVals() {
    const { employee } = storeToRefs(useEmployeeStore())
    const employeeId = computed(() => { return employee.value?.id })
    const employeeFirstName = computed({
        get() { return employee.value?.first_name },
        set(newVal) { employee.value.first_name = newVal }
    })
    const employeeLastName = computed({
        get() { return employee.value?.last_name },
        set(newVal) { employee.value.last_name = newVal }
    })
    const employeeEmail = computed({
        get() { return employee.value?.email },
        set(newVal) { employee.value.email = newVal }
    })
    const employeeAddress = computed({
        get() { return employee.value?.address },
        set(newVal) { employee.value.address = newVal }
    })

    return {
        employeeId,
        employeeFirstName,
        employeeLastName,
        employeeEmail,
        employeeAddress
    }
}