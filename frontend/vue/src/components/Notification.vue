<template>
    <div :class="['alert', 'notification', type]" role="alert">
        {{ message }}
    </div>
</template>
  
<script>
export default {
    props: {
        type: String,
        message: String
    }
};
</script>
  
<style scoped>
.notification {
    position: fixed;
    top: 10px;
    right: 10px;
    padding: 10px;
    border-radius: 5px;
    font-size: 16px;
    z-index: 9999;
    width: 300px;
    /* ajusta según tus necesidades */
    animation: slideIn 0.5s ease-out;
    /* Animación de entrada desde arriba */
}

.success {
    background-color: #d4edda;
    border-color: #c3e6cb;
    color: #155724;
}

.error {
    background-color: #f8d7da;
    border-color: #f5c6cb;
    color: #721c24;
}

@keyframes slideIn {
    from {
        transform: translateY(-100%);
    }

    to {
        transform: translateY(0);
    }
}
</style>
  