<template>
	<component :is="templateComponent" />
</template>

<script lang="ts" setup>
import { computed } from 'vue'
import { useRoute } from 'vue-router'
import { templates } from './templates'

window.document.title = import.meta.env.VITE_APP_TITLE

const route = useRoute()

const templateComponent = computed(() => {
	if (route.meta.template && route.meta.template in templates) {
		return templates[route.meta.template]
	}
	return templates.empty
})

</script>