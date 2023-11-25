<template>
    <div class="cardRestaurant mb-4">
        <router-link :to="{ name: 'dashRest', params: { idRestaurant: restaurant.id_rest } }">
            <div class="card" @click="store.dispatch('restaurant/' + Constant.GET_ONE_RESTAURANT, restaurant.id_rest)">
                <div class="card-body">
                    <!-- <img :src="restaurant.img_rest" alt="restaurant image
                                " class="img-fluid"> -->
                    <h4 class="card-title">{{ restaurant.name_rest }}</h4>
                    <p class="card-text">{{ restaurant.location_rest }}</p>
                </div>
            </div>
        </router-link>
    </div>
</template>

<script setup>
import { useStore } from 'vuex';
import Constant from '../../../Constant';

const props = defineProps({
    restaurant: {}
});

const store = useStore();

</script>

<style></style>