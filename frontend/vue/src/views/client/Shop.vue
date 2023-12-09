<template>
    <Header />
    <div class="shop">
        <Shop_list :restaurants="state.restaurants"/>
    </div>
    {{ state.total_pages }}
    <Footer />
</template>
  
  
<script setup>
    import { useRoute, useRouter } from 'vue-router';
    import { ref, reactive } from 'vue';
    import Footer from '../../components/client/layout/Footer.vue';
    import Header from '../../components/client/layout/Header.vue';
    import Shop_list from '../../components/client/list/Shop_list.vue';

    import { useFiltersRestaurants } from '../../composables/restaurants/useRestaurants'
    import { useRestaurantsPaginate } from '../../composables/restaurants/useRestaurants'
    
    const router = useRouter()
    const route = useRoute()
    const idRestaurant = ref(null)
    
    let filters_Url = {
        categories: [],
        name_rest: '',
        order: 0,
        page: 1,
        limit: 4,
    };

    const state = reactive({
        restaurants: useFiltersRestaurants(filters_Url),
        page: filters_Url.page,
        total_pages: useRestaurantsPaginate(filters_Url),
    });



    
  
  
</script>
  
  
<style scoped lang="scss">

        

</style>