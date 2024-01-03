<template>
    <div class="modal-update-user" v-if="Object.entries(user).length !== 0">
        <button type="button" class="btn btn-primary btn-lg" data-bs-toggle="modal"
            :data-bs-target="'#modalUpdate' + user.id">
            <font-awesome-icon icon="pen-to-square" />
        </button>

        <div class="modal fade" :id="'modalUpdate' + user.id" tabindex="-1" role="dialog"
            :aria-labelledby="'modalTitleUpdate' + user.id" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-sm" role="document">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" :id="'modalTitleUpdate' + user.id">Actualizar Usuario</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <CreateUser :data="user" :editModal="true" />
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal"
                            @click="updateUser()">Actualizar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>


<script setup>
import { computed, reactive, ref } from 'vue';
import CreateUser from '../forms/CreateUser.vue';

const props = defineProps([
    'dataUser',
]);

const user = computed(() => ({ ...props.dataUser }));


const emit = defineEmits();

const formData = () => {
    return {
        id: user.value.id,
        username: user.value.username,
        password: user.value.password,
        email: user.value.email,
        typeUser: user.value.typeUser,
        photo: user.value.photo,
    }
}

const updateUser = () => {
    emit('updateUser', formData());
};

</script>

<style></style>