import { ref } from 'vue'
import springbootApiService from '../../core/http/springboot.api.service'


export const useInfiniteRestaurants = (limitNew = 0, limit = 3) => {
    limit = limit + limitNew;
    const restaurants = ref([])
    springbootApiService.get('/restaurants/infinitescroll?limit=' + limit)
        .then(res => {
            restaurants.value = res.data
        })
        .catch(err => console.log(err))

    return restaurants;
};


// export const useInfiniteRestaurants = async (limitNew = 0, limit = 3) => {
//     let newLimit = limit + limitNew;
//     let restaurants = [];

//     try {
//         const response = await springbootApiService.get('/restaurants/infinitescroll?limit=' + newLimit);
//         restaurants = response.data;
//     } catch (err) {
//         console.log(err);
//     }

//     return restaurants;
// };



export const useFiltersRestaurants = (filters = {}) => {
    let cadena = '';
    if (filters.categories.length > 0) {
        filters.categories.forEach((category, index) => {
            if (index === 0) {
                cadena += '?categories=' + category;
            } else {
                cadena += '&categories=' + category;
            }
        });
    } else {
        cadena = '?categories=';
    }

    const restaurants = ref([])
    springbootApiService.get('/restaurants' + cadena + '&name_rest=' + filters.name_rest + '&page=' + filters.page + '&limit=' + filters.limit + '&order=' + filters.order)
        .then(res => {
            restaurants.value = res.data
        })
        .catch(err => console.log(err))


    return restaurants;
}


export const useRestaurantsPaginate = (filters = {}) => {
    let cadena = '';
    if (filters.categories.length > 0) {
        filters.categories.forEach((category, index) => {
            if (index === 0) {
                cadena += '?categories=' + category;
            } else {
                cadena += '&categories=' + category;
            }
        });
    } else {
        cadena = '?categories=';
    }


    const total_pages = ref(0)
    springbootApiService.get('/restaurants/paginate' + cadena + '&name_rest=' + filters.name_rest + '&page=' + 1 + '&limit=' + filters.limit + '&order=' + filters.order)
        .then(res => {
            const qty_rest = res.data
            const pages = Math.ceil(qty_rest / filters.limit);
            total_pages.value = pages;

        })
        .catch(err => console.log(err))

    return total_pages;
}