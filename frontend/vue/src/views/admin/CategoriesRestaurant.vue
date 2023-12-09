<template>
    <div class="categories">
        <div class="row">
            <div class="mt-3">
                <div class="card w-100">
                    <div class="card-header">
                        <h4>Categories</h4>
                    </div>
                    <div class="card-body">
                        <div class="card">
                            <div class="card-header">
                                <h4>Their categories</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-6 col-md-4 col-lg-3 mb-4"
                                        v-for="(category, index) in state.restaurant.categories" :key="index">
                                        <CardCategory :category="category">

                                            <button type="button" class="btn btn-danger btn-lg" data-bs-toggle="modal"
                                                :data-bs-target="'#modalDeleteCategoryRestaurant' + index">
                                                <font-awesome-icon icon="trash" />
                                            </button>

                                            <div class="modal fade" :id="'modalDeleteCategoryRestaurant' + index"
                                                tabindex="-1" role="dialog"
                                                :aria-labelledby="'modalDeleteCategoryRestaurantTitle' + index"
                                                aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-sm"
                                                    role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title"
                                                                :id="'modalDeleteCategoryRestaurantTitle' + index">
                                                                Eliminar Categoria de tu Restaurante</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Eliminar categoria: {{ category.name_cat }}
                                                            <p>{{ category.desc_rest_cat }}</p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Close</button>
                                                            <button type="button" class="btn btn-danger"
                                                                data-bs-dismiss="modal"
                                                                @click="removeCategoryRestaurant(category.id)">Eliminar</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </CardCategory>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="card">
                            <div class="card-header">
                                <h4>List Categories</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-6 col-md-4 col-lg-3 mb-4"
                                        v-for="(category, index) in state.categories" :key="index">
                                        <CardCategory :category="category">

                                            <div class=""
                                                v-if="!(state.restaurant.categories.some(objeto => objeto.id === category.id_cat))">
                                                <button type="button" class="btn btn-success btn-lg" data-bs-toggle="modal"
                                                    :data-bs-target="'#modalAddCategoryRestaurant' + index">
                                                    <font-awesome-icon icon="plus" />
                                                </button>

                                                <div class="modal fade" :id="'modalAddCategoryRestaurant' + index"
                                                    tabindex="-1" role="dialog"
                                                    :aria-labelledby="'modalAddCategoryRestaurantTitle' + index"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-sm"
                                                        role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title"
                                                                    :id="'modalAddCategoryRestaurantTitle' + index">
                                                                    Añadir Categoria a tu Restaurante</h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                Categoria: {{ category.name_cat }}
                                                                <div class="mb-3">
                                                                    <label class="form-label">Descripcion</label>
                                                                    <input type="text" class="form-control"
                                                                        aria-describedby="helpId" placeholder=""
                                                                        v-model="description" />
                                                                </div>

                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Close</button>
                                                                <button type="button" class="btn btn-success"
                                                                    data-bs-dismiss="modal"
                                                                    @click="addCategoryRestaurant(category.id_cat)">Añadir</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </CardCategory>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <notification v-for="(notification, index) in notifications" :key="index" :type="notification.type"
            :message="notification.message" />
    </div>
</template>

<script setup>
import { computed, reactive, ref } from 'vue';
import CardCategory from '../../components/admin/cards/CardCategory.vue';
import { useStore } from 'vuex';
import Constant from '../../Constant';
import { useRoute } from 'vue-router';

import NotificationService from '../../core/services/NotificationService';
import Notification from '../../components/Notification.vue';
const notifications = NotificationService.notifications

const store = useStore();
const route = useRoute()

store.dispatch('restaurant/' + Constant.GET_ONE_RESTAURANT, route.params.idRestaurant)
store.dispatch('restaurant/' + Constant.GET_ALL_CATEGORIES)

const state = reactive({
    categories: computed(() => store.getters['restaurant/categories']),
    restaurant: computed(() => store.getters['restaurant/restaurant'])
})

const description = ref()

const removeCategoryRestaurant = async (id) => {
    let data = {
        idRestaurant: route.params.idRestaurant,
        idCategory: id
    }
    await store.dispatch('restaurant/' + Constant.REMOVE_CATEGORY_RESTAURANT, data)
        .then((data) => {
            if (data === true) {
                NotificationService.addNotification('success', 'Operación exitosa');
            } else {
                NotificationService.addNotification('error', 'Ocurrió un error');
            }
        })
}

const addCategoryRestaurant = async (id) => {
    let data = {
        idRestaurant: route.params.idRestaurant,
        category: id,
        description: description.value
    }
    await store.dispatch('restaurant/' + Constant.ADD_CATEGORY_RESTAURANT, data)
        .then((data) => {
            if (data === true) {
                NotificationService.addNotification('success', 'Operación exitosa');
            } else {
                NotificationService.addNotification('error', 'Ocurrió un error');
            }
        })
}

</script>

<style scoped lang="scss">
.categories {

    .categories {
        margin-left: 62px;
        transition: 1s;
        width: inherit;
        margin-top: 45px;

        &.active-sidebar {
            margin-left: 280px;
            margin-top: 0px;
        }
    }
}
</style>