<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';

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
        name: '分析',
        path: route('admin.analyze', { shop: shopId.value }),
    },
    {
        name: '事前相談',
        path: route('admin.message_histories.index', { shop: shopId.value }),
    },
]
const form = useForm({})
const logout = () => {
    form.post(route('admin.logout'), {
        onSuccess: () => {
            window.location.href = route('admin.login');
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
