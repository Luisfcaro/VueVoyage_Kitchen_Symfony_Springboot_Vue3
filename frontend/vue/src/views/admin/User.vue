<template>
    <div class="user">
        <div class="row">
            <div class="mt-3">
                <div class="card w-100">
                    <div class="card-header">
                        <h4>DashBoard Usuarios</h4>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div class="inf">
                                <h5>Información del Usuario:</h5>
                                <p>{{ user.username }}</p>
                                <p>{{ user.email }}</p>
                                <p>{{ user.type_user }}</p>
                                <img :src="user.photo" alt="">
                            </div>
                            <ModalUpdateUser :dataUser="user" @updateUser="updateUser($event)" />
                            <ModalDeleteUser :dataUser="user" @deleteUser="deleteUser($event)" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>


<script setup>
import { useRoute } from 'vue-router';
import { computed, reactive, ref } from 'vue';
import { useStore } from 'vuex'
import Constant from '../../Constant';

import ModalUpdateUser from '../../components/admin/modals/ModalUpdateUser.vue';
import ModalDeleteUser from '../../components/admin/modals/ModalDeleteUser.vue';


const route = useRoute()
const idUser = ref(null)
const store = useStore();

const changeUser = () => {
    idUser.value = route.params.idUser
    store.dispatch('user_admin/' + Constant.GET_ONE_USER, idUser.value)
}
changeUser()

const user = reactive(computed(() => store.getters['user_admin/user']))

// const deleteTable = (idTable) => {
//     store.dispatch('restaurant/' + Constant.DELETE_TABLE, idTable)
// };

// const updateTable = (table) => {
//     store.dispatch('restaurant/' + Constant.UPDATE_TABLE, table)
// };

const updateUser = (user) => {
    store.dispatch('user_admin/' + Constant.UPDATE_USER, user)
};

const deleteUser = (user) => {
    // console.log(user);
    store.dispatch('user_admin/' + Constant.DELETE_USER, user)
};

</script>

<style scoped lang="scss">
.user {
    min-height: 100vh;
    max-width: inherit !important;

    .card {
        h4 {
            margin: 4px;
        }

        .card-body {
            .inf {
                img {
                    max-width: 100%;
                }
            }
        }
    }

}
</style>