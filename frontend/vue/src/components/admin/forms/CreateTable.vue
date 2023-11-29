<template>
    <div class="createTable">
        <div class="card">
            <div class="card-header" v-if="!editModal">
                <h4>Create Table</h4>
            </div>
            <div class="card-body">
                <form @submit.prevent="submitForm">
                    <div class="mb-3">
                        <label for="num_table" class="form-label">Numero de la Mesa</label>
                        <input v-model="data.num_table" type="number" class="form-control" id="num_table" required>
                    </div>

                    <div class="mb-3">
                        <label for="capacity_table" class="form-label">Capacidad de la mesa</label>
                        <input v-model="data.capacity_table" type="number" class="form-control" id="capacity_table" min="0"
                            max="10" required>
                    </div>

                    <div class="mb-3">
                        <label for="status_table" class="form-label">Estado de la mesa</label>
                        <input v-model="data.status_table" type="text" class="form-control" id="status_table" required>
                    </div>

                    <button type="submit" class="btn btn-primary" v-if="!editModal">Crear</button>
                </form>
            </div>
        </div>
    </div>
</template>
  
<script setup>
import { useStore } from 'vuex'
import Constant from '../../../Constant';

const props = defineProps({
    data: {
        type: Object,
        default: () => ({
            num_table: "",
            capacity_table: "",
            status_table: ""
        })
    },
    idRestaurant: {
        type: String
    },
    editModal: {
        type: Boolean,
        default: false
    }
});

const store = useStore();

const formData = () => {
    return {
        id_rest: props.idRestaurant,
        number_table: props.data.num_table,
        capacity_table: props.data.capacity_table,
        status_table: props.data.status_table
    }
}

const submitForm = async () => {
    await store.dispatch('restaurant/' + Constant.ADD_TABLE, formData())
        .then((data) => {
            if(data === true){
                console.log("insertado");
            } else {
                console.log("error al añadir mesa");
            }
        })
    props.data.num_table = "";
    props.data.capacity_table = "";
    props.data.status_table = "";
};
</script>
  
<style></style>
  