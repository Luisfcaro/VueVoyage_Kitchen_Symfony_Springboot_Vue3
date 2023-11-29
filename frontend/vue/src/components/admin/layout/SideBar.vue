<template>
    <div class="sidebar position-fixed" :class="{ 'active': isSidebarOpen }">
        <div class="d-flex flex-column flex-shrink-0 p-3 text-bg-dark h-100 overflow-hidden">
            <div class="cont">
                <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none px-3">
                    <font-awesome-icon icon="home" class="me-3" />
                    <span class="fs-4">Sidebar</span>
                </a>
                <hr>
                <ul class="nav nav-pills flex-column mb-auto">
                    <li class="nav-item">
                        <router-link :to="{ name: 'dash' }" class="nav-link d-flex"
                            :class="{ 'active': currentRouteName === 'dash' }" aria-current="page">
                            <div class="icon me-3">
                                <font-awesome-icon icon="chart-line" />
                            </div>
                            Dashboard
                        </router-link>
                    </li>
                    <li>
                        <router-link :to="{ name: 'dashCategories' }" class="nav-link d-flex"
                            :class="{ 'active': currentRouteName === 'dashCategories' }" aria-current="page">
                            <div class="icon me-3">
                                <font-awesome-icon icon="closed-captioning" />
                            </div>
                            Categories
                        </router-link>
                    </li>
                    <!-- <li>
                        <a class="nav-link text-white" data-bs-toggle="collapse" data-bs-target="#contentId"
                            aria-expanded="false" aria-controls="contentId">
                            <svg class="bi pe-none me-2" width="16" height="16">
                                <use xlink:href="#people-circle"></use>
                            </svg>
                            Show
                            <div class="collapse" id="contentId">
                                sdfsdfd
                            </div>
                        </a>
                    </li> -->
                </ul>
                <hr>
                <div class="dropdown p-1">
                    <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="https://github.com/mdo.png" alt="" width="32" height="32" class="rounded-circle me-3">
                        <strong>mdo</strong>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
                        <li><a class="dropdown-item" href="#">New project...</a></li>
                        <li><a class="dropdown-item" href="#">Settings</a></li>
                        <li><a class="dropdown-item" href="#">Profile</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="#">Sign out</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <button type="button" class="btn btn-primary sidebar-close-open" @click="toggleSidebar()"><font-awesome-icon
                icon="circle-xmark" v-if="isSidebarOpen" /><font-awesome-icon icon="arrow-right"
                v-if="!isSidebarOpen" /></button>
    </div>
</template>

<script setup>
import { computed, onMounted, ref } from 'vue';
import { useRoute } from 'vue-router';
import { useStore } from 'vuex'

const store = useStore();

const isSidebarOpen = computed(() => store.getters['sidebar/isSidebarOpen'])
const toggleSidebar = () => store.dispatch('sidebar/toggleSidebar');

const currentRouteName = ref('');

onMounted(() => {
    currentRouteName.value = useRoute().name;
});

</script>

<style scoped lang="scss">
.sidebar {
    width: 62px;
    height: 100%;
    transition: 1s;
    top: 0;

    .cont {
        width: 240px;
    }

    &.active {
        width: 280px;

        .sidebar-close-open {
            position: absolute;
            right: 10px;
            top: 10px;
        }
    }

    .sidebar-close-open {
        position: absolute;
        right: -50px;
        top: 10px;
    }
}
</style>