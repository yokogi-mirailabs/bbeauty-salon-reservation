<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';

const shopId = ref(sessionStorage.getItem('shopId'));
console.log(shopId.value);

const routes = [
    {
        name: '過去の予約',
        path: route('reservations.index', { shop: shopId.value }),
    },
    {
        name: '予約する',
        path: route('reservations.calendar', { shop: shopId.value }),
    },
    {
        name: 'マイレビュー',
        path: route('reviews.index', { shop: shopId.value }),
    },
    {
        name: '事前相談',
        path: route('message_histories.index', { shop: shopId.value }),
    },
    {
        name: 'ポイントカード',
        path: route('point_cards.index', { shop: shopId.value }),
    },
]
const form = useForm({})
const logout = () => {
    form.post(route('logout'), {
        onSuccess: () => {
            window.location.href = route('login');
        },
    });
}
</script>

<template>
    <v-app>
        <v-app-bar color="pink-lighten-5">
        <v-app-bar-title>
            Beauty Salon Reservation
        </v-app-bar-title>
        </v-app-bar>

        <v-navigation-drawer permanent>
            <v-divider></v-divider>
            <v-list-item v-for="(route, index) in routes" link :title=route.name :href="route.path"></v-list-item>
            <template v-slot:append>
                <div class="pa-2">
                <v-btn block @click="logout">
                    Logout
                </v-btn>
                </div>
            </template>
        </v-navigation-drawer>

        <v-main>
        <v-container>
            <slot />
        </v-container>
        </v-main>

    </v-app>
</template>
