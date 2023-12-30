import Constant from "../../../Constant";
import springbootApiService from "../../../core/http/springboot.api.service";

const state = {
    user: {},
};


const mutations = {

    [Constant.LOGIN_USER]: (state, payload) => {
        state.user = payload;
    },

};


const actions = {

    [Constant.LOGIN_USER]: async (store, payload) => {
        try {
            await springbootApiService.post('/api/login', payload)
                .then((response) => {
                    localStorage.setItem('jwt', response.data.token)
                    localStorage.setItem('isAdmin', false)
                    if (response.data.user.type == 'admin') {
                        localStorage.setItem('isAdmin', true)
                    }
                    store.commit(Constant.LOGIN_USER, response.data.user);
                })
            return true
        } catch (error) {
            console.error(error);
            return false
        }
    },
    [Constant.REGISTER_USER]: async (store, payload) => {
        try {
            await springbootApiService.post("/api/register", payload)
                .then((res) => {
                })
            return true
        } catch (error) {
            console.error(error);
            return false
        }
    },
    [Constant.GET_USER_LOGIN]: async (store) => {
        try {
            await springbootApiService.get('/api/profile')
                .then((response) => {
                    store.commit(Constant.LOGIN_USER, response.data);
                })
        } catch (error) {
            localStorage.clear()
            store.commit(Constant.LOGIN_USER, {});
            // console.error(error);
        }
    },
    [Constant.GET_USER_LOGOUT]: async (store) => {
        try {
            await springbootApiService.post('/api/logout')
                .then((response) => {
                })
            localStorage.clear()
            store.commit(Constant.LOGIN_USER, {});
        } catch (error) {
            console.error(error);
        }
    }
};


const getters = {
    user: state => state.user
};

export default {
    namespaced: true,
    state,
    mutations,
    actions,
    getters
};