<script setup>
import AuthenticatedShopDetailLayout from '@/Layouts/AuthenticatedShopDetailLayout.vue';
import { mdiCheckboxMarked } from '@mdi/js'

const props = defineProps({
    notifications: {
        type: Array,
        required: true,
    },
    routeParams: {
        type: Object,
        required: true,
    },
});
console.log(props.notifications)
console.log(props.notifications.data)
</script>

<template>
    <AuthenticatedShopDetailLayout>
        <v-card
                class="mx-auto"
            >
            <v-list-item
                v-for="(notification, i) in props.notifications"
                :key="i"
                :value="notification"
                color="primary"
            >
                <v-list-item-title v-text="notification.data.content"></v-list-item-title>
            </v-list-item>
        </v-card>
    </AuthenticatedShopDetailLayout>
</template>