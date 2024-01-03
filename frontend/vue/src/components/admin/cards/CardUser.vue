<template>
    <div class="cardUser mb-4">
        <router-link :to="{ name: 'dashUser', params: { idUser: user.id } }">
            <div class="card" @click="store.dispatch('user_admin/' + Constant.GET_ONE_USER, user.id)">
                <div class="card-body">
                    <img :src="user.photo" alt="user image
                                " class="img-fluid">
                    <h4 class="card-title">{{ user.username }}</h4>
                    <p class="card-text">{{ user.email }}</p>
                    <p class="card-text"> {{ user.type_user }}</p>
                </div>
            </div>
        </router-link>
    </div>
</template>

<script setup>
import { useStore } from 'vuex';
import Constant from '../../../Constant';

const props = defineProps({
    user: {}
});

const store = useStore();

</script>

<style scoped lang="scss">
.cardUser {
    min-height: 215px;

    img {
        max-width: 100%;
        max-height: 150px;
        margin: auto;
        display: block;
    }
}
</style>