<template>
    <div class="modal-update-booking" v-if="Object.entries(booking).length !== 0">
        <button type="button" class="btn btn-primary btn-lg" data-bs-toggle="modal"
            :data-bs-target="'#modalUpdate' + booking.id">
            <font-awesome-icon icon="pen-to-square" />
        </button>

        <div class="modal fade" :id="'modalUpdate' + booking.id" tabindex="-1" role="dialog"
            :aria-labelledby="'modalTitleUpdate' + booking.id" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-sm" role="document">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" :id="'modalTitleUpdate' + booking.id">Actualizar Usuario</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <CreateBooking :data="booking" :editModal="true" />
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal"
                            @click="updateBooking()">Actualizar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { computed, reactive, ref } from 'vue';
import CreateBooking from '../forms/CreateBooking.vue';

const props = defineProps([
    'dataBooking',
]);

const booking = computed(() => ({ ...props.dataBooking }));


const emit = defineEmits();

const formData = () => {
    return {
        id: booking.value.id,
        date_booking: booking.value.date.date,
        people: booking.value.people,
        id_user: booking.value.id_user,
        id_rest: booking.value.id_rest,
        id_turn: booking.value.id_turn,
        state: booking.value.state,
    }
}

const updateBooking = () => {
    emit('updateBooking', formData());
};

</script>

<style></style>