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
                            :class="{ 'active': (currentRouteName === 'dash' || currentRouteName === 'dashRest' || currentRouteName === 'categoriesRestaurnat') }"
                            aria-current="page">
                            <div class="icon me-3">
                                <font-awesome-icon icon="chart-line" />
                            </div>
                            Dashboard
                        </router-link>
                    </li>
                    <li v-if="currentRouteName === 'dashRest' || currentRouteName === 'categoriesRestaurnat'">
                        <router-link class="nav-link text-white d-flex" :class="{ 'ms-3': isSidebarOpen }"
                            :to="{ name: 'categoriesRestaurnat', params: { idRestaurant: route.params.idRestaurant } }">
                            <div class="icon me-3">
                                <font-awesome-icon icon="closed-captioning" />
                            </div>
                            Categories
                        </router-link>
                    </li>
                    <hr>
                    <li>
                        <router-link :to="{ name: 'dashCategories' }" class="nav-link d-flex"
                            :class="{ 'active': currentRouteName === 'dashCategories' }" aria-current="page">
                            <div class="icon me-3">
                                <font-awesome-icon icon="closed-captioning" />
                            </div>
                            Categories
                        </router-link>
                    </li>
                    <li>
                        <router-link :to="{ name: 'dashUsers' }" class="nav-link d-flex"
                            :class="{ 'active': currentRouteName === 'dashUsers' }" aria-current="page">
                            <div class="icon me-3">
                                <font-awesome-icon icon="closed-captioning" />
                            </div>
                            Users
                        </router-link>
                    </li>
                    <li>
                        <router-link :to="{ name: 'dashBookings' }" class="nav-link d-flex"
                            :class="{ 'active': currentRouteName === 'dashBookings' || currentRouteName === 'dashBooking' || currentRouteName === 'TablesOfBooking'}" aria-current="page">
                            <div class="icon me-3">
                                <font-awesome-icon icon="closed-captioning" />
                            </div>
                            Bookings
                        </router-link>
                    </li>

                    <li v-if="currentRouteName === 'dashBooking'">
                        <router-link class="nav-link text-white d-flex" :class="{ 'ms-3': isSidebarOpen }"
                            :to="{ name: 'TablesOfBooking', params: { idBooking: route.params.idBooking } }">
                            <div class="icon me-3">
                                <font-awesome-icon icon="closed-captioning" />
                            </div>
                            Tables
                        </router-link>
                    </li>
                </ul>
                <hr>
                <div class="dropdown p-1">
                    <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="https://github.com/mdo.png" alt="" width="32" height="32" class="rounded-circle me-3">
                        <strong>Admin</strong>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
                        
                        <li><a class="dropdown-item" @click="logout()">Sign out</a></li>
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
import { computed, onMounted, ref, watch } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import { useStore } from 'vuex'
import Constant from '../../../Constant';

const store = useStore();
const router = useRouter();
const route = useRoute();

const isSidebarOpen = computed(() => store.getters['sidebar/isSidebarOpen'])

const toggleSidebar = () => store.dispatch('sidebar/toggleSidebar');

const currentRouteName = ref('');

onMounted(() => {
    currentRouteName.value = router.currentRoute.value.name;
});

const handleRouteChange = () => {
    currentRouteName.value = router.currentRoute.value.name;
};

onMounted(() => {
    handleRouteChange();
    watch(() => router.currentRoute.value.fullPath, handleRouteChange);
});

const logout = () => {
    store.dispatch('user/' + Constant.GET_USER_LOGOUT).then(() => {
        router.push({ name: 'home' })
    })
}

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