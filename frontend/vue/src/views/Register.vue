<template>
    <div class="min-vh-100 d-flex align-items-center">
        <div class="container">
            <div class="row">
                <div class="col-sm-7 mx-auto">
                    <div class="shadow-lg">
                        <div class="d-flex align-items-center py-5">
                            <div class="p-4" id="formPanel">
                                <div class="text-center mb-5">
                                    <h1 class="customHeading h3 text-uppercase">Registro</h1>
                                </div>
                                <div class="custom-form-group">
                                    <label class="text-uppercase" for="username">Username</label>
                                    <input type="text" id="username" class="pb-1" /><span><font-awesome-icon
                                            icon="user" /></span>
                                </div>
                                <div class="custom-form-group mt-3">
                                    <label class="text-uppercase" for="password">Password</label>
                                    <input :type="passBlock ? 'password' : 'text'" id="password" class="pb-1" /><span
                                        class="e" @click="passBlock = !passBlock"><font-awesome-icon
                                            :icon="passBlock ? 'eye-slash' : 'eye'" /></span>
                                </div>
                                <div class="custom-form-group mt-3">
                                    <label class="text-uppercase" for="email">Email</label>
                                    <input type="text" id="email" class="pb-1" /><span><font-awesome-icon
                                            icon="envelope" /></span>
                                </div>
                                <div class="mt-5">
                                    <button class="w-100 p-2 d-block custom-btn">Register</button>
                                </div>
                                <hr>
                                <router-link :to="{ name: 'login' }">Ya tienes cuenta?</router-link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from "vue";
const passBlock = ref(true)
</script>

<style lang="scss" scoped>
.customHeading {
    color: #30c6b0;
}

.custom-form-group label {
    color: #30c6b0;
    font-size: 13px;
    font-weight: bold;
    letter-spacing: 2px;
}

.custom-form-group span {
    width: 32px;
    border-bottom: 1px solid #30c6b0;
    vertical-align: middle;
    color: #30c6b0;
    display: inline;
    padding-bottom: 7px;
}

.custom-form-group input {
    width: calc(100% - 32px);
    border: none;
    border-bottom: 1px solid #30c6b0;
    box-sizing: content-box;
    outline: none;
}

.custom-btn {
    border-radius: 32px;
    background: #30c6b0;
    border: 2px solid transparent;
    color: #fff;
    height: 48px;
}

.custom-btn:hover {
    background: #fff;
    border: none;
    border: 2px solid #30c6b0;
    color: #30c6b0;
}

#formPanel {
    min-width: 280px;
    max-width: 320px;
    width: 100%;
    margin: 0 auto;
}

.objectFit {
    object-fit: cover;
    width: 100%;
    max-width: 320px;
    min-height: 60vh;
    margin: 0 auto
}

#showCursor {
    cursor: pointer
}

.custom-form-group span.e {
    padding-bottom: 6.5px !important;
}

a {
    color: #30c6b0 !important;
}
</style>