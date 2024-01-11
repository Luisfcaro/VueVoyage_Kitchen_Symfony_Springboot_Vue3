<template>
    <div class="cardBooking mb-4">
        <router-link :to="{ name: 'dashBooking', params: { idBooking: booking.id } }">
            <div class="card" @click="store.dispatch('booking_admin/' + Constant.GET_ONE_BOOKING, booking.id)">
                <div class="card-body" v-if="Object.entries(booking).length != 0">
                    <h4 class="card-title">{{ booking.restaurant.name_rest }}</h4>
                    <p class="card-text">Comensales: {{ booking.people }}</p>
                    <p class="card-text">{{ booking.date.date }}</p>
                    <p class="card-text"><b>{{ booking.turn.type_turn }}</b> {{ booking.turn.hora }} </p>
                </div>
            </div>
        </router-link>
    </div>
</template>

<script setup>
import { useStore } from 'vuex';
import Constant from '../../../Constant';

const props = defineProps({
    booking: {}
});

const store = useStore();

</script>

<style scoped lang="scss">
.cardBooking {
    min-height: 215px;

    img {
        max-width: 100%;
        max-height: 150px;
        margin: auto;
        display: block;
    }
}
</style>