<template>
    <div class="listTables">
        <div class="card">
            <div class="card-header">
                <h4>List Tables</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-6 col-md-4 col-lg-3 mb-4" v-for="(table, index) in tables" :key="index">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Table Nº {{ table.num_table }}</h4>
                                <p class="card-text">{{ table.capacity_table }}</p>
                                <p class="card-text">{{ table.status_table }}</p>
                                <div class="d-flex justify-content-around">
                                    <ModalDeleteTable :table="table" @deleteTable="deleteTable($event)" />
                                    <ModalUpdateTable :table="table" @updateTable="updateTable($event)" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import ModalDeleteTable from '../modals/ModalDeleteTable.vue';
import ModalUpdateTable from '../modals/ModalUpdateTable.vue';

const props = defineProps([
    'idRestaurant',
    'tables'
]);

const emit = defineEmits();

const deleteTable = (idTable) => {
    emit('deleteTable', idTable);
};

const updateTable = (table) => {
    emit('updateTable', table);
};
</script>

<style></style>