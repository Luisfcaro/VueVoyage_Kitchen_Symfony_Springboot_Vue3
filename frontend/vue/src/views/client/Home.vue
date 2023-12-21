<template>
  <div class="home">
      <CarouselList :categories="state.categories"/>
      <ListRestaurants_client :restaurants="state.infiniteRestaurants" @limitNew="addRestaurants" />
  </div>
</template>


<script setup>
import { computed, reactive } from 'vue';
import { useStore } from 'vuex'
import Constant from '../../Constant';

import ListRestaurants_client from '../../components/client/list/ListRestaurants_client.vue'
import CarouselList from '../../components/client/list/CarouselList.vue'
import { useInfiniteRestaurants } from '../../composables/restaurants/useRestaurants'
const store = useStore();

store.dispatch('restaurant_client/' + Constant.GET_ALL_CATEGORIES_CLIENT)


const state = reactive({
      infiniteRestaurants: useInfiniteRestaurants(0, 3),
      categories: computed(() => store.getters['restaurant_client/categories']),
})


const addRestaurants = (limitNew) => {
      state.infiniteRestaurants = useInfiniteRestaurants(limitNew, 3)
}


</script>


<style scoped lang="scss">
</style>