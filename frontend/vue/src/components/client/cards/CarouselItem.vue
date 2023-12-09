<template>
    <div class="carusel_item">
        <img :src="'https://picsum.photos/200/300?random=' + category.id" />
        <!-- {{ category }} -->
    </div>
</template>

<script setup>
    import { Slide } from 'vue3-carousel'

    const props = defineProps([
        'category'
    ]);



</script>

<style scoped lang="scss">


    .carusel_item {
        img {
            width: 30%;
            height: auto;
        }
    }
</style>