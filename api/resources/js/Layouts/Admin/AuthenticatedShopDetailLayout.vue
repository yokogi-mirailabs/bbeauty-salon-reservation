<script setup>
import { ref } from 'vue';

const shopId = ref(sessionStorage.getItem('shopId'));

const routes = [
    {
        name: 'メニュー一覧',
        path: route('admin.menus.index', { shop: shopId.value }),
    },
    {
        name: 'スタイリスト一覧',
        path: route('admin.stylists.index', { shop: shopId.value }),
    },
    {
        name: '顧客一覧',
        // path: route('admin.shops.create'),
    },
    {
        name: '分析',
        path: route('admin.analyze', { shop: shopId.value }),
    },
]
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
        </v-navigation-drawer>

        <v-main>
        <v-container>
            <slot />
        </v-container>
        </v-main>

        <v-bottom-navigation>
        Button Navigation
        </v-bottom-navigation>

    </v-app>
</template>
