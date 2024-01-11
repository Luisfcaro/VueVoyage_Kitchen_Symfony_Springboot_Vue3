<template>
    <div class="card cardTable" v-if="Object.entries(table).length != 0">
        <div class="card-body">
            <h4 class="card-title">Mesa: {{ table.num_table }}</h4>
            <p class="card-text">Capacidad: {{ table.capacity_table }}</p>
        </div>

        <slot></slot>
    </div>
</template>

<script setup>
const props = defineProps([
    'table'
]);
</script>

<style scoped lang="scss">
.cardTable {
    min-height: 215px;

    img {
        max-width: 100%;
        max-height: 150px;
        margin: auto;
        display: block;
    }
}
</style>