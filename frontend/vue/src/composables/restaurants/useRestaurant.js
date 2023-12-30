import { ref } from 'vue'
import springbootApiService from '../../core/http/springboot.api.service'

export const useRestaurantDetails = (id) => {
    const restaurant = ref({})
    springbootApiService.get('/restaurants/' + id)
        .then(res => {
            restaurant.value = res.data
        })
        .catch(err => console.log(err))

    return restaurant;
};