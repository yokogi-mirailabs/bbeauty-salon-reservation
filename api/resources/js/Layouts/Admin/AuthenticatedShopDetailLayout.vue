<script setup>
import { ref } from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { Link } from '@inertiajs/vue3';

const showingNavigationDropdown = ref(false);
const routes = [
    {
        name: 'メニュー',
    },
    {
        name: 'スタイリスト',
    },
    {
        name: '顧客',
    },
    {
        name: '分析',
    },
]
</script>

<template>
<v-app>
    <v-app-bar color="pink-lighten-4">
    <v-app-bar-title>
        Application Bar
    </v-app-bar-title>
    </v-app-bar>

    <v-navigation-drawer permanent>
        <v-list-item title="My Application" subtitle="Vuetify"></v-list-item>
        <v-divider></v-divider>
        <v-list-item v-for="(route, index) in routes" link :title=route.name></v-list-item>
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
