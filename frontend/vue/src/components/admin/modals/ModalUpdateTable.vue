<template>
    <div class="modal-update-table">
        <button type="button" class="btn btn-primary btn-lg" data-bs-toggle="modal"
            :data-bs-target="'#modalUpdate' + tab.id_table">
            <font-awesome-icon icon="pen-to-square" />
        </button>

        <div class="modal fade" :id="'modalUpdate' + tab.id_table" tabindex="-1" role="dialog"
            :aria-labelledby="'modalTitleUpdate' + tab.id_table" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" :id="'modalTitleUpdate' + tab.id_table">Actualizar Mesa</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <CreateTable :data="tab" :editModal="true"/>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal" @click="updateTable()">Actualizar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import CreateTable from '../forms/CreateTable.vue'

const props = defineProps([
    'table',
]);

const tab = ref({...props.table})

const emit = defineEmits();

const formData = () => {
    return {
        id_table: tab.value.id_table,
        number_table: tab.value.num_table,
        capacity_table: tab.value.capacity_table,
        status_table: tab.value.status_table
    }
}

const updateTable = () => {
  emit('updateTable', formData());
};

</script>

<style></style>