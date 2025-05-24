import { createPinia } from "pinia";
import { http } from "../utilities/http";

export const pinia = createPinia()

//  Set HTTP client as a custom property for all stores
pinia.use(() => ({ http }))