import Constant from "../../../Constant";
import symfonyApiService from "../../../core/http/symfony.api.service";

const state = {
    users: [],
    user: {},
    isAdmin: false
};

const mutations = {
    [Constant.GET_ALL_USERS]: (state, payload) => {
        state.users = payload
    },
    [Constant.GET_ONE_USER]: (state, payload) => {
        state.user = payload
    },
    [Constant.ADD_USER]: (state, payload) => {
        state.users.push(payload)
        // console.log(state.users);
    },
    [Constant.UPDATE_USER]: (state, payload) => {
        let index = state.users.findIndex(user => user.id === payload.id);
        if (index !== -1) {
            Object.assign(state.users[index], payload)
            Object.assign(state.user, payload)
        }
    },
    [Constant.DELETE_USER]: (state, payload) => {
        let index = state.users.findIndex((item) => item.id === payload);
        state.users.splice(index, 1);
        state.user = {}
    },
    [Constant.GET_USER_LOGOUT_ADMIN]: (state) => {
        state.isAdmin = false
    },
    [Constant.INI_USER]: (state) => {
        state.user = {}
    }

};

const actions = {

    [Constant.GET_ALL_USERS]: async (store) => {
        try{
            await symfonyApiService.get('/users').then(response => {
                store.commit(Constant.GET_ALL_USERS, response.data.users)
            })
        } catch (error) {
            console.log(error)
        }
    },
    [Constant.GET_ONE_USER]: async (store, payload) => {
        try{
            await symfonyApiService.get('/user/' + payload).then(response => {
                store.commit(Constant.GET_ONE_USER, response.data.user)
            })
        } catch (error) {
            console.log(error)
        }
    },
    [Constant.ADD_USER]: async (store, payload) => {
        try{
            await symfonyApiService.post('/user', payload).then(response => {
                store.commit(Constant.ADD_USER, response.data.user)
            })
        } catch (error) {
            console.log(error)
        }
    },
    [Constant.UPDATE_USER]: async (store, payload) => {
        try{
            // console.log(payload);
            await symfonyApiService.put('/user/' + payload.id, payload).then(response => {
                store.commit(Constant.UPDATE_USER, response.data.user)
            })
        } catch (error) {
            console.log(error)
        }
    },
    [Constant.DELETE_USER]: async (store, payload) => {
        try{
            // console.log(payload);
            await symfonyApiService.delete('/user/' + payload.id).then(response => {
                store.commit(Constant.DELETE_USER, payload)
            })
        } catch (error) {
            console.log(error)
        }
    },
    [Constant.GET_USER_LOGOUT_ADMIN]: async (store) => {
        try{
            await symfonyApiService.get('/logout').then(response => {
                localStorage.clear()
                store.commit(Constant.GET_USER_LOGOUT_ADMIN)
            })
        } catch (error) {
            console.log(error)
        }
    },

};

const getters = {
    users: state => state.users,
    user: state => state.user
};

export default {
    namespaced: true,
    state,
    mutations,
    actions,
    getters
};