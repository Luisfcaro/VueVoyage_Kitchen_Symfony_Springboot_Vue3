<template>
    <div class="createCategory">
        <div class="card">
            <div class="card-header">
                <h4>Create Category</h4>
            </div>
            <div class="card-body">
                <form @submit.prevent="submitForm">
                    <div class="mb-3">
                        <label for="name_cat" class="form-label">Nombre de la Categoria</label>
                        <input v-model="data.name_cat" type="text" class="form-control" id="name_cat" required>
                    </div>

                    <div class="mb-3">
                        <label for="img_cat" class="form-label">URL de la Imagen de la Categoria</label>
                        <input v-model="data.img_cat" type="url" class="form-control" id="img_cat" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Crear</button>
                </form>
            </div>
        </div>
    </div>
</template>
  
<script setup>
import { reactive } from 'vue';
import { useStore } from 'vuex'
import Constant from '../../../Constant';

const store = useStore();

const data = reactive({})

const formData = () => {
    return {
        name_cat: data.name_cat,
        img_cat: data.img_cat,
    }
}

const submitForm = async () => {
    await store.dispatch('restaurant/' + Constant.ADD_CATEGORY, formData())
    data.name_cat = "";
    data.img_cat = "";
};
</script>
  
<style></style>
  