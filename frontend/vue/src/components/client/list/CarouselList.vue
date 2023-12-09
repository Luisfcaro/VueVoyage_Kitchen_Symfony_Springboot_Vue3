<template>
    <carousel :items-to-show="1" :transition="1">
        <slide v-for="category in categories" :key="category.id">
                <carousel-item :category="category" @click="emitClick(category)"/>
                <!-- {{ category }} -->
        </slide>
        <template #addons>
            <navigation />
            <pagination />
        </template>
    </carousel>
</template>

<script setup>
    import { Carousel, Slide, Pagination, Navigation } from 'vue3-carousel'
    import { getCurrentInstance } from 'vue';
    import CarouselItem from '../cards/CarouselItem.vue';

    const props = defineProps([
        'categories'
    ]);

    const emit = getCurrentInstance().emit

    const emitClick = (category) => {
        emit('emitClick', category)
    }



</script>


<style lang="scss">
    @import 'vue3-carousel/dist/carousel.css';

    .carousel_item {
        min-height: 200px;
        width: 100%;
        background-color: none;
        font-size: 20px;
        border-radius: 8px;
        display: flex;
        justify-content: center;
        align-items: center;
    }
</style>