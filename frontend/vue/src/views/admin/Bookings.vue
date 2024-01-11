<template>
    <div class="bookings">
        <div class="row">
            <div class="mt-3">
                <div class="card w-100">
                    <div class="card-header">
                        <h4>Dashboard Bookings</h4>
                    </div>
                    <div class="card-body">
                        <CreateBooking />
                        <hr>
                        <ListBookings :bookings="bookings" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { computed } from 'vue';
import { useStore } from 'vuex';
import Constant from '../../Constant';
import ListBookings from '../../components/admin/lists/ListBookings.vue';
import CreateBooking from '../../components/admin/forms/CreateBooking.vue';

const store = useStore();

store.dispatch('booking_admin/' + Constant.GET_ALL_BOOKINGS)

const bookings = computed(() => store.getters['booking_admin/bookings']);

</script>

<style scoped lang="scss">
.dashboard {
    min-height: 100vh;
    max-width: inherit !important;

    .container.dashboard {
        margin-left: 62px;
        transition: 1s;
        width: inherit;
        margin-top: 45px;

        &.active-sidebar {
            margin-left: 280px;
            margin-top: 0;
        }

        .card {
            h4 {
                margin: 4px;
            }
        }
    }


}
</style>