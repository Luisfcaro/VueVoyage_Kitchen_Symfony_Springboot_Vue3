<template>
    <v-stage :config="stageConfig" ref="stage">
        <v-layer>
            <v-rect v-for="(table, index) in tables" :key="index" :x="table.x" :y="table.y" width="50" height="50"
                fill="green" draggable="true" @dragmove="handleDragMove(index)" />
        </v-layer>
    </v-stage>
</template>
  
<script setup>
import { ref } from 'vue';

const stageConfig = {
    width: 800,
    height: 600,
};

const tables = ref([
    { x: 100, y: 100 },
    { x: 200, y: 200 },
    // Agrega más mesas según sea necesario
]);

const handleDragMove = (index) => {
    const table = tables.value[index];
    table.x = $refs.stage.getNode().getChild(index).x();
    table.y = $refs.stage.getNode().getChild(index).y();
};
</script>
  
<style>
/* Estilos opcionales */
</style>
  