import Constant from "../../../Constant";
import springbootApiService from "../../../core/http/springboot.api.service";

const state = {
    turnsAvaibles: []
};


const mutations = {
    [Constant.CHECK_TURNS_AVAIBLES]: (state, payload) => {
        state.turnsAvaibles = payload;
    }
};


const actions = {
    [Constant.CHECK_TURNS_AVAIBLES]: async (store, payload) => {
        try {
            await springbootApiService.post('/bookings/checkDateAndCapacity', payload)
                .then((response) => {
                    store.commit(Constant.CHECK_TURNS_AVAIBLES, response.data);
                })
        } catch (error) {
            console.error(error);
        }
    },
    [Constant.MAKE_RESERVE]: async (store, payload) => {
        try {
            await springbootApiService.post('/bookings/makeReservation', payload)
                .then((response) => {
                    console.log(response);
                })
            return true
        } catch (error) {
            console.error(error);
            return false
        }
    },
    [Constant.DELETE_BOOKING]: async (store, payload) => {
        try {
            let bookingId = payload;
            await springbootApiService.put(`/bookings/cancel/${bookingId}`)
            return true
        } catch (error) {
            console.log(error);
            return false
        }
    }
};


const getters = {
    turnsAvaibles: state => state.turnsAvaibles
};

export default {
    namespaced: true,
    state,
    mutations,
    actions,
    getters
};