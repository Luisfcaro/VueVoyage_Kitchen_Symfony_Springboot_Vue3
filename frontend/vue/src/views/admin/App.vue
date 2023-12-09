<script setup>
import { useStore } from 'vuex';
import SideBar from '../../components/admin/layout/SideBar.vue';
import { computed } from 'vue';

const store = useStore();
const isSidebarOpen = computed(() => store.getters['sidebar/isSidebarOpen'])

</script>

<template>
    <div class="app">
        <SideBar />
        <div class="container app" :class="{ 'active-sidebar': isSidebarOpen }">
            <router-view></router-view>
        </div>
    </div>
</template>

<style scoped lang="scss">
.app {
    min-height: 100vh;
}

.app {
    min-height: 100vh;
    max-width: inherit !important;

    .container.app {
        margin-left: 62px;
        transition: 1s;
        width: inherit;
        margin-top: 45px;

        &.active-sidebar {
            margin-left: 280px;
            margin-top: 0;
        }

        .card {
            h4 {
                margin: 4px;
            }
        }
    }
}
</style>
