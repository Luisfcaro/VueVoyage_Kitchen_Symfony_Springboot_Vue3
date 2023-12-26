<template>
    <div class="search">
        <div class="col-md-12 col-lg-6 sidebar">
            <div class="sidebar-box search-form-wrap">
                <div class="search-form">
                    <div class="form-group">
                        <span class="icon"><font-awesome-icon icon="search" /></span>
                        <input type="text" class="form-control" v-model="search" id="s" placeholder="Type a keyword and hit enter" @input="updateRoute()">
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, watch, reactive } from 'vue';
import { useRoute, useRouter } from 'vue-router';
const route = useRoute();
const router = useRouter();
const search = ref('');

const filters_Url = reactive({
    categories: [],
    name_rest: '',
    order: 0,
    page: 1,
    limit: 4,
})

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
    search.value = filters_Url.name_rest || '';
};

setPageAndFiltersFromRoute();

const updateRoute = () => {
    filters_Url.name_rest = search.value
    filters_Url.page = 1
    router.push({
        name: 'shop_filter',
        params: {
            filters: btoa(JSON.stringify(filters_Url)),
        },
    });
};

watch(() => route.params.filters, setPageAndFiltersFromRoute);
</script>

<style lang="scss">
.search {

    .sidebar-box {
        font-size: 15px;
        width: 100%;
        background: #fff;
    }

    .search-form-wrap {
        display: block;
    }

    .search-form {
        .form-group {
            position: relative;

            #s {
                padding-right: 50px;
                background: lighten(black, 97%);
                padding: 15px 15px;
                border: none;
            }
        }

        .icon {
            position: absolute;
            top: 50%;
            right: 20px;
            transform: translateY(-50%);
        }
    }
}
</style>