<template>
    <div class="listCategories">
        <div class="card">
            <div class="card-header">
                <h4>List Categories</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-6 col-md-4 col-lg-3 mb-4" v-for="(category, index) in categories" :key="index">
                        <CardCategory :category="category" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import CardCategory from '../cards/CardCategory.vue';
const props = defineProps([
    'categories'
]);

</script>

<style>

</style>