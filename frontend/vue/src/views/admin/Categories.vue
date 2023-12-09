<template>
    <div class="categories">
        <div class="row">
            <div class="mt-3">
                <div class="card w-100">
                    <div class="card-header">
                        <h4>Categories</h4>
                    </div>
                    <div class="card-body">
                        <CreateCategory />
                        <hr>
                        <ListCategories :categories="categories" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { computed } from 'vue';
import CreateCategory from '../../components/admin/forms/CreateCategory.vue';
import ListCategories from '../../components/admin/lists/ListCategories.vue';
import { useStore } from 'vuex';
import Constant from '../../Constant';

const store = useStore();

store.dispatch('restaurant/' + Constant.GET_ALL_CATEGORIES)

const categories = computed(() => store.getters['restaurant/categories'])

</script>

<style scoped lang="scss">
.categories {

    .categories {
        margin-left: 62px;
        transition: 1s;
        width: inherit;
        margin-top: 45px;

        &.active-sidebar {
            margin-left: 280px;
            margin-top: 0px;
        }
    }
}
</style>