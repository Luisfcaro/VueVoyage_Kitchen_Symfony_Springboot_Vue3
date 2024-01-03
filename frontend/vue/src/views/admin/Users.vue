<template>
    <div class="users">
        <div class="row">
            <div class="mt-3">
                <div class="card w-100">
                    <div class="card-header">
                        <h4>Dashboard Users</h4>
                    </div>
                    <div class="card-body">
                        <CreateUser />
                        <hr>
                        <ListUsers :users="users" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { computed } from 'vue';
import { useStore } from 'vuex';
import Constant from '../../Constant';
import ListUsers from '../../components/admin/lists/ListUsers.vue';
import CreateUser from '../../components/admin/forms/CreateUser.vue'

const store = useStore();

store.dispatch('user_admin/' + Constant.GET_ALL_USERS)

const users = computed(() => store.getters['user_admin/users']);

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