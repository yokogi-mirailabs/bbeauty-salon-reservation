<script setup>
import AuthenticatedShopDetailLayout from '@/Layouts/AuthenticatedShopDetailLayout.vue';
import { START_TIME_TYPE, START_TIME_TYPE_TEXT } from '@/Consts/startTimeType';
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
    reservations: {
        type: Array,
        required: true,
    },
    routeParams: {
        type: Object,
        required: true,
    },
});
const form = useForm({});
const menus = (reservation) => {
    return reservation.payment_histories.map((payment) => {
        return payment.menu;
    })
}
</script>
<template>
    <AuthenticatedShopDetailLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">過去の予約</h2>
        </template>

        <v-card v-for="(reservation, index) in props.reservations" :key="reservation.id" elevation="3" class="mb-3 mx-auto" style="max-width: 600px;">
            <v-toolbar color="pink-lighten-5" flat />
            <v-card-text>
                <v-row>
                    <v-col cols="4">
                        <v-list-subheader>店舗名</v-list-subheader>
                    </v-col>
                    <v-col cols="8">
                        <div class="text-subtitle-1">{{ reservation.shop.name }}</div>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col cols="4">
                        <v-list-subheader>担当スタイリスト</v-list-subheader>
                    </v-col>
                    <v-col cols="8">
                        <div class="text-subtitle-1">{{ reservation.stylist.name }}</div>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col cols="4">
                        <v-list-subheader>開始時刻</v-list-subheader>
                    </v-col>
                    <v-col cols="8">
                        <div class="text-subtitle-1">{{ START_TIME_TYPE_TEXT[reservation.start_time_type] }}</div>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col cols="3">
                        <v-list-subheader>注文内容</v-list-subheader>
                    </v-col>
                    <v-col cols="9">
                        <v-row v-for="(menu, index) in menus(reservation)">
                            <v-col cols="4">
                                <v-list-subheader>{{ menu.name }}</v-list-subheader>
                            </v-col>
                            <v-col cols="8">
                                <v-list-item>
                                    <v-list-item-title>{{ menu.price}}円</v-list-item-title>
                                </v-list-item>
                            </v-col>
                        </v-row>
                    </v-col>
                </v-row>
            </v-card-text>
        </v-card>
    </AuthenticatedShopDetailLayout>
</template>