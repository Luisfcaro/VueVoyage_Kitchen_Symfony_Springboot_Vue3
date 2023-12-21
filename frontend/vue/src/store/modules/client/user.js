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
                    console.log(response.data);
                    localStorage.setItem('jwt', response.data.token)
                    localStorage.setItem('isAdmin', false)
                    if (response.data.user.type == 'admin') {
                        localStorage.setItem('isAdmin', true)
                    }
                    store.commit(Constant.LOGIN_USER, response.data.user);
                })
        } catch (error) {
            console.error(error);
        }
    },
    [Constant.GET_USER_LOGIN]: async (store) => {
        try {
            await springbootApiService.get('/api/profile')
                .then((response) => {
                    console.log(response);
                })
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