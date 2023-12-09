<template>
    <Header />
    <div class="shop">
        <Shop_list :restaurants="restaurants"/>
    </div>
    <Footer />
</template>
  
  
<script setup>
    import { useRoute, useRouter } from 'vue-router';
    import { computed, ref } from 'vue';
    import { useStore } from 'vuex'
    import Constant from '../../Constant';
    import Footer from '../../components/client/layout/Footer.vue';
    import Header from '../../components/client/layout/Header.vue';
    import Shop_list from '../../components/client/list/Shop_list.vue';
    
    const router = useRouter()
    const route = useRoute()
    const idRestaurant = ref(null)
    const store = useStore();
    
    
    store.dispatch('restaurant_client/' + Constant.GET_ALL_RESTAURANTS_CLIENT)
    
    const restaurants = computed(() => store.getters['restaurant_client/restaurants'])
    
  
  
</script>
  
  
<style scoped lang="scss">

        

</style>