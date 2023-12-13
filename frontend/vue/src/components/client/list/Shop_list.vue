<template>

        <div class="" v-for="(restaurant, index) in restaurants" :key="index">
            <Shop_card :restaurant="restaurant" />
        </div>

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


</script>

<style scoped lang="scss">

</style>