<template>
    <div class="modal-delete-table">
        <button type="button" class="btn btn-danger btn-lg" data-bs-toggle="modal"
            :data-bs-target="'#modal' + table.id_table">
            <font-awesome-icon icon="trash" />
        </button>

        <div class="modal fade" :id="'modal' + table.id_table" tabindex="-1" role="dialog"
            :aria-labelledby="'modalTitle' + table.id_table" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" :id="'modalTitle' + table.id_table">Eliminar Mesa</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Mesa Nº {{ table.num_table }}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal" @click="deleteTable()">Eliminar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
const props = defineProps([
    'table',
]);

const emit = defineEmits();

const deleteTable = () => {
  emit('deleteTable', props.table.id_table);
};

</script>

<style></style>