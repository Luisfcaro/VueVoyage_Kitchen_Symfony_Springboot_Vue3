<template>
    <div class="listUsers">
        <div class="card">
            <div class="card-header">
                <h4>List Users</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-6 col-md-4 col-lg-3 mb-4" v-for="(user, index) in users" :key="index">
                        <CardUser :user="user" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import CardUser from '../cards/CardUser.vue';

const props = defineProps([
    'users'
]);

</script>

<style>

</style>