<template>
    <div class="user">
        <div class="row">
            <div class="mt-3">
                <div class="card w-100">
                    <div class="card-header">
                        <h4>DashBoard Bookings</h4>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div class="info" v-if="Object.entries(booking).length != 0">
                                <h5>Información de la reserva:</h5>
                                <p><b>Nombre del cliente:</b> {{ booking.user.username }}</p>
                                <p><b>Fecha de la reserva:</b> {{ booking.date.date }}</p>
                                <p><b>Restaurante:</b> {{ booking.restaurant.name_rest }}</p>
                                <p><b>Comensales:</b> {{ booking.people }}</p>
                                <p><b>Turno:</b> {{ booking.turn.type_turn }} <b>Hora:</b> {{ booking.turn.hora }}</p>
                                <p><b>Estado:</b> {{ booking.state }}</p>
                            </div>
                        </div>

                        <ModalUpdateBooking :dataBooking="booking" @updateBooking="updateBooking($event)" />

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
import ModalUpdateBooking from '../../components/admin/modals/ModalUpdateBooking.vue';


const route = useRoute()
const idBooking = ref(null)
const store = useStore();

const changeBooking = () => {
    idBooking.value = route.params.idBooking
    store.dispatch('booking_admin/' + Constant.GET_ONE_BOOKING, idBooking.value)
}

changeBooking()

const booking = reactive(computed(() => store.getters['booking_admin/booking']))

const updateBooking = (booking) => {
    // console.log(booking);
    store.dispatch('booking_admin/' + Constant.UPDATE_BOOKING, booking)
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

            .info {
                font-family: Arial, sans-serif;
                background-color: #f2f2f2;
                border: 1px solid #dcdcdc;
                border-radius: 5px;
                padding: 15px;
                margin: 10px 0;
            }

            .info h5 {
                color: #333;
                font-size: 18px;
                margin: 0 0 10px 0;
            }

            .info p {
                color: #666;
                font-size: 14px;
                margin: 5px 0;
            }


        }
    }

}
</style>