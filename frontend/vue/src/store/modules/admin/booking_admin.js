import Constant from "../../../Constant";
import symfonyApiService from "../../../core/http/symfony.api.service";

const state = {
    bookings: [],
    booking: {},
    turns: [],
    tables: []
};

const mutations = {
    [Constant.GET_ALL_BOOKINGS]: (state, payload) => {
        state.bookings = payload
    },
    [Constant.GET_ONE_BOOKING]: (state, payload) => {
        state.booking = payload
    },
    [Constant.ADD_BOOKING]: (state, payload) => {
        state.bookings.push(payload)
    },
    [Constant.UPDATE_BOOKING]: (state, payload) => {
        state.booking = payload
    },
    [Constant.DELETE_BOOKING]: (state, payload) => {
        state.bookings = state.bookings.filter(booking => booking.id !== payload.id)
    },
    [Constant.GET_ALL_TURNS]: (state, payload) => {
        state.turns = payload
    },
    [Constant.GET_TABLES_NOTIN_BOOKING]: (state, payload) => {
        state.tables = payload
    },
    [Constant.ADD_TABLE_BOOKING]: (state, payload) => {
        state.booking.tables.push(payload)
        state.tables = state.tables.filter(table => table.id_table !== payload.id_table)

        // console.log(state.tables);
        // console.log(payload);
    },
    [Constant.REMOVE_TABLE_BOOKING]: (state, payload) => {
        state.booking.tables = state.booking.tables.filter(table => table.id_table !== payload.id_table)
        state.tables.push(payload)
        // state.booking = payload
    },
    [Constant.INI_BOOKING]: (state) => {
        state.booking = {}
    }
};


const actions = {

    [Constant.GET_ALL_BOOKINGS]: async (store) => {
        try{
            await symfonyApiService.get('/bookings').then(response => {
                store.commit(Constant.GET_ALL_BOOKINGS, response.data.bookings)
                // console.log(response.data.bookings);
            })
        } catch (error) {
            console.log(error)
        }
    },
    [Constant.GET_ONE_BOOKING]: async (store, payload) => {
        try{
            // console.log(payload);
            await symfonyApiService.get('/booking/' + payload).then(response => {
                store.commit(Constant.GET_ONE_BOOKING, response.data.booking)
            })
        } catch (error) {
            console.log(error)
        }
    },
    [Constant.ADD_BOOKING]: async (store, payload) => {
        try{
            // console.log(payload);
            await symfonyApiService.post('/booking', payload).then(response => {
                store.commit(Constant.ADD_BOOKING, response.data.booking)
                // console.log(response.data.booking);
            })
        } catch (error) {
            console.log(error)
        }
    },
    [Constant.UPDATE_BOOKING]: async (store, payload) => {
        try{
            await symfonyApiService.put('/booking/' + payload.id, payload).then(response => {
                store.commit(Constant.UPDATE_BOOKING, response.data.booking)
            })
        } catch (error) {
            console.log(error)
        }
    },
    [Constant.DELETE_BOOKING]: async (store, payload) => {
        try{
            await symfonyApiService.delete('/booking/' + payload).then(response => {
                store.commit(Constant.DELETE_BOOKING, response.data.booking)
            })
        } catch (error) {
            console.log(error)
        }
    },
    [Constant.GET_ALL_TURNS]: async (store) => {
        try{
            await symfonyApiService.get('/turns').then(response => {
                store.commit(Constant.GET_ALL_TURNS, response.data.turns)
            })
        } catch (error) {
            console.log(error)
        }
    },
    [Constant.GET_TABLES_NOTIN_BOOKING]: async (store, payload) => {
        try{
            // console.log(payload);
            await symfonyApiService.post('/tables/' + payload.idBooking + '/notInBooking', payload).then(response => {
                store.commit(Constant.GET_TABLES_NOTIN_BOOKING, response.data)
                // console.log(payload);
            })
        } catch (error) {
            console.log(error)
        }
    },
    [Constant.ADD_TABLE_BOOKING]: async (store, payload) => {
        try{
            console.log(payload);
            await symfonyApiService.put('/booking/' + payload.idBooking + '/tables', payload).then(response => {
                store.commit(Constant.ADD_TABLE_BOOKING, response.data.table)
                // console.log(response.data.booking);
            })
        } catch (error) {
            console.log(error)
        }
    },
    [Constant.REMOVE_TABLE_BOOKING]: async (store, payload) => {
        try{
            console.log(payload);
            await symfonyApiService.post('/booking/' + payload.idBooking + '/tables', payload).then(response => {
                store.commit(Constant.REMOVE_TABLE_BOOKING, response.data.table)
                // console.log(response.data.booking);
            })
        } catch (error) {
            console.log(error)
        }
    },
    [Constant.INI_BOOKING]: (store) => {
        store.commit(Constant.INI_BOOKING)
    }
};


const getters = {
    bookings: state => state.bookings,
    booking: state => state.booking,
    turns: state => state.turns,
    tables: state => state.tables
};

export default {
    namespaced: true,
    state,
    mutations,
    actions,
    getters
};

