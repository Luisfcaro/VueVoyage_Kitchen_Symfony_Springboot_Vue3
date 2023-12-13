<template>
    <div>
        <Header />
        <Filters @filters_apply="ApplyFilters" @deleteFilters="deleteAllFilters" :filters="filters_Url" />
        <div class="shop">
            <Shop_list :restaurants="state.restaurants" />
        </div>
        <Footer />
    </div>
</template>
  
  
<script setup>
import { useRoute, useRouter } from 'vue-router';
import { ref, reactive, watch } from 'vue';


import Footer from '../../components/client/layout/Footer.vue';
import Header from '../../components/client/layout/Header.vue';
import Shop_list from '../../components/client/list/Shop_list.vue';
import Filters from '../../components/client/list/filters.vue';

import { useFiltersRestaurants } from '../../composables/restaurants/useRestaurants'
import { useRestaurantsPaginate } from '../../composables/restaurants/useRestaurants'

const router = useRouter()
const route = useRoute()


let filters_Url = reactive({
    categories: [],
    name_rest: '',
    order: 0,
    page: 1,
    limit: 4,
});


try {
    if (route.params.filters !== '') {
        let newFilters = JSON.parse(atob(route.params.filters));
        filters_Url.categories = newFilters.categories;
        filters_Url.name_rest = newFilters.name_rest;
        filters_Url.order = newFilters.order;
        filters_Url.page = newFilters.page;
        filters_Url.limit = newFilters.limit;
    }
} catch (error) {
}


const state = reactive({
    restaurants: useFiltersRestaurants(filters_Url),
    page: filters_Url.page,
    total_pages: useRestaurantsPaginate(filters_Url),
});


const ApplyFilters = (filters) => {
    const filters_64 = btoa(JSON.stringify(filters));
    router.push({ name: "shop_filter", params: { filters: filters_64 } });
    state.restaurants = useFiltersRestaurants(filters);
    state.total_pages = useRestaurantsPaginate(filters);
    filters_Url = filters;
}


const deleteAllFilters = (deleteFilters) => {
    router.push({ name: "shop" });
    filters_Url = deleteFilters;
    state.restaurants = useFiltersRestaurants(deleteFilters);
    state.total_pages = useRestaurantsPaginate(deleteFilters);
}

</script>
  
  
<style scoped lang="scss"></style>