<template>
    <div class="createUser">
        <div class="card">
            <div class="card-header" v-if="!editModal">
                <h4>Create User</h4>
            </div>
            <div class="card-body">
                <form @submit.prevent="submitForm">
                    <div class="mb-3">
                        <label for="username" class="form-label">Nombre del Usuario</label>
                        <input v-model="data.username" type="text" class="form-control" id="username" required>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password del Usuario</label>
                        <input v-model="data.password" type="password" class="form-control" id="password" required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email del Usuario</label>
                        <input v-model="data.email" type="text" class="form-control" id="email" required>
                    </div>

                    <div class="mb-3">
                        <label for="typeUser" class="form-label">Permisos del Usuario</label>
                        <select v-model="data.typeUser" name="" class="form-control" id="typeUser">
                            <option value="admin">Admin</option>
                            <option value="client">Client</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="photo" class="form-label">URL de la Imagen del Usuario</label>
                        <input v-model="data.photo" type="url" class="form-control" id="photo" required>
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
            username: "",
            password: "",
            email: "",
            typeUser: "client",
            photo: ""
        })
    },
    editModal: {
        type: Boolean,
        default: false
    }
});

const store = useStore();


const formData = () => {
    return {
        username: props.data.username,
        password: props.data.password,
        email: props.data.email,
        typeUser: props.data.typeUser,
        photo: props.data.photo,
    }
}

const submitForm = async () => {
    await store.dispatch('user_admin/' + Constant.ADD_USER, formData())
    props.data.username = "";
    props.data.password = "";
    props.data.email = "";
    props.data.typeUser = "";
    props.data.photo = "";
}

</script>


<style></style>