<template>
    <div class="dashboard">
        <SideBar />
        <div class="container dashboard" :class="{ 'active-sidebar': isSidebarOpen }">
            <div class="row">
                <div class="mt-3">
                    <div class="card w-100">
                        <div class="card-header">
                            <h4>DashBoard</h4>
                        </div>
                        <div class="card-body">
                            <CreateRestaurant :data="restaurant" :edit="idRestaurant ? true : false" />
                            <hr v-if="idRestaurant">
                            <CreateTable :idRestaurant="idRestaurant" v-if="idRestaurant"/>
                            <hr v-if="idRestaurant">
                            <ListTables :tables="restaurant.tables" v-if="idRestaurant" :idRestaurant="idRestaurant"
                                @deleteTable="deleteTable($event)" @updateTable="updateTable($event)" />
                            <hr v-if="!idRestaurant">
                            <ListRestaurants v-if="!idRestaurant" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { useRoute, useRouter } from 'vue-router';
import CreateRestaurant from '../../components/admin/forms/CreateRestaurant.vue'
import CreateTable from '../../components/admin/forms/CreateTable.vue'
import ListTables from '../../components/admin/lists/ListTables.vue'
import ListRestaurants from '../../components/admin/lists/ListRestaurants.vue'
import SideBar from '../../components/admin/layout/SideBar.vue';
import { computed, onMounted, ref, watch } from 'vue';
import { useStore } from 'vuex'
import Constant from '../../Constant';
const route = useRoute()
const idRestaurant = ref(null)
const store = useStore();

const changeRestaurant = () => {
    if (route.params.idRestaurant) {
        idRestaurant.value = route.params.idRestaurant
        store.dispatch('restaurant/' + Constant.GET_ONE_RESTAURANT, idRestaurant.value)
    } else {
        idRestaurant.value = null
        store.dispatch('restaurant/' + Constant.INI_RESTAURANT)
    }
}
changeRestaurant()

const router = useRouter();

const currentRoute = ref('');

const handleRouteChange = () => {
    currentRoute.value = router.currentRoute.value.fullPath;
    // idRestaurant.value = route.params.idRestaurant
    // store.dispatch('restaurant/' + Constant.GET_ONE_RESTAURANT, idRestaurant.value)
    changeRestaurant()
};

onMounted(() => {
    handleRouteChange();
    watch(() => router.currentRoute.value.fullPath, handleRouteChange);
});

const restaurant = computed(() => store.getters['restaurant/restaurant'])
const isSidebarOpen = computed(() => store.getters['sidebar/isSidebarOpen'])

const deleteTable = (idTable) => {
    store.dispatch('restaurant/' + Constant.DELETE_TABLE, idTable)
};

const updateTable = (table) => {
    store.dispatch('restaurant/' + Constant.UPDATE_TABLE, table)
};

</script>

<style scoped lang="scss">
.dashboard {
    min-height: 100vh;
    max-width: inherit !important;

    .container.dashboard {
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