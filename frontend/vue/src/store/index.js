import { createStore } from 'vuex';
import sidebar from './modules/admin/sidebar'
import restaurant from './modules/admin/restaurant'
import restaurant_client from './modules/client/restaurant_client';


const store = createStore({
    modules: {
        sidebar: sidebar,
        restaurant,
        restaurant_client,
    }
});

export default store;