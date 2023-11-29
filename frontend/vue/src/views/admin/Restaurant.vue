<template>
    <div class="restaurant">
        <div class="row">
            <div class="mt-3">
                <div class="card w-100">
                    <div class="card-header">
                        <h4>DashBoard</h4>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div class="inf">
                                <h5>Información del Restaurante:</h5>
                                <p>{{ restaurant.name_rest }}</p>
                                <p>{{ restaurant.location_rest }}</p>
                                <img :src="restaurant.img_rest" alt="">
                            </div>
                            <ModalUpdateRestaurant :dataRest="restaurant" @updateRestaurant="updateRestaurant($event)" />
                        </div>

                        <hr v-if="idRestaurant">
                        <CreateTable :idRestaurant="idRestaurant" v-if="idRestaurant" />
                        <hr v-if="idRestaurant">
                        <ListTables :tables="restaurant.tables" v-if="idRestaurant" :idRestaurant="idRestaurant"
                            @deleteTable="deleteTable($event)" @updateTable="updateTable($event)" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { useRoute } from 'vue-router';
import ModalUpdateRestaurant from '../../components/admin/modals/ModalUpdateRestaurant.vue';
import CreateTable from '../../components/admin/forms/CreateTable.vue'
import ListTables from '../../components/admin/lists/ListTables.vue'
import { computed, reactive, ref } from 'vue';
import { useStore } from 'vuex'
import Constant from '../../Constant';
const route = useRoute()
const idRestaurant = ref(null)
const store = useStore();

const changeRestaurant = () => {
    idRestaurant.value = route.params.idRestaurant
    store.dispatch('restaurant/' + Constant.GET_ONE_RESTAURANT, idRestaurant.value)
}
changeRestaurant()

const restaurant = reactive(computed(() => store.getters['restaurant/restaurant']))

const deleteTable = (idTable) => {
    store.dispatch('restaurant/' + Constant.DELETE_TABLE, idTable)
};

const updateTable = (table) => {
    store.dispatch('restaurant/' + Constant.UPDATE_TABLE, table)
};

const updateRestaurant = (restaurant) => {
    store.dispatch('restaurant/' + Constant.UPDATE_RESTAUNT, restaurant)
};

</script>

<style scoped lang="scss">
.restaurant {
    min-height: 100vh;
    max-width: inherit !important;

    .card {
        h4 {
            margin: 4px;
        }

        .card-body {
            .inf {
                img {
                    max-width: 100%;
                }
            }
        }
    }

}
</style>