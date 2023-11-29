<template>
    <div class="listRestaurants">
        <div class="card">
            <div class="card-header">
                <h4>List Restaurants</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3" v-for="(restaurant, index) in restaurants" :key="index">
                        <CardRestaurant :restaurant="restaurant"/>
                    </div>
                </div>

            </div>
        </div>
    </div>
</template>

<script setup>
import { useStore } from 'vuex';
import Constant from '../../../Constant';
import { computed } from 'vue';
import CardRestaurant from '../cards/CardRestaurant.vue';

const store = useStore();

store.dispatch('restaurant/' + Constant.GET_ALL_RESTAURANTS)

const restaurants = computed(() => store.getters['restaurant/restaurants'])

</script>

<style></style>