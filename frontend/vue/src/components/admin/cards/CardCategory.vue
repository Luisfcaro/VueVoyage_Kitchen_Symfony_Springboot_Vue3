<template>
    <div class="card cardCategory">
        <div class="card-body">
            <h4 class="card-title">{{ category.name_cat }}</h4>
            <img :src="category.img_cat" alt="">
        </div>
    </div>
</template>

<script setup>
const props = defineProps([
    'category'
]);
</script>

<style scoped lang="scss">
.cardCategory {
    min-height: 215px;
    img {
        max-width: 100%;
        max-height: 150px;
        margin: auto;
        display: block;
    }
}
</style>