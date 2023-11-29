<template>
    <div class="modal-update-restaurant" v-if="Object.entries(restaurant).length !== 0">
        <button type="button" class="btn btn-primary btn-lg" data-bs-toggle="modal"
            :data-bs-target="'#modalUpdate' + restaurant.id_rest">
            <font-awesome-icon icon="pen-to-square" />
        </button>

        <div class="modal fade" :id="'modalUpdate' + restaurant.id_rest" tabindex="-1" role="dialog"
            :aria-labelledby="'modalTitleUpdate' + restaurant.id_rest" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-sm" role="document">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" :id="'modalTitleUpdate' + restaurant.id_rest">Actualizar Restaurante</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <CreateRestaurant :data="restaurant" :editModal="true" />
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal"
                            @click="updateRestaurant()">Actualizar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { computed, reactive, ref } from 'vue';
import CreateRestaurant from '../forms/CreateRestaurant.vue';

const props = defineProps([
    'dataRest',
]);

const restaurant = computed(() => ({ ...props.dataRest }));

const emit = defineEmits();

const formData = () => {
    return {
        id_rest: restaurant.value.id_rest,
        name_rest: restaurant.value.name_rest,
        img_rest: restaurant.value.img_rest,
        location_rest: restaurant.value.location_rest
    }
}

const updateRestaurant = () => {
    emit('updateRestaurant', formData());
};

</script>

<style></style>