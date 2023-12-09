import { ref } from 'vue'
import springbootApiService from '../../core/http/springboot.api.service'


export const useInfiniteRestaurants = (limitNew = 0 , limit = 3) => {
        limit = limit + limitNew;
        const restaurants = ref([])
        springbootApiService.get('/restaurants/infinitescroll?limit=' + limit)
            .then(res => restaurants.value = res.data)
            .catch(err => console.log(err)) 
        
        return restaurants;
    };

export const useRestaurants = () => {
    const restaurants = ref([])
    springbootApiService.get('/restaurants')
        .then(res => restaurants.value = res.data)
        .catch(err => console.log(err)) 
    
    return restaurants;
}


export const useRestaurantsPaginate = () => {
    const restaurants = ref([])
    springbootApiService.get('/restaurants/paginate')
        .then(res => restaurants.value = res.data)
        .catch(err => console.log(err)) 
    
    return restaurants;
}