<template>
  <div id="wrapper" :class="`${is_expanded ? 'toggled' : ''}`">
    <Sidebar />

    <div id="page-content-wrapper" class="dark">
      <RouterView v-slot="{ Component }">
        <template v-if="Component">
          <Suspense :timeout="0">
            <component :is="Component" />
          </Suspense>
        </template>
      </RouterView>
    </div>
  </div>

  <ModalsContainer />
</template>

<script lang="ts" setup>
import { ModalsContainer, useModal } from 'vue-final-modal'
import Sidebar from '../components/app/Sidebar.vue'
import { useAppStore } from '../stores/app'
import { storeToRefs } from 'pinia'

const authStore = useAppStore()
const { is_expanded } = storeToRefs(authStore)

</script>