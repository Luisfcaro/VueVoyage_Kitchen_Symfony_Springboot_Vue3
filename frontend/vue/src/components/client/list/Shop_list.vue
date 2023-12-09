<template>

        <div class="" v-for="(restaurant, index) in restaurants" :key="index">
            <Shop_card :restaurant="restaurant" />
        </div>

        {{ restaurants  }}

</template>

<script setup>
    import { useRoute, useRouter } from 'vue-router';
    import { reactive, ref } from 'vue';
    import { useStore } from 'vuex'
    import Shop_card from '../cards/Shop_card.vue';

    const router = useRouter()
    const route = useRoute()
    const idRestaurant = ref(null)
    const store = useStore();

    const props = defineProps([
        'restaurants'
    ]);

    const state = reactive({

  
    });



    // try {
 
    // } catch (error) {
    //     console.log(error);
    // }



</script>

<style scoped lang="scss">

</style>