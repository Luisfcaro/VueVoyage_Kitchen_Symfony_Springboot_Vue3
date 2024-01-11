<template>
    <div class="listBookings">
        <div class="card">
            <div class="card-header">
                <h4>List Bookings</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-6 col-md-4 col-lg-3 mb-4" v-for="(booking, index) in bookings" :key="index">
                        <CardBooking :booking="booking" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import CardBooking from '../cards/CardBooking.vue';


const props = defineProps([
    'bookings'
]);

</script>

<style>

</style>