<template>
    <div class="dashboard">
        <div class="row">
            <div class="mt-3">
                <div class="card w-100">
                    <div class="card-header">
                        <h4>DashBoard</h4>
                    </div>
                    <div class="card-body">
                        <CreateRestaurant />
                        <hr>
                        <ListRestaurants />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import CreateRestaurant from '../../components/admin/forms/CreateRestaurant.vue'
import ListRestaurants from '../../components/admin/lists/ListRestaurants.vue'

</script>

<style scoped lang="scss">
.dashboard {
    min-height: 100vh;
    max-width: inherit !important;

    .container.dashboard {
        margin-left: 62px;
        transition: 1s;
        width: inherit;
        margin-top: 45px;

        &.active-sidebar {
            margin-left: 280px;
            margin-top: 0;
        }

        .card {
            h4 {
                margin: 4px;
            }
        }
    }


}
</style>