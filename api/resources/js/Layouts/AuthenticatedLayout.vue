<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';

const routes = [
    {
        name: '店舗一覧',
        path: route('shops.index'),
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
        <v-list-item v-for="(route, index) in routes" :key="route.name" link :title="route.name" :href="route.path" />
        <template v-slot:append>
            <div class="pa-2">
            <v-btn block @click="logout">
                ログアウト
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
