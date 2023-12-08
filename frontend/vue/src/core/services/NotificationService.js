import { ref } from 'vue';

const notifications = ref([]);

function addNotification(type, message) {
    notifications.value.push({ type, message });

    // Eliminar la notificación después de unos segundos (ajustable según tus necesidades)
    setTimeout(() => {
        removeNotification();
    }, 5000);
}

function removeNotification() {
    notifications.value.shift();
}

export default {
    notifications,
    addNotification,
    removeNotification
};