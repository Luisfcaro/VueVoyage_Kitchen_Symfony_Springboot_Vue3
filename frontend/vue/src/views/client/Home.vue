<template>
  <Header />
  <div class="home">
      <CarouselList :categories="state.categories"/>
      <ListRestaurants_client :restaurants="state.infiniteRestaurants" @limitNew="addRestaurants" />
  </div>
  <Footer />
</template>


<script setup>
import { useRoute, useRouter } from 'vue-router';
import { computed, reactive, ref } from 'vue';
import { useStore } from 'vuex'
import Constant from '../../Constant';
import Footer from '../../components/client/layout/Footer.vue';
import Header from '../../components/client/layout/Header.vue';

import ListRestaurants_client from '../../components/client/list/ListRestaurants_client.vue'
import CarouselList from '../../components/client/list/CarouselList.vue'
import { useInfiniteRestaurants } from '../../composables/restaurants/useRestaurants'
const router = useRouter()
const route = useRoute()
const idRestaurant = ref(null)
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