<template>
    <div class="modal-delete-user" v-if="Object.entries(user).length !== 0">
        <button type="button" class="btn btn-danger btn-lg" data-bs-toggle="modal"
            :data-bs-target="'#modalDelete' + user.id">
            <font-awesome-icon icon="trash" />
        </button>

        <div class="modal fade" :id="'modalDelete' + user.id" tabindex="-1" role="dialog"
            :aria-labelledby="'modalTitleDelete' + user.id" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-sm" role="document">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" :id="'modalTitleDelete' + user.id">Eliminar Usuario</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Usuario: {{ user.username }}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal"
                            @click="deleteUser()">Eliminar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>


<script setup>
import { computed, reactive, ref } from 'vue';

const props = defineProps([
    'dataUser',
]);

const user = computed(() => ({ ...props.dataUser }));


const formData = () => {
    return {
        id: user.value.id,
        username: user.value.username,
    }
}

const emit = defineEmits();


const deleteUser = () => {
    emit('deleteUser', formData());
};

</script>

<style></style>