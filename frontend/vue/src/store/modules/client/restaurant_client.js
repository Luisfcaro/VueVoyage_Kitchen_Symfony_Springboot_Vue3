import Constant from "../../../Constant";
import springbootApiService from "../../../core/http/springboot.api.service";

const state = {
    restaurants: [],
    categories: [],
    restaurant: {},
    table: {}
};


const mutations = {

    [Constant.GET_ALL_RESTAURANTS_CLIENT]: (state, payload) => {
        state.restaurants = payload;
    },
    [Constant.GET_ONE_RESTAURANT_CLIENT]: (state, payload) => {
        state.restaurant = payload;
    },
    [Constant.GET_ALL_CATEGORIES_CLIENT]: (state, payload) => {
        state.categories = payload;
    },
    [Constant.GET_ONE_CATEGORY_CLIENT]: (state, payload) => {
        state.category = payload;
    },
    [Constant.GET_ALL_TABLES_CLIENT]: (state, payload) => {
        state.tables = payload;
    },
    [Constant.GET_ONE_TABLE_CLIENT]: (state, payload) => {
        state.table = payload;
    },



};


const actions = {

    [Constant.GET_ALL_RESTAURANTS_CLIENT]: async (store) => {
        try {
           await springbootApiService.get('/restaurants')
                .then((response) => {
                    store.commit(Constant.GET_ALL_RESTAURANTS_CLIENT, response.data);
                })
        } catch (error) {
            console.error(error);
        }
    },
    [Constant.GET_ONE_RESTAURANT_CLIENT]: async (store, payload) => {
        try {
            springbootApiService.get('/restaurants/' + payload)
                .then((response) => {
                    store.commit(Constant.GET_ONE_RESTAURANT_CLIENT, response.data);
                })
        } catch (error) {
            console.error(error);
        }
    },
    [Constant.GET_ALL_CATEGORIES_CLIENT]: async (store) => {
        try {
            springbootApiService.get('/categories')
                .then((response) => {
                    store.commit(Constant.GET_ALL_CATEGORIES_CLIENT, response.data);
                })
        } catch (error) {
            console.error(error);
        }
    },
    [Constant.GET_ONE_CATEGORY_CLIENT]: async (store, payload) => {
        try {
            springbootApiService.get('/categories/' + payload)
                .then((response) => {
                    store.commit(Constant.GET_ONE_CATEGORY_CLIENT, response.data);
                })
        } catch (error) {
            console.error(error);
        }
    },
    [Constant.GET_ALL_TABLES_CLIENT]: async (store) => {
        try {
            springbootApiService.get('/tables')
                .then((response) => {
                    store.commit(Constant.GET_ALL_TABLES_CLIENT, response.data);
                })
        } catch (error) {
            console.error(error);
        }
    },
    [Constant.GET_ONE_TABLE_CLIENT]: async (store, payload) => {
        try {
            springbootApiService.get('/tables/' + payload)
                .then((response) => {
                    store.commit(Constant.GET_ONE_TABLE_CLIENT, response.data);
                })
        } catch (error) {
            console.error(error);
        }
    },
};


const getters = {
    restaurants: state => state.restaurants,
    categories: state => state.categories,
    restaurant: state => state.restaurant,
    table: state => state.table
};

export default {
    namespaced: true,
    state,
    mutations,
    actions,
    getters
};