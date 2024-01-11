import { ref } from 'vue'
import springbootApiService from '../../core/http/springboot.api.service'

export const useBookings = () => {
    const bookings = ref([])
    springbootApiService.get('/bookings')
        .then((res) => {
            bookings.value = res.data
        })
        .catch(err => console.log(err))

    return bookings;
};