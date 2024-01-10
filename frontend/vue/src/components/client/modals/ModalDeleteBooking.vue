<template>
    <div class="modal-delete-booking">
        <button type="button" class="btn btn-danger btn-lg" data-bs-toggle="modal" :data-bs-target="'#modal' + booking.id">
            <font-awesome-icon icon="trash" />
        </button>

        <div class="modal fade" :id="'modal' + booking.id" tabindex="-1" role="dialog"
            :aria-labelledby="'modalTitle' + booking.id" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" :id="'modalTitle' + booking.id">Eliminar Reserva</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Personas: {{ booking.people }}</p>
                        <p>Estado: {{ booking.state }}</p>
                        <p>Fecha: {{ booking.date }}</p>
                        <hr />
                        <p>Restaurante</p>
                        <p>{{ booking.restaurant.name }}</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal"
                            @click="deleteBooking()">Eliminar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
const props = defineProps([
    'booking',
]);

const emit = defineEmits();

const deleteBooking = () => {
    emit('deleteBooking', props.booking.id);
};

</script>

<style></style>