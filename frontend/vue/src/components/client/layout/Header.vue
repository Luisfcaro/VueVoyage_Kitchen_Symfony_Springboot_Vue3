<template>
    <header>
        <nav class="navbar">
            <div class="logo-container">
                <img src="../../../assets/img/VueVoyage.png" alt="Logo del Restaurante" class="logo">
                <div class="brand-title">VueVoyage</div>
            </div>
            <ul class="menu-list align-items-center">
                <li>
                    <router-link :to="{ name: 'home' }">
                        Home
                    </router-link>
                </li>
                <li>
                    <router-link :to="{ name: 'shop' }">
                        Reservas
                    </router-link>
                </li>
                <li><a href="#">Contacto</a></li>
                <li v-if="Object.entries(state.user).length == 0">
                    <router-link :to="{ name: 'login' }">
                        Login
                    </router-link>
                </li>
                <li v-if="Object.entries(state.user).length != 0" class="nav-item dropdown profile">
                    <div class="nav-link dropdown-toggle img-cont" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <img class="profile-img rounded-circle" :src="state.user.photo" alt="" width="40" height="40">
                    </div>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><router-link :to="{ name: 'settings' }" class="dropdown-item text-dark">Settings</router-link>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item text-dark" @click="logout()">LogOut</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
    </header>
</template>

<script setup>
import { computed, reactive } from "vue";
import { useStore } from "vuex";
import Constant from "../../../Constant"
import { useRouter } from "vue-router";

const store = useStore();
const router = useRouter();

const state = reactive({
    user: computed(() => store.getters['user/user'])
})

const logout = () => {
    store.dispatch('user/' + Constant.GET_USER_LOGOUT)
    router.push('/')
}

</script>

<style scoped lang="scss">
$primary-color: #8B0000;
$secondary-color: #fff;
$hover-color: darken($primary-color, 15%);
$text-color: #fff;

@import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap');

body {
    font-family: 'Roboto', sans-serif;
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    background: #f4f4f4;
}

header {
    background: $primary-color;
    padding: 15px 0;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.navbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    padding: 0 20px;

    .logo-container {
        display: flex;
        align-items: center;

        .logo {
            height: 60px; // Un poco más grande para destacar
            margin-right: 15px;
            transition: transform 0.3s ease; // Transición para el logo

            &:hover {
                transform: scale(1.05); // Efecto de zoom al pasar el ratón
            }
        }

        .brand-title {
            font-size: 2em; // Aumentar tamaño para más presencia
            color: $secondary-color;
            font-weight: 700; // Más bold para destacar
        }
    }

    .menu-list {
        list-style: none;
        display: flex;
        padding-left: 0;
        margin: 0;

        li {
            padding: 0 20px; // Más espacio para mejor legibilidad

            a {
                text-decoration: none;
                color: $text-color;
                font-weight: bold;
                transition: color 0.3s ease, border-bottom-color 0.3s ease; // Suavizar transiciones

                &:hover {
                    color: $hover-color;
                }

                &.active {
                    border-bottom: 3px solid $text-color; // Hacerlo más notable
                }
            }
        }
    }

    .profile {
        .img-cont {
            .profile-img {}
        }
    }

}

@media screen and (max-width: 768px) {
    .navbar {
        .menu-list {
            flex-direction: column;
            align-items: center;
            width: 100%;

            li {
                padding: 10px 0; // Más espacio para toques en móviles
            }
        }
    }
}
</style>