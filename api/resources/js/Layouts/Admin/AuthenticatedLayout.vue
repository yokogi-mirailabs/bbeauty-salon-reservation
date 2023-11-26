<script setup>
import { ref } from 'vue';

const routes = [
    {
        name: '店舗一覧',
        path: route('admin.shop.index'),
    },
    {
        name: '店舗新規登録',
        path: route('admin.shop.create'),
    },
]
</script>

<template>
<v-app>
    <v-app-bar color="pink-lighten-5">
    <v-app-bar-title>
        Application Bar
    </v-app-bar-title>
    </v-app-bar>

    <v-navigation-drawer permanent>
        <v-divider></v-divider>
        <v-list-item v-for="(route, index) in routes" :key="route.name" link :title="route.name" :href="route.path" />
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
