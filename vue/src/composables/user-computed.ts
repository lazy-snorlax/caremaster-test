import { storeToRefs } from "pinia";
import { useUserStore } from "../stores/users";
import { computed } from "vue";

export function getUserComputedVals() {
    const { user } = storeToRefs(useUserStore())
    const userId = computed(() => { return user.value?.id })
    const userName = computed({
        get() { return user.value?.name },
        set(newVal: string) { user.value.name = newVal }
    })
    const userEmail = computed({
        get() { return user.value?.email },
        set(newVal: string) { user.value.email = newVal }
    })
    const userRole = computed({
        get() { return user.value?.role },
        set(newVal: string) { user.value.role = newVal }
    })
    const userStatus = computed({
        get() { return user.value?.status },
        set(newVal: string) { user.value.status = newVal }
    })

    return {
        userId,
        userName,
        userEmail,
        userRole,
        userStatus,
    }
}