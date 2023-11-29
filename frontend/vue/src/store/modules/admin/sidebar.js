const state = {
    isSidebarOpen: true,
};

const mutations = {
    toggleSidebar(state) {
        state.isSidebarOpen = !state.isSidebarOpen;
    },
    openSidebar(state) {
        state.isSidebarOpen = true;
    },
    closeSidebar(state) {
        state.isSidebarOpen = false;
    },
};

const actions = {
    toggleSidebar({ commit }) {
        commit('toggleSidebar');
    },
    openSidebar({ commit }) {
        commit('openSidebar');
    },
    closeSidebar({ commit }) {
        commit('closeSidebar');
    },
};

const getters = {
    isSidebarOpen: state => state.isSidebarOpen,
};

export default {
    namespaced: true,
    state,
    mutations,
    actions,
    getters,
};