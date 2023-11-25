import { createStore } from 'vuex';
// import Constant from '../Constant';
import sidebar from './modules/admin/sidebar'
import restaurant from './modules/admin/restaurant'

const store = createStore({
    modules: {
        sidebar: sidebar,
        restaurant
    }
});

export default store;