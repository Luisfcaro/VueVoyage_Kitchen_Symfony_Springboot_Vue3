import store from '../../store';
import Constant from '../../Constant';
import springbootApiService from "../../core/http/springboot.api.service";

export default {

    async authGuardAdmin(to, from, next) {
        if (localStorage.getItem('jwt')) {
            const response = await springbootApiService.get('/api/profile')
            if (response.status === 200 && response.data.type == 'admin') {
                next();
            } else {
                next('/login');
            }
        } else {
            next('/login');
        }
    },

    async AuthGuard(to, from, next) {
        if (localStorage.getItem('jwt')) {
            next();
        } else {
            next('/login');
        }
    }

}