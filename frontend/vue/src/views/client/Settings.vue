<template>
    <div class="settings">
        <div class="container-xl p-4">
            <!-- Account page navigation-->
            <nav class="nav nav-borders">
                <a class="nav-link ms-0" :class="{ 'active': pageActive == 0 }" target="__blank"
                    @click="pageActive = 0">Profile</a>
                <a class="nav-link" :class="{ 'active': pageActive == 1 }" @click="pageActive = 1"
                    target="__blank">Bookings</a>
            </nav>
            <hr class="mt-0 mb-4">
            <div class="row">
                <div class="col-xl-4">
                    <!-- Profile picture card-->
                    <div class="card mb-4 mb-xl-0">
                        <div class="card-header">{{ state.user.username }}</div>
                        <div class="card-body text-center">
                            <!-- Profile picture image-->
                            <img class="img-account-profile rounded-circle mb-2" :src="state.user.photo" alt="">
                        </div>
                    </div>
                </div>
                <div class="col-xl-8">

                    <div class="card mb-4" v-if="pageActive == 0">
                        <div class="card-header">Account Details</div>

                        <div class="card-body">
                            <div class="mb-3">
                                <label class="small mb-1" for="inputUsername">Username</label>
                                <p class="form-control-static" id="inputUsername">{{ state.user.username }}</p>
                            </div>

                            <div class="mb-3">
                                <label class="small mb-1" for="inputEmailAddress">Email address</label>
                                <p class="form-control-static" id="inputEmailAddress">{{ state.user.email }}</p>
                            </div>

                        </div>
                    </div>

                    <div class="row" v-if="pageActive == 1">
                        <div class="col-sm-6 col-md-3 col-lg-4 mb-4" v-for="(booking, index) in state.bookings"
                            :key="index">
                            <div class="card">
                                <div class="card-body">
                                    <p>Personas: {{ booking.people }}</p>
                                    <p>Estado: {{ booking.state }}</p>
                                    <p>Fecha: {{ booking.date }}</p>
                                    <hr />
                                    <p>Restaurante</p>
                                    <p>{{ booking.restaurant.name }}</p>
                                    <p>{{ booking.restaurant.location }}</p>
                                    <span class="badge bg-secondary m-1 p-2"
                                        v-for="(categ, index) in booking.restaurant.categories" :key="index">{{ categ.name
                                        }}</span>
                                    
                                    <ModalDeleteBooking :booking="booking" @deleteBooking="deleteBooking($event)"/>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
        <notification v-for="(notification, index) in notifications" :key="index" :type="notification.type"
            :message="notification.message" />
    </div>
</template>

<script setup>
import { computed, reactive, ref } from "vue";
import { useStore } from "vuex";

import { useBookings } from '../../composables/bookings/useBookings';
import ModalDeleteBooking from '../../components/client/modals/ModalDeleteBooking.vue'
import Constant from "../../Constant";

import NotificationService from '../../core/services/NotificationService';
import Notification from '../../components/Notification.vue';
const notifications = NotificationService.notifications

const pageActive = ref(1)

const store = useStore();

const state = reactive({
    user: computed(() => store.getters['user/user']),
    bookings: useBookings()
})

const deleteBooking = async (id) => {
    const res = await store.dispatch('bookings_client/' + Constant.DELETE_BOOKING, id)
    if (res) {
        NotificationService.addNotification('success', 'Operación exitosa');
        state.bookings = useBookings()
    } else {
        NotificationService.addNotification('error', 'Ocurrió un error')
    }
}

</script>

<style lang="scss">
.settings {
    background-color: #f2f6fc;
    color: #69707a;
}

.img-account-profile {
    height: 10rem;
}

.rounded-circle {
    border-radius: 50% !important;
}

.card {
    box-shadow: 0 0.15rem 1.75rem 0 rgb(33 40 50 / 15%);
}

.card .card-header {
    font-weight: 500;
}

.card-header:first-child {
    border-radius: 0.35rem 0.35rem 0 0;
}

.card-header {
    padding: 1rem 1.35rem;
    margin-bottom: 0;
    background-color: rgba(33, 40, 50, 0.03);
    border-bottom: 1px solid rgba(33, 40, 50, 0.125);
}

.form-control,
.dataTable-input {
    display: block;
    width: 100%;
    padding: 0.875rem 1.125rem;
    font-size: 0.875rem;
    font-weight: 400;
    line-height: 1;
    color: #69707a;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid #c5ccd6;
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    border-radius: 0.35rem;
    transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
}

.nav-borders .nav-link.active {
    color: #0061f2;
    border-bottom-color: #0061f2;
}

.nav-borders .nav-link {
    color: #69707a;
    border-bottom-width: 0.125rem;
    border-bottom-style: solid;
    border-bottom-color: transparent;
    padding-top: 0.5rem;
    padding-bottom: 0.5rem;
    padding-left: 0;
    padding-right: 0;
    margin-left: 1rem;
    margin-right: 1rem;
}
</style>