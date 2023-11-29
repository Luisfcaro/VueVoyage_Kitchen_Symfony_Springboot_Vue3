import Constant from '../../../Constant'
import symfonyApiService from '../../../core/http/symfony.api.service'

const state = {
    restaurants: [],
    categories: [],
    restaurant: {},
    table: {}
};

const mutations = {
    [Constant.GET_ALL_RESTAURANTS]: (state, payload) => {
        state.restaurants = payload
    },
    [Constant.GET_ALL_CATEGORIES]: (state, payload) => {
        state.categories = payload
    },
    [Constant.GET_ONE_RESTAURANT]: (state, payload) => {
        state.restaurant = payload
    },
    [Constant.GET_ONE_TABLE]: (state, payload) => {
        state.table = payload
    },
    [Constant.ADD_RESTAURANT]: (state, payload) => {
        state.restaurants.push(payload)
    },
    [Constant.ADD_TABLE]: (state, payload) => {
        state.restaurant.tables.push(payload)
    },
    [Constant.ADD_CATEGORY]: (state, payload) => {
        state.categories.push(payload)
    },
    [Constant.UPDATE_RESTAUNT]: (state, payload) => {
        let index = state.restaurants.findIndex(restaurant => restaurant.id_rest === payload.id_rest);
        if (index !== -1) {
            Object.assign(state.restaurants[index], payload)
            Object.assign(state.restaurant, payload)
        }
    },
    [Constant.UPDATE_TABLE]: (state, payload) => {
        let index = state.restaurant.tables.findIndex(table => table.id_table === payload.id_table);
        if (index !== -1) {
            Object.assign(state.restaurant.tables[index], payload)
            Object.assign(state.table, payload)
        }
    },
    [Constant.DELETE_TABLE]: (state, payload) => {
        let index = state.restaurant.tables.findIndex((item) => item.id_table === payload);
        state.restaurant.tables.splice(index, 1);
        state.table = {}
    },
    [Constant.INI_RESTAURANT]: (state) => {
        state.restaurant = {}
    },
};

const actions = {
    [Constant.GET_ALL_RESTAURANTS]: async (store) => {
        try {
            symfonyApiService.get('/restaurants')
                .then((response) => {
                    store.commit(Constant.GET_ALL_RESTAURANTS, response.data.restaurants);
                })
        } catch (error) {
            console.error(error);
        }
    },
    [Constant.GET_ALL_CATEGORIES]: async (store) => {
        try {
            symfonyApiService.get('/categories')
                .then((response) => {
                    store.commit(Constant.GET_ALL_CATEGORIES, response.data.categories);
                })
        } catch (error) {
            console.error(error);
        }
    },
    [Constant.GET_ONE_RESTAURANT]: async (store, payload) => {
        try {
            symfonyApiService.get('/restaurant/' + payload)
                .then((response) => {
                    store.commit(Constant.GET_ONE_RESTAURANT, response.data.restaurant);
                })
        } catch (error) {
            console.error(error);
        }
    },
    [Constant.GET_ONE_TABLE]: async (store, payload) => {
        store.commit(Constant.GET_ONE_TABLE, payload);
    },
    [Constant.ADD_RESTAURANT]: async (store, payload) => {
        try {
            await symfonyApiService.post('/restaurant', payload)
                .then((response) => {
                    store.commit(Constant.ADD_RESTAURANT, response.data.restaurant);
                })
        } catch (error) {
            console.error(error);
        }
    },
    [Constant.ADD_TABLE]: async (store, payload) => {
        try {
            await symfonyApiService.post('/table', payload)
                .then((response) => {
                    store.commit(Constant.ADD_TABLE, response.data.table);
                })
            return true
        } catch (error) {
            console.error(error);
            return error
        }
    },
    [Constant.ADD_CATEGORY]: async (store, payload) => {
        try {
            await symfonyApiService.post('/category', payload)
                .then((response) => {
                    store.commit(Constant.ADD_CATEGORY, response.data.category);
                })
        } catch (error) {
            console.error(error);
        }
    },
    [Constant.UPDATE_RESTAUNT]: async (store, payload) => {
        try {
            await symfonyApiService.put('/restaurant/' + payload.id_rest, payload)
                .then((response) => {
                    store.commit(Constant.UPDATE_RESTAUNT, response.data.restaurant);
                })
        } catch (error) {
            console.error(error);
        }
    },
    [Constant.UPDATE_TABLE]: async (store, payload) => {
        try {
            await symfonyApiService.put('/table/' + payload.id_table, payload)
                .then((response) => {
                    store.commit(Constant.UPDATE_TABLE, response.data.table);
                })
        } catch (error) {
            console.error(error);
        }
    },
    [Constant.DELETE_TABLE]: async (store, payload) => {
        try {
            await symfonyApiService.delete('/table/' + payload)
                .then((response) => {
                    store.commit(Constant.DELETE_TABLE, payload)
                })
        } catch (error) {
            console.error(error)
        }
    },
    [Constant.INI_RESTAURANT]: async (store) => {
        store.commit(Constant.INI_RESTAURANT);
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
    getters,
};