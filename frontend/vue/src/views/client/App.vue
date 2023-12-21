<script setup>
import Footer from '../../components/client/layout/Footer.vue';
import Header from '../../components/client/layout/Header.vue';

</script>

<template>
    <div class="app">
        <Header />
        <router-view></router-view>
        <Footer />
    </div>
</template>

<style scoped lang="scss"></style>
