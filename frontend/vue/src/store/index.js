import { createStore } from 'vuex';
import sidebar from './modules/admin/sidebar'
import restaurant from './modules/admin/restaurant'
import restaurant_client from './modules/client/restaurant_client';
import user from './modules/client/user';
import user_admin from './modules/admin/user_admin';
import booking_admin from './modules/admin/booking_admin';
import bookings_client from './modules/client/bookings_client';

const store = createStore({
    modules: {
        sidebar: sidebar,
        restaurant,
        restaurant_client,
        user,
        user_admin,
        bookings_client,
        booking_admin
    }
});

export default store;