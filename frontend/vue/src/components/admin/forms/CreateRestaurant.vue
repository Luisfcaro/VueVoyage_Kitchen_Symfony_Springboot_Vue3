<template>
    <div class="createRestaurant">
        <div class="card">
            <div class="card-header">
                <h4 v-if="Object.entries(data).length === 0">Create Restaurant</h4>
                <h4 v-else>Update Restaurant</h4>
            </div>
            <div class="card-body">
                <form @submit.prevent="submitForm">
                    <div class="mb-3">
                        <label for="name_rest" class="form-label">Nombre del Restaurante</label>
                        <input v-model="data.name_rest" type="text" class="form-control" id="name_rest" required>
                    </div>

                    <div class="mb-3">
                        <label for="img_rest" class="form-label">URL de la Imagen del Restaurante</label>
                        <input v-model="data.img_rest" type="url" class="form-control" id="img_rest" required>
                    </div>

                    <div class="mb-3">
                        <label for="location_rest" class="form-label">Ubicación del Restaurante</label>
                        <input v-model="data.location_rest" type="text" class="form-control" id="location_rest" required>
                    </div>

                    <button type="submit" class="btn btn-primary">{{props.edit ? 'Guardar' : 'Enviar'}}</button>
                </form>
            </div>
        </div>
    </div>
</template>
  
<script setup>
import { ref } from 'vue';
import { useStore } from 'vuex'
import Constant from '../../../Constant';

const props = defineProps({
    data: {
        type: Object,
        default: () => ({
            name_rest: "",
            img_rest: "",
            location_rest: ""
        })
    },
    edit: {
        type: Boolean,
        default: false
    }
});

const store = useStore();

const formData = (edit = false) => {
    return {
        id_rest: edit ? props.data.id_rest : null,
        name_rest: props.data.name_rest,
        img_rest: props.data.img_rest,
        location_rest: props.data.location_rest
    }
}

const submitForm = async () => {
    if (!props.edit) {
        await store.dispatch('restaurant/' + Constant.ADD_RESTAURANT, formData())
        props.data.name_rest = "";
        props.data.img_rest = "";
        props.data.location_rest = "";
    } else {
        await store.dispatch('restaurant/' + Constant.UPDATE_RESTAUNT, formData(true))
    }


};
</script>
  
<style></style>
  