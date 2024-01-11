<template>
    <div class="TablesBooking">
        <div class="row">
            <div class="mt-3">
                <div class="card w-100">
                    <div class="card-header">
                        <h4>Mesas</h4>
                    </div>
                    <div class="card-body">
                        <div class="card">
                            <div class="card-header">
                                <h4>Mesas Asignadas</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-6 col-md-4 col-lg-3 mb-4"
                                        v-for="(table, index) in state.booking.tables" :key="index">
                                        <CardTable :table="table">

                                            <button type="button" class="btn btn-danger btn-lg" data-bs-toggle="modal"
                                                :data-bs-target="'#modalDeleteTableBooking' + index">
                                                <font-awesome-icon icon="trash" />
                                            </button>

                                            <div class="modal fade" :id="'modalDeleteTableBooking' + index"
                                                tabindex="-1" role="dialog"
                                                :aria-labelledby="'modalDeleteTableBookingTitle' + index"
                                                aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-sm"
                                                    role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title"
                                                                :id="'modalDeleteCategoryRestaurantTitle' + index">
                                                                Eliminar Mesa de tu reserva</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Eliminar categoria: {{ table.num_table }}
                                                            <p>Capacidad: {{ table.capacity_table }}</p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Close</button>
                                                            <button type="button" class="btn btn-danger"
                                                                data-bs-dismiss="modal"
                                                                @click="removeTableFromBooking(table.id_table)">Eliminar</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </CardTable>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="card">
                            <div class="card-header">
                                <h4>Mesas NO Asignadas</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-6 col-md-4 col-lg-3 mb-4"
                                        v-for="(table, index) in state.tables" :key="index">
                                        <CardTable :table="table">

                                            <div class=""
                                                v-if="!(state.booking.tables.some(objeto => objeto.id === table.id_table))">
                                                <button type="button" class="btn btn-success btn-lg" data-bs-toggle="modal"
                                                    :data-bs-target="'#modalAddTableBooking' + index">
                                                    <font-awesome-icon icon="plus" />
                                                </button>

                                                <div class="modal fade" :id="'modalAddTableBooking' + index"
                                                    tabindex="-1" role="dialog"
                                                    :aria-labelledby="'modalAddTableBookingTitle' + index"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-sm"
                                                        role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title"
                                                                    :id="'modalAddTableBookingTitle' + index">
                                                                    Añadir Mesa a tu Reserva</h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                Mesas: {{ table.num_table }}
                                                                <div class="mb-3">
                                                                    <p>Capacidad: {{ table.capacity_table }}</p>
                                                                </div>

                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Close</button>
                                                                <button type="button" class="btn btn-success"
                                                                    data-bs-dismiss="modal"
                                                                    @click="addTableToBooking(table.id_table)">Añadir</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </CardTable>
                                    </div>
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
import { computed, reactive, ref } from 'vue';
import { useStore } from 'vuex';
import Constant from '../../Constant';
import { useRoute } from 'vue-router';

import NotificationService from '../../core/services/NotificationService';
import Notification from '../../components/Notification.vue';
import CardTable from '../../components/admin/cards/CardTable.vue';


const notifications = NotificationService.notifications

const store = useStore();
const route = useRoute();


store.dispatch('booking_admin/' + Constant.GET_ONE_BOOKING, route.params.idBooking).then(() => {
    store.dispatch('booking_admin/' + Constant.GET_TABLES_NOTIN_BOOKING, { idBooking: route.params.idBooking , date: state.booking.date.date, id_turno: state.booking.id_turn})
})

const state = reactive({
    booking: computed(() => store.getters['booking_admin/booking']),
    tables: computed(() => store.getters['booking_admin/tables'])
})


const removeTableFromBooking = async (id) => {
    let data = {
        idBooking: route.params.idBooking,
        id_table: id
    }
    await store.dispatch('booking_admin/' + Constant.REMOVE_TABLE_BOOKING, data)
        .then((data) => {
                NotificationService.addNotification('success', 'Operación exitosa');
        })
    // console.log(data);
}

const addTableToBooking = async (id) => {
    let data = {
        idBooking: route.params.idBooking,
        id_table: id
    }
    await store.dispatch('booking_admin/' + Constant.ADD_TABLE_BOOKING, data)
        .then((data) => {
                NotificationService.addNotification('success', 'Operación exitosa');
        })
}



</script>

<style scoped lang="scss">
.TablesBooking {

    .TablesBooking {
        margin-left: 62px;
        transition: 1s;
        width: inherit;
        margin-top: 45px;

        &.active-sidebar {
            margin-left: 280px;
            margin-top: 0px;
        }
    }
}
</style>