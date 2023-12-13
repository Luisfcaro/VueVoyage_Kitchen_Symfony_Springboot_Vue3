<template>
    <nav aria-label="Page navigation">
        <ul class="pagination justify-content-center p-3">
            <li class="page-item" :class="{ disabled: currentPage === 1 }">
                <a class="page-link" aria-label="Previous" @click="prevPage">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>
            <li v-for="page in pages" :key="page" class="page-item" :class="{ active: currentPage === page }">
                <a class="page-link" @click="changePage(page)">{{ page }}</a>
            </li>
            <li class="page-item" :class="{ disabled: currentPage === pages }">
                <a class="page-link" aria-label="Next" @click="nextPage">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        </ul>
    </nav>
</template>
  
<script setup>
import { ref, defineProps, watch, reactive, computed } from 'vue';
import { useRoute, useRouter } from 'vue-router';

const route = useRoute();
const router = useRouter();
const props = defineProps(['pages']);
const currentPage = ref(1);

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
    currentPage.value = filters_Url.page || 1;
};

const changePage = (page) => {
    if (page >= 1 && page <= props.pages) {
        currentPage.value = page;

        updateRoute();
    }
};

const prevPage = () => {
    if (currentPage.value > 1) {
        currentPage.value--;

        updateRoute();
    }
};

const nextPage = () => {
    if (currentPage.value < props.pages) {
        currentPage.value++;

        updateRoute();
    }
};

const updateRoute = () => {
    filters_Url.page = currentPage.value
    router.push({
        name: 'shop_filter',
        params: {
            filters: btoa(JSON.stringify(filters_Url)),
        },
    });
};

setPageAndFiltersFromRoute();

watch(() => route.params.filters, setPageAndFiltersFromRoute);

</script>
  
<style lang="scss" scoped>
nav {
    background-color: #110f16;
    margin: auto;
}

.pagination {
    margin-bottom: 0;
}
</style>
  