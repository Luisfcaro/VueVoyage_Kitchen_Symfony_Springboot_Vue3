<template>

    <section class="wrapper">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-md-6 col-lg-4 mb-4" v-for="(restaurant, index) in restaurants" :key="index">
                    <CardRestaurant_client :restaurant="restaurant" />
                </div>
            </div>
            <InfiniteLoading @infinite="scroll" :distance="1" >
                <template v-slot:no-more>
                    <div class="no-more-message">
                    <p>Todos los datos han sido cargados</p>
                    </div>
                </template>
            </InfiniteLoading>
        </div>
    </section>

</template>


<script setup>
    import InfiniteLoading from 'v3-infinite-loading';
    import { useRoute, useRouter } from 'vue-router';
    import { getCurrentInstance, ref } from 'vue';

    import CardRestaurant_client from '../cards/CardRestaurant_client.vue';

    const router = useRouter()
    const route = useRoute()

    const props = defineProps([
        'restaurants'
    ]);

    const emit = defineEmits([
        'limitNew'
    ]);

    let limitNew = ref(0);

    const scroll = ($state) => {
        limitNew.value++;

    if (limitNew.value <= 6) {
      emit('limitNew', limitNew.value);
      // Supongamos que esta función carga más datos
      loadMoreData(); // Esta función debería cargar más datos y luego llamar a $state.loaded()
    } else {
      $state.complete(); // Esto indicará que no hay más datos para cargar
    }
  };



</script>

<style scoped lang="scss">
@import 'v3-infinite-loading/lib/style.css';

    body{
    /* Created with https://www.css-gradient.com */
    background: #201e1e;
    }
    h1{
    color:#fff;
    }
    .lead{
    color:#aaa;
    }

    .wrapper{margin:10vh}
    //post card styles


    .no-more-message {
    padding: 20px;
    background-color: #f8f9fa; /* Un color de fondo gris claro */
    color: #343a40; /* Un color de texto oscuro */
    text-align: center; /* Centrar el texto horizontalmente */
    border-top: 1px solid #dee2e6; /* Una línea superior para separar del contenido */
    font-size: 16px; /* Tamaño de fuente */
    font-weight: bold; /* Texto en negrita */
}


</style>