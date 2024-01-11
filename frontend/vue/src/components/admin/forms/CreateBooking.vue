<template>
    <div class="createUser">
        <div class="card">
            <div class="card-header" v-if="!editModal">
                <h4>Create Booking</h4>
            </div>
            <div class="card-body">
                <form @submit.prevent="submitForm">
                    <div class="mb-3" v-if="!editModal">
                        <label for="date_booking" class="form-label">Fecha de la reserva</label>
                        <input v-model="data.date_booking" type="date" class="form-control" id="date_booking" required>
                    </div>

                    <div class="mb-3">
                        <label for="people" class="form-label">Comensales</label>
                        <input v-model="data.people" type="number" min="1" class="form-control" id="people" required>
                    </div>

                    <div class="mb-3">
                        <label for="id_user" class="form-label">Usuario asignado</label>
                        <select v-model="data.id_user" name="" class="form-control" id="id_user">
                            <option v-for="(user) in users" :value="user.id">{{user.username}}</option>
                        </select>
                    </div>

                    <div class="mb-3" v-if="!editModal">
                        <label for="id_rest" class="form-label">Restaurante</label>
                        <select v-model="data.id_rest" name="" class="form-control" id="id_rest">
                            <option v-for="(restaurant) in restaurants" :value="restaurant.id_rest">{{restaurant.name_rest}}</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="id_turn" class="form-label">Turno</label>
                        <select v-model="data.id_turn" class="form-control" id="id_turn">
                            <option v-for="(turn) in turns" :value="turn.id">{{turn.type_turn}} - {{turn.hora}}</option>
                        </select>
                    </div>

                    <div v-if="editModal">
                        <label for="state" class="form-label">Estado de la reserva</label>
                        <select v-model="data.state" class="form-control" id="state">
                            <option value="Confirmada">Confirmada</option>
                            <option value="Cancelada">Cancelada</option>
                            <option value="Pendiente">Pendiente</option>
                        </select>
                    
                    </div>

                    <button type="submit" class="btn btn-primary" v-if="!editModal">Crear</button>
                </form>
            </div>
        </div>
    </div>
</template>


<script setup>
import { useStore } from 'vuex'
import { computed } from 'vue';
import Constant from '../../../Constant';

const props = defineProps({
    data: {
        type: Object,
        default: () => ({
            date_booking: "",
            people: "",
            id_user: "",
            id_rest: "",
            id_turn: ""
        })
    },
    editModal: {
        type: Boolean,
        default: false
    }
});

const store = useStore();

store.dispatch('restaurant/' + Constant.GET_ALL_RESTAURANTS)

const restaurants = computed(() => store.getters['restaurant/restaurants']);

store.dispatch('user_admin/' + Constant.GET_ALL_USERS)

const users= computed(() => store.getters['user_admin/users']);

store.dispatch('booking_admin/' + Constant.GET_ALL_TURNS)

const turns= computed(() => store.getters['booking_admin/turns']);


const formData = () => {
    return {
        date_booking: props.data.date_booking,
        people: props.data.people,
        id_user: props.data.id_user,
        id_rest: props.data.id_rest,
        id_turn: props.data.id_turn,
    }
}

const submitForm = async () => {
    await store.dispatch('booking_admin/' + Constant.ADD_BOOKING, formData())
    props.data.date_booking = "";
    props.data.people = "";
    props.data.id_user = "";
    props.data.id_rest = "";
    props.data.id_turn = "";
}

</script>


<style></style>