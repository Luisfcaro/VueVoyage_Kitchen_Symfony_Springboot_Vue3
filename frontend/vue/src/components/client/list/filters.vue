<template>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="form-check col-sm-3 col-md-3" v-for="(category, index) in state.categories" :key="index">
                    <input class="form-check-input" type="checkbox" :value="category.id"
                        v-model="state.filters.categories" />
                    <label class="form-check-label" for="">{{ category.name }}</label>
                </div>
            </div>

            <div class="mb-2">
                <label for="" class="form-label">Order</label>
                <select class="form-select form-select-lg" name="" id="" v-model="state.filters.order">
                    <option value="0">Desc</option>
                    <option value="1">Asc</option>
                </select>
            </div>
        </div>
        <div class="d-grid gap-2">
            <button type="button" name="" id="" class="btn btn-primary" @click="sendFilters()">Aplicar Filtros</button>
            <button type="button" name="" id="" class="btn btn-primary" @click="deleteFilters()">Limpiar Filtros</button>
        </div>
        
    </div>
</template>


<script setup>
import { reactive, computed } from 'vue';
import { useStore } from 'vuex'
import Constant from '../../../Constant';

const store = useStore();


store.dispatch('restaurant_client/' + Constant.GET_ALL_CATEGORIES_CLIENT)

const props = defineProps([
    'filters'
]);

const emit = defineEmits([
    'filters_apply',
    'deleteFilters'
]);

const state = reactive({
    categories: computed(() => store.getters['restaurant_client/categories']),
    filters: { ...props.filters }
});


const deleteFilters = () => {
    state.filters.categories = [];
    state.filters.name_rest = '';
    state.filters.order = 0;
    state.filters.page = 1;
    state.filters.limit = 4;
    emit('deleteFilters', state.filters);
}

const sendFilters = () => {
    emit('filters_apply', state.filters);
}//sendFilters

</script>


<style scoped lang="scss">
.card-body {
    display: flex;
    justify-content: space-evenly;
    align-items: center;
}

.card {
    background-color: #f8f9fa;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    padding: 20px;
    margin: 20px 0;

    .card-body {
        display: flex;
        flex-direction: row;
        justify-content: space-between; // Espacio entre las casillas de verificación y el selector
        align-items: flex-start; // Alinea los elementos al inicio de su contenedor

        .row {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            flex-grow: 1; // Ocupar todo el espacio disponible

            .form-check {
                flex: 1 1 auto;
                margin-bottom: 0;

                .form-check-input {
                    cursor: pointer;
                }
            }
        }

        .mb-2 {
            margin-left: 20px; // Espacio adicional entre las casillas y el selector

            .form-label {
                font-weight: bold;
                margin-bottom: 5px;
                display: block; // Asegura que la etiqueta se muestre en su propia línea
            }

            .form-select {
                cursor: pointer;
                height: 50px;
                border-radius: 5px;

                &:focus {
                    border-color: #007bff;
                    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
                }
            }
        }
    }
}
</style>