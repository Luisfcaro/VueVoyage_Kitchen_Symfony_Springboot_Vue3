<template>
    <div>
        <Search />
        <div class="shop">
            <Shop_list :restaurants="state.restaurants">
                <Pagination :pages="state.total_pages" />
            </Shop_list>
        </div>
    </div>
</template>
  
  
<script setup>
import { useRoute, useRouter } from 'vue-router';
import { ref, reactive, watch } from 'vue';
import Shop_list from '../../components/client/list/Shop_list.vue';
import Pagination from '../../components/client/list/Pagination.vue';
import Search from '../../components/client/list/Search.vue'
import Filters from '../../components/client/list/filters.vue';

import { useFiltersRestaurants } from '../../composables/restaurants/useRestaurants'
import { useRestaurantsPaginate } from '../../composables/restaurants/useRestaurants'

const route = useRoute()

let filters_Url = reactive({
    categories: [],
    name_rest: '',
    order: 0,
    page: 1,
    limit: 4,
});

const state = reactive({
    restaurants: useFiltersRestaurants(filters_Url),
    page: filters_Url.page,
    total_pages: useRestaurantsPaginate(filters_Url),
});

const setPageAndFiltersFromRoute = () => {
    const encodedFilters = route.params.filters;
    if (encodedFilters) {
        let filt_dec = JSON.parse(atob(encodedFilters))
        filters_Url.categories = filt_dec.categories
        filters_Url.name_rest = filt_dec.name_rest
        filters_Url.order = filt_dec.order
        filters_Url.page = filt_dec.page
        filters_Url.limit = filt_dec.limit
    }else{
        filters_Url.categories = []
        filters_Url.name_rest = ''
        filters_Url.order = 0
        filters_Url.page = 1
        filters_Url.limit = 4
    }
    // console.log(filters_Url);
    state.restaurants = useFiltersRestaurants(filters_Url)
    state.total_pages = useRestaurantsPaginate(filters_Url)
};

setPageAndFiltersFromRoute();

watch(() => route.params.filters, setPageAndFiltersFromRoute);

const ApplyFilters = (filters) => {
    const filters_64 = btoa(JSON.stringify(filters));
    router.push({ name: "shop_filter", params: { filters: filters_64 } });
    // state.restaurants = useFiltersRestaurants(filters);
    // state.total_pages = useRestaurantsPaginate(filters);
    // filters_Url = filters;
}


const deleteAllFilters = () => {
    router.push({ name: "shop" });
    // filters_Url = deleteFilters;
    // state.restaurants = useFiltersRestaurants(deleteFilters);
    // state.total_pages = useRestaurantsPaginate(deleteFilters);
}

</script>
  
  
<style scoped lang="scss"></style>