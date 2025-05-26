import { useAdminStore, WidgetResource } from "../stores/admin";
import { storeToRefs } from "pinia";
import type { Ref } from "vue";

export function getAdminWidgets() {
    const adminStore = useAdminStore()
    const { widgets } = storeToRefs(adminStore)

    return {
        widgets: widgets,
        getWidgets: adminStore.getWidgets,
    }
}