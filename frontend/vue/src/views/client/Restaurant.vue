<template>
    <div class="restaurant">

        <section class="banner text-center py-5" :style="{ backgroundImage: `url('${state.restaurant.img}')` }">
            <h1 class="text-light with-border">{{ state.restaurant.name }}</h1>
        </section>

        <section class="my-3">
            <div class="container">
                <div class="row">
                    <div class="col-lg-10 offset-lg-1">
                        <div class="alert alert-primary text-center ">
                            Open Everyday from 12pm &bull; Bookings Essential &bull; BYO Wine
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section>
            <div class="container my-3">
                <div class="row">
                    <div class="col-lg-6 offset-lg-1">
                        <ul class="list-group">
                            <li class="list-group-item pt-4">
                                <h5>Crispy Fish Burger <span class="badge bg-secondary">New</span></h5>
                                <p>Panko crumbed fish fillet, slaw &amp; our famous spicy sauce.<br /><span
                                        class="text-secondary">$10</span></p>
                            </li>
                            <li class="list-group-item pt-4">
                                <h5>Salt &amp; Pepper Calamari</h5>
                                <p>Fresh fried calamari, lightly seasoned with salt &amp; pepper.<br /><span
                                        class="text-secondary">$12</span></p>
                            </li>
                            <li class="list-group-item pt-4">
                                <h5>Fish of the Day</h5>
                                <p>Grilled fish of the day, garden salad &amp; served with chips.<br /><span
                                        class="text-secondary">$17</span></p>
                            </li>
                            <li class="list-group-item pt-4">
                                <h5>Garlic Prawn Skewer</h5>
                                <p>Tiger prawns coated marinated in garlic served on a skewer.<br /><span
                                        class="text-secondary">$19</span></p>
                            </li>
                            <li class="list-group-item pt-4">
                                <h5>Seafood Platter</h5>
                                <p>Single serve platter containing fish, prawns, oysters &amp; a glass of wine.<br /><span
                                        class="text-secondary">$25</span></p>
                            </li>
                        </ul>
                    </div>
                    <div class="col-lg-4">
                        <div class="card mb-5">
                            <div class="card-header">
                                Reserva Online
                            </div>
                            <div class="card-body">
                                <h5 class="card-title">Las reservas son esenciales!</h5>
                                <p class="card-text">No pierdas la oportunidad y reserva ya para asegurar tu mesa.</p>
                                <a v-if="Object.entries(state.user) != 0" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#modalId">Comprobar
                                    disponibilidad</a>
                                <div v-if="Object.entries(state.user) == 0">
                                    <router-link :to="{ name: 'login' }" class="btn btn-primary mb-1">
                                        Login / Register
                                    </router-link>
                                    <p>Inicia sesion para reservar</p>
                                </div>
                                <div class="modal fade" id="modalId" tabindex="-1" role="dialog"
                                    aria-labelledby="modalTitleId" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="modalTitleId">
                                                    Elige el dia de tu reserva
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3 d-flex">
                                                    <div class="me-3">
                                                        <label for="numberGuests" class="form-label">Número de
                                                            comensales</label>
                                                        <input type="number" class="form-control" id="numberGuests"
                                                            name="numberGuests" required min="1"
                                                            v-model="state.datePick.people" />
                                                    </div>
                                                    <div>
                                                        <label for="reservationDate" class="form-label">Fecha de
                                                            reserva</label>
                                                        <input type="date" class="form-control" id="reservationDate"
                                                            name="date" required v-model="state.datePick.date" />
                                                    </div>
                                                </div>
                                                <div>
                                                    <button type="button" class="btn btn-secondary me-2"
                                                        @click="checkShifts()">Comprobar</button>
                                                </div>
                                                <div v-if="state.turnsAvaibles.length > 0">
                                                    <hr>
                                                    <div class="mb-3">
                                                        <label for="reservationTime" class="form-label">Hora de
                                                            reserva</label>
                                                        <select class="form-select" id="reservationTime"
                                                            name="reservationTime" v-model="state.shiftPick" required>
                                                            <option :value="turn.id"
                                                                v-for="(turn, key) in state.turnsAvaibles" :key="key">
                                                                {{ turn.hora }}</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <button type="button" class="btn btn-primary"
                                                            @click="reserve()">Reservar</button>
                                                    </div>
                                                </div>
                                                <div v-else>
                                                    <hr>
                                                    No hay turnos disponibles para estos datos, intenta con otros
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <h6 class="font-weight-bold">Horas de apertura</h6>
                        <p>Desayunos - Almuerzos<br />08:00 - 12:00</p>
                        <p>Comidas<br />13:00 - 17:00</p>
                        <p>Cenas<br />20:00 - 01:00</p>
                        <h6 class="font-weight-bold">Location</h6>
                        <p>{{ state.restaurant.location }}</p>
                        <h6 class="font-weight-bold">Categorias</h6>
                        <span class="badge bg-secondary m-1 p-2" v-for="(categ, index) in state.restaurant.categories"
                            :key="index">{{ categ.name }}</span>
                    </div>
                </div>
            </div>
        </section>
        <notification v-for="(notification, index) in notifications" :key="index" :type="notification.type"
            :message="notification.message" />
    </div>
</template>

<script setup>
import { computed, getCurrentInstance, reactive, ref, toRefs } from 'vue';
import { useRoute } from 'vue-router';
import { useStore } from 'vuex';
import { useRestaurantDetails } from '../../composables/restaurants/useRestaurant';
import Constant from '../../Constant';

import NotificationService from '../../core/services/NotificationService';
import Notification from '../../components/Notification.vue';
const notifications = NotificationService.notifications


import { formData } from "../../utils"

const route = useRoute()
const store = useStore();

const idRestaurant = route.params.id

const state = reactive({
    restaurant: useRestaurantDetails(idRestaurant),
    datePick: {
        people: 1,
        date: new Date().toISOString().split('T')[0],
        rest: parseInt(idRestaurant)
    },
    shiftPick: 1,
    user: computed(() => store.getters['user/user']),
    turnsAvaibles: computed(() => store.getters['bookings_client/turnsAvaibles'])
})

const checkShifts = async () => {
    store.dispatch('bookings_client/' + Constant.CHECK_TURNS_AVAIBLES, formData(state.datePick))
}

const reserve = async () => {
    let body = formData(state.datePick)
    body.shift = state.shiftPick
    let res = await store.dispatch('bookings_client/' + Constant.MAKE_RESERVE, body)
    if (res) {
        NotificationService.addNotification('success', 'Operación exitosa');
        setTimeout(() => {
            window.location.reload()
        }, 1000);
    } else {
        NotificationService.addNotification('error', 'Ocurrió un error')
        setTimeout(() => {
            window.location.reload()
        }, 1000);
    }
}

</script>

<style lang="scss">
.banner {
    background-size: cover;
    background-position: center;
    color: white;
    padding: 50px;
}

.with-border {
    color: white;
    text-shadow: 2px 2px 10px rgba(0, 0, 0, 0.8);
    padding: 10px;
}
</style>