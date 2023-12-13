<template>
    <div>
        <Header />
        <Search />
        <div class="shop">
            <Shop_list :restaurants="state.restaurants">
                <Pagination :pages="state.total_pages"/>
            </Shop_list>
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
import Pagination from '../../components/client/list/Pagination.vue';
import Search from '../../components/client/list/Search.vue'

import { useFiltersRestaurants } from '../../composables/restaurants/useRestaurants'
import { useRestaurantsPaginate } from '../../composables/restaurants/useRestaurants'

const router = useRouter()
const route = useRoute()
const idRestaurant = ref(null)

const filters_Url = reactive({
    categories: [],
    name_rest: '',
    order: 0,
    page: 1,
    limit: 4,
})
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
    }
    state.restaurants = useFiltersRestaurants(filters_Url)
    state.total_pages = useRestaurantsPaginate(filters_Url)
};

setPageAndFiltersFromRoute();

watch(() => route.params.filters, setPageAndFiltersFromRoute);

</script>
  
  
<style scoped lang="scss"></style>