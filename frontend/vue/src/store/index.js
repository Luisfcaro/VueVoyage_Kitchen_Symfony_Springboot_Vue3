import { createStore } from 'vuex';
import sidebar from './modules/admin/sidebar'
import restaurant from './modules/admin/restaurant'
import restaurant_client from './modules/client/restaurant_client';
import user from './modules/client/user';
import user_admin from './modules/admin/user_admin';

const store = createStore({
    modules: {
        sidebar: sidebar,
        restaurant,
        restaurant_client,
        user,
        user_admin,
    }
});

export default store;